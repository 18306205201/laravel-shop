<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Boolean;

class Product extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'on_sale',
        'rating',
        'sold_count',
        'review_count',
        'price'
    ];

    protected $casts = [
        'on_sale' => 'boolean'
    ];
    // 与商品Sku关联
    public function sku()
    {
        return $this->hasMany(ProductSku::class);
    }
}