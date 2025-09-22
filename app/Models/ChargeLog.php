<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChargeLog extends Model
{
    use HasFactory;

    protected $table = 'charge_logs';

    protected $fillable = [
        'payment_id',
        'msisdn',
        'keyword',
        'amount',
        'type',
        'charge_date',
    ];


    protected $dates = [
        'charge_date',
        'created_at',
        'updated_at',
    ];
}
