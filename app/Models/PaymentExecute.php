<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentExecute extends Model
{
    use HasFactory;

    protected $table = 'payment_executes';

    protected $fillable = [
        'paymentID',
        'createTime',
        'updateTime',
        'trxID',
        'transactionStatus',
        'amount',
        'currency',
        'intent',
        'merchantInvoiceNumber',
        'customerMsisdn',
        'maxRefundableAmount',
    ];

    protected $casts = [
        'createTime' => 'datetime',
        'updateTime' => 'datetime',
    ];
}
