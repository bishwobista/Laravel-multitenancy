<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandlordAuthController;
Route::name('landlord.')->group(function () {
    Route::controller(LandlordAuthController::class)->middleware('guest:landlord')->group(function () {
        Route::get('/register', 'register')->name('register');
        Route::post('/store', 'store')->name('store');

        Route::get('login', 'login')->name('login');
        Route::post('/auth', 'auth')->name('auth');
    });

    Route::middleware('auth:landlord')->group(function () {
        Route::get('/dashboard', [LandlordAuthController::class, 'dashboard'])->name('dashboard');
        Route::post('/logout', [LandlordAuthController::class, 'logout'])->name('logout');
    });
});
