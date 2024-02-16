<?php

use App\Http\Controllers\LandlordTenantController;
use Illuminate\Support\Facades\Route;

Route::name('landlord.')->group(function () {
    Route::middleware('auth:landlord')->group(function () {
        Route::post('/create', [LandlordTenantController::class, 'createTenant'])->name('create');
        Route::get('/tenants', [LandlordTenantController::class, 'viewTenants'])->name('viewTenants');
    });
});
