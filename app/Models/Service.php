<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'keyword',
        'type',
        'validity',
        'amount',
        'api_url',
        'redirect_url',
        'description',
    ];

    /**
     * The attributes casted to native types.
     */
    protected $casts = [
        'amount' => 'float',
    ];
}
