<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'title',
        'long_title',
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
    public function skus()
    {
        return $this->hasMany(ProductSku::class);
    }

    public function getImageUrlAttribute()
    {
        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }
        return \Storage::disk('public')->url($this->image);
    }

    public function property()
    {
        return $this->hasMany(ProductProperty::class);
    }

    public function getGroupedPropertiesAttribute()
    {
        return $this->property
            ->groupBy('name')
            ->map(function($properties) {
                return $properties->pluck('value')->all();
            });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
