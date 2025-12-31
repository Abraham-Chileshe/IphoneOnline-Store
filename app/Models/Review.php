<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'title',
        'comment',
        'verified_purchase',
        'helpful_count',
    ];
    
    protected $casts = [
        'verified_purchase' => 'boolean',
        'rating' => 'integer',
        'helpful_count' => 'integer',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    public function getStarsArrayAttribute()
    {
        return range(1, 5);
    }
}
