<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
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
    
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    
    public function averageRating()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }
    
    public function totalReviews()
    {
        return $this->reviews()->count();
    }
    
    // Accessor to get real-time rating from reviews
    public function getRatingAttribute($value)
    {
        // If reviews are already loaded (eager loading), use them
        if ($this->relationLoaded('reviews')) {
            $avgRating = $this->reviews->avg('rating');
            return $avgRating ? round($avgRating, 1) : 0;
        }
        
        // Otherwise query the database
        $avgRating = $this->reviews()->avg('rating');
        return $avgRating ? round($avgRating, 1) : 0;
    }
    
    // Accessor to get real-time review count
    public function getReviewsCountAttribute($value)
    {
        // If reviews are already loaded (eager loading), use them
        if ($this->relationLoaded('reviews')) {
            return $this->reviews->count();
        }
        
        // Otherwise query the database
        return $this->reviews()->count();
    }
}
