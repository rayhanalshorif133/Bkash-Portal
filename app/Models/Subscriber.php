<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;

    protected $fillable = [
        'msisdn',
        'payment_id',
        'trx_id',
        'keyword',
        'status',
        'subs_date',
        'unsubs_date',
    ];

    protected $casts = [
        'subs_date' => 'datetime',
        'unsubs_date' => 'datetime',
    ];
}
