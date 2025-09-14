<?php

use App\Http\Controllers\ServiceProviderController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if(Auth::check()){
        return redirect('/home');
    } else {
        return redirect('login');
    }
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'service', 'middleware' => ['auth'], 'as' => 'service.'], function () {
    Route::get('/provider', [ServiceProviderController::class, 'index'])->name('provider');
    Route::put('/provider-update/{type}', [ServiceProviderController::class, 'update'])->name('update');
});

