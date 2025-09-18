<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'balance', 'pending_balance', 'total_invested',
        'total_returns', 'total_withdrawn'
    ];

    protected $casts = [
        'balance'  => 'decimal:2',
        'pending_balance' => 'decimal:2',
        'total_invested' => 'decimal:2',
        'total_returns' => 'decimal:2',
        'total_withdrawn' => 'decimal:2'    
    ];
}
