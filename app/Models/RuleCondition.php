<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuleCondition extends Model
{
    
    use HasFactory;

    protected $fillable = [
        'rule_id',
        'product_field',
        'operator',
        'value',
    ];

    // Belongs to a rule
    public function rule()
    {
        return $this->belongsTo(Rule::class);
    }
}
