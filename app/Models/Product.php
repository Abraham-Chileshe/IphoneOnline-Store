<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'slug', 'brand', 'description', 'price', 'old_price', 
        'image', 'image_2', 'image_3', 'image_4', 'stock', 'category', 'rating', 'reviews_count', 'is_active',
        'badge_text', 'badge_type'
    ];

    protected static function booted()
    {
        static::creating(function ($product) {
            if (!$product->slug) {
                $product->slug = \Illuminate\Support\Str::slug($product->name) . '-' . uniqid();
            }
        });

        static::deleting(function ($product) {
            // Delete associated wishlist items
            $product->wishlists()->delete();
            // Delete associated cart items
            $product->cartItems()->delete();
        });
    }

    public function getImageUrl($field = 'image')
    {
        $path = $this->$field;
        if (!$path) return asset('images/placeholder.png');
        if (str_starts_with($path, 'http')) return $path;
        
        // If file exists in public/
        if (file_exists(public_path($path))) {
            return asset($path);
        }
        
        // Otherwise assume storage/
        return asset('storage/' . $path);
    }


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
        return $this->badge_text && strtoupper($this->badge_text) === 'GOOD PRICE';
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

    // Currency Logic
    public function getFormattedPriceAttribute()
    {
        return $this->formatPrice($this->price);
    }

    public function getFormattedOldPriceAttribute()
    {
        return $this->old_price ? $this->formatPrice($this->old_price) : null;
    }

    public static function formatPrice($usdAmount)
    {
        $currency = session()->get('currency', 'USD');
        
        if ($currency === 'RUB') {
            $rate = Setting::get('usd_to_rub_rate', 90);
            $amount = $usdAmount * $rate;
            return ' ₽'.number_format($amount, 0, ',', ' ');
        }

        if ($currency === 'AED') {
            $rate = Setting::get('usd_to_aed_rate', 3.67);
            $amount = $usdAmount * $rate;
            return number_format($amount, 2, '.', ' ') . ' AED';
        }

        return '$' . number_format($usdAmount, 2, '.', ' ');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
