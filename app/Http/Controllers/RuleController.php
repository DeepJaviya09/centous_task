<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rule;
use App\Models\RuleCondition;
use App\Models\Product;
use App\Models\Tag;

class RuleController extends Controller
{
    /**
     * Display a listing of rules.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $rules = Rule::with('conditions')->get();
        // dd($rules);
        return view('rules.index', compact('rules'));
    }

    /**
     * Store a newly created rule in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'rule_name'  => 'required|string|max:255',
            'apply_tags' => 'required|string',
            'conditions' => 'required|array|min:1',
        ]);

        $rule = Rule::create([
            'rule_name'  => $request->rule_name,
            'apply_tags' => $request->apply_tags,
        ]);

        foreach ($request->conditions as $condition) {
            RuleCondition::create([
                'rule_id'       => $rule->id,
                'product_field' => $condition['product_field'],
                'operator'      => $condition['operator'],
                'value'         => $condition['value'],
            ]);
        }

        return redirect()->route('rules.index')->with('success', 'Rule created successfully!');
    }

    /**
     * Apply a rule to all products.
     *
     * @param  Rule $rule
     * @return \Illuminate\Http\RedirectResponse
     */
    public function applyRule(Rule $rule)
    {
        try {
            $tags = array_map('trim', explode(',', $rule->apply_tags));
            foreach (Product::all() as $product) {
                $matches = true;
    
                foreach ($rule->conditions as $condition) {
                    $field = 'product_' . $condition->product_field;
                    $productValue = $product->$field;
    
                    switch ($condition->operator) {
                        case '==': $check = $productValue == $condition->value; break;
                        case '>':  $check = $productValue > $condition->value; break;
                        case '<':  $check = $productValue < $condition->value; break;
                        default:   $check = false;
                    }
                    if (!$check) {
                        $matches = false;
                        break;
                    }
                }
    
                if ($matches) {
                    foreach ($tags as $tagName) {
                        $tag = Tag::firstOrCreate(['tag_name' => $tagName]);
                        $product->tags()->syncWithoutDetaching([$tag->id]);
                    }
                }
            }
    
            return redirect()->route('rules.index')->with('success', 'Rule applied successfully!');
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            dd('Error applying rule: ' . $th->getMessage());
        }
    }
}
