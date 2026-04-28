<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'long_description',
        'price',
        'discount_price',
        'category_id',
        'image_url',
        'gallery_images',
        'volume',
        'scent_profile',
        'longevity',
        'projection',
        'notes',
        'in_stock',
        'is_featured',
    ];

    protected $casts = [
        'gallery_images' => 'array',
        'notes' => 'array',
        'in_stock' => 'boolean',
        'is_featured' => 'boolean',
        'price' => 'float',
        'discount_price' => 'float',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getDiscountPercentageAttribute()
    {
        if ($this->discount_price && $this->price) {
            return round((($this->price - $this->discount_price) / $this->price) * 100);
        }
        return 0;
    }
}
