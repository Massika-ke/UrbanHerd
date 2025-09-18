<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farm extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'location', 'license_number', 'owner_id',
        'verification_status', 'rating', 'total_animals', 'certifications',
        'facilities', 'is_active'
    ];

    protected $casts = [
        'location' => 'array',
        'certifications' => 'array',
        'facilities' => 'array',
        'rating' => 'decimal:2'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function managers()
    {
        return $this->belongsToMany(User::class, 'farm_managers');
    }

    public function animals()
    {
        return $this->hasMany(Animal::class);
    }

    public function activeAnimals()
    {
        return $this->animals()->where('status', 'active');
    }


}
