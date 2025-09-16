<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrantToken extends Model
{
    use HasFactory;

    protected $table = 'grant_tokens';
    public $timestamps = false;

    protected $fillable = [
        'msisdn',
        'id_token',
        'expires_in',
        'refresh_token',
        'expire_time',
        'status',
        'mode',
        'msg',
        'created',
    ];

    protected $casts = [
        'expire_time' => 'datetime',
        'created'     => 'datetime',
    ];
}
