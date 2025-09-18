<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'animal_id', 'shares_owned', 'purchase_price_per_share',
        'total_amount', 'current_value', 'total_dividends_earned',
        'purchase_date', 'status'
    ];

    protected $casts = [
        'purchase_price_per_share' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'current_value' => 'decimal:2',
        'total_dividends_earned' => 'decimal:2',
        'purchase_date' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    // public function dividends()
    // {
    //     return $this->hasMany(UserDividend::class);
    // }

    public function marketListings()
    {
        return $this->hasMany(MarketListing::class);
    }

    // Accessors
    public function getCurrentReturnAttribute()
    {
        return $this->current_value - $this->total_amount;
    }

    public function getReturnPercentageAttribute()
    {
        if ($this->total_amount == 0) return 0;
        return (($this->current_value - $this->total_amount) / $this->total_amount) * 100;
    }

    public function getTotalReturnAttribute()
    {
        return $this->getCurrentReturnAttribute() + $this->total_dividends_earned;
    }
}
