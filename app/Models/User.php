<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'kyc_status',
        'is_active' 
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

            // Relationships
    public function profile(){
        return $this->hasOne(UserProfile::class);
    }

    // public function wallet(){
    //     return $this->hasOne(UserWallet::class);
    // }

    public function investments()
    {
        return $this->hasMany(Investment::class);
    }

    public function dividends()
    {
        return $this->hasMany(UserDividend::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function ownedFarms()
    {
        return $this->hasMany(Farm::class, 'owner_id');
    }

    public function managedFarms()
    {
        return $this->belongsToMany(Farm::class, 'farm_managers');
    }

    public function marketListings()
    {
        return $this->hasMany(MarketListing::class, 'seller_id');
    }

    // Accessors

     public function getTotalInvestmentValueAttribute()
    {
        return $this->investments->sum('current_value');
    }

    public function getTotalDividendsEarnedAttribute()
    {
        return $this->dividends->sum('net_amount');
    }

    
}
