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





// https://bkash.baisbd.com/api/payment?keyword=APP-S&msisdn=10202



Route::get('/payment', [PaymentController::class, 'payment']);
Route::get('/payment-execute/{payment_id}', [PaymentController::class, 'executePayment']);
Route::get('/payment-query/{payment_id}', [PaymentController::class, 'queryPayment']);
