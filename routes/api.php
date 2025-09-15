<?php

use App\Http\Controllers\Api\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// https://gpglobal.b2mwap.com/api/subscription?keyword=GSD&msisdn=8801701677479&success_url=https://www.google.com/&failed_url=https://www.google.com/

Route::get('/subscription', [PaymentController::class, 'subscription']);
