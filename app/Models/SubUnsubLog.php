<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubUnsubLog extends Model
{
    use HasFactory;

    protected $table = 'sub_unsub_logs';

    protected $fillable = [
        'msisdn',
        'keyword',
        'status',
        'flag',
        'opt_date',
        'opt_time',
    ];

    protected $dates = [
        'opt_date',
        'created_at',
        'updated_at',
    ];
}
