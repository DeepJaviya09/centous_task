<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'tag_name',
    ];

    // A tag can belong to many products
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_tags')
                    ->withTimestamps();
    }

}
