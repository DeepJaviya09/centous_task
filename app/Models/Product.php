<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tag;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'product_description',
        'product_price',
        'product_sku',
        'product_qty',
        'product_type',
        'product_vendor',
        'product_image',
    ];

    // A product can have many tags
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tags')
                    ->withTimestamps();
    }
}
