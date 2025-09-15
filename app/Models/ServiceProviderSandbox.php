<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceProviderSandbox extends Model
{
    use HasFactory;

    protected $table = 'service_provider_sandboxes';

     protected $fillable = [
        'base_url',
        'app_key',
        'app_secret',
        'username',
        'password',
    ];

}
