<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RuleCondition;

class Rule extends Model
{
    use HasFactory;

    protected $fillable = [
        'rule_name',
        'apply_tags',
    ];


    // A rule has many conditions
    public function conditions()
    {
        return $this->hasMany(RuleCondition::class);
    }
}
