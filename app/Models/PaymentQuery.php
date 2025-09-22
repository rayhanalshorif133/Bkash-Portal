<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentQuery extends Model
{
    use HasFactory;

    protected $table = 'payment_queries';

    protected $fillable = [
        'create_time',
        'update_time',
        'payment_id',
        'trx_id',
        'transaction_status',
        'amount',
        'merchant_invoice_number',
        'customer_msisdn',
        'response',
        'errorMessage',
        'errorCode',
    ];

    protected $casts = [
        'create_time' => 'datetime',
        'update_time' => 'datetime',
        'amount' => 'decimal:2',
    ];
}
