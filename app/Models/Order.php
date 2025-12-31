<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_SHIPPED = 'shipped';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_CANCELLED = 'cancelled';
    
    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
        'shipping_address',
        'city',
        'postal_code',
        'phone',
    ];
    
    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    
    public static function getStatuses()
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_PROCESSING => 'Processing',
            self::STATUS_SHIPPED => 'Shipped',
            self::STATUS_DELIVERED => 'Delivered',
            self::STATUS_CANCELLED => 'Cancelled',
        ];
    }
    
    public function getStatusLabelAttribute()
    {
        return self::getStatuses()[$this->status] ?? 'Unknown';
    }
    
    public function canBeCancelled()
    {
        return in_array($this->status, [self::STATUS_PENDING, self::STATUS_PROCESSING]);
    }
    
    public function cancel()
    {
        if (!$this->canBeCancelled()) {
            return false;
        }
        
        // Restore stock
        foreach ($this->items as $item) {
            $item->product->increment('stock', $item->quantity);
        }
        
        $this->update(['status' => self::STATUS_CANCELLED]);
        return true;
    }
}
