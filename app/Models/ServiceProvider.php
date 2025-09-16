<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceProvider extends Model
{
    use HasFactory;

    protected $table = 'service_providers';

    protected $fillable = [
        'base_url',
        'app_key',
        'app_secret',
        'mode',
        'username',
        'password',
    ];
}
