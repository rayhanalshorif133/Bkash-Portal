<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    // Fillable fields for mass assignment
    protected $fillable = [
        'msisdn',
        'amount',
        'currency',
        'keyword',
        'hash',
        'intent',
        'merchant_invoice_number',
        'create_time',
        'org_logo',
        'org_name',
        'payment_id',
        'transaction_status',
    ];
}
