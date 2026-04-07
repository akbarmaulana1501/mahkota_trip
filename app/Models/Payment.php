<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $fillable = [
        'user_id',
        'order_id',
        'amount',
        'bank',
        'va_number',
        'status',
        'expired_at'
    ];

    protected $casts = [
        'expired_at' => 'datetime',
    ];
}
