<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'national_id', 'address', 'occupation',
        'monthly_income', 'investment_experience', 'date_of_birth', 'gender',
        'documents'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'documents'=> 'array',
        'monthly_income' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
