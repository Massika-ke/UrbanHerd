<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketListing extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id', 'animal_id', 'investment_id', 'shares_for_sale',
        'asking_price_per_share', 'total_asking_price', 'minimum_sale_shares',
        'description', 'listing_type', 'listing_date', 'expires_at',
        'status', 'shares_sold', 'total_received'
    ];

    protected $casts = [
        'asking_price_per_share' => 'decimal:2',
        'total_asking_price' => 'decimal:2',
        'total_received' => 'decimal:2',
        'listing_date' => 'datetime',
        'expires_at' => 'datetime'
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function investment()
    {
        return $this->belongsTo(Investment::class);
    }

    public function transactions()
    {
        return $this->hasMany(MarketTransaction::class, 'listing_id');
    }

    public function getRemainingSharesAttribute()
    {
        return $this->shares_for_sale - $this->shares_sold;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'active')
                    ->where(function ($q) {
                        $q->whereNull('expires_at')
                          ->orWhere('expires_at', '>', now());
                    });
    }
}
