<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'brand', 'description', 'price', 'old_price', 
        'image', 'image_2', 'image_3', 'image_4', 'stock', 'category', 'rating', 'reviews_count', 'is_active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'old_price' => 'decimal:2',
        'rating' => 'decimal:1',
        'is_active' => 'boolean',
    ];

    public function getDiscountPercentageAttribute()
    {
        if ($this->old_price && $this->old_price > $this->price) {
            return round((($this->old_price - $this->price) / $this->old_price) * 100);
        }
        return 0;
    }

    public function getIsGoodPriceAttribute()
    {
        return $this->discount_percentage >= 10;
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
    
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
    
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
