<?php

use App\Http\Controllers\ServiceProviderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
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
    if (Auth::check()) {
        return redirect('/home');
    } else {
        return redirect('login');
    }
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])
    ->prefix('service')
    ->name('service.')
    ->group(function () {
        Route::resource('/', ServiceController::class);
        Route::controller(ServiceProviderController::class)->group(function () {
            Route::get('/provider', 'index')->name('provider');
            Route::put('/provider-update/{type}', 'update')->name('update');
        });
    });
