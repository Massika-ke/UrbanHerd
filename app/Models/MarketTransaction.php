<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'buyer_id', 'seller_id', 'listing_id', 'animal_id', 'shares_traded',
        'price_per_share', 'total_price', 'platform_commission', 'seller_receives',
        'transaction_reference', 'status', 'completed_at', 'notes'
    ];

    protected $casts = [
        'price_per_share' => 'decimal:2',
        'total_price' => 'decimal:2',
        'platform_commission' => 'decimal:2',
        'seller_receives' => 'decimal:2',
        'completed_at' => 'datetime'
    ];

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function listing()
    {
        return $this->belongsTo(MarketListing::class, 'listing_id');
    }

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
