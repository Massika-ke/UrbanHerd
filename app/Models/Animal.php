<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;

    protected $fillable = [
        'farm_id', 'tag_number', 'animal_type', 'breed', 'age_months',
        'gender', 'weight_kg', 'health_status', 'purchase_price',
        'current_value', 'insurance_value', 'is_breeding',
        'last_health_check', 'medical_history', 'notes', 'status'
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'current_value' => 'decimal:2',
        'insurance_value' => 'decimal:2',
        'weight_kg' => 'decimal:2',
        'last_health_check' => 'date',
        'medical_history' => 'array',
        'is_breeding' => 'boolean'
    ];

    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }

    // public function shares()
    // {
    //     return $this->hasOne(AnimalShare::class);
    // }

    public function investments()
    {
        return $this->hasMany(Investment::class);
    }

    public function media()
    {
        return $this->hasMany(AnimalMedia::class);
    }

    // public function performance()
    // {
    //     return $this->hasMany(AnimalPerformance::class);
    // }

    // public function dividends()
    // {
    //     return $this->hasMany(Dividend::class);
    // }

    public function marketListings()
    {
        return $this->hasMany(MarketListing::class);
    }

    // Accessors
    public function getAvailableSharesAttribute()
    {
        return $this->shares->available_shares ?? 0;
    }

    public function getPrimaryImageAttribute()
    {
        return $this->media()->where('media_type', 'image')->where('is_primary', true)->first();
    }

    public function getAgeInYearsAttribute()
    {
        return round($this->age_months / 12, 1);
    }
}
