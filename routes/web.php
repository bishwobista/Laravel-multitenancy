<?php

use App\Http\Controllers\LandlordTenantController;
use Illuminate\Support\Facades\Route;
use Spatie\Multitenancy\Models\Tenant;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    $currentTenant = null;
    if (Tenant::checkCurrent()) {
        $currentTenant = app('currentTenant');
    }
    return view('welcome', ['tenant' => $currentTenant]);
});


Route::middleware('tenant')->group(function (){
    Route::get('/jobs', function(){
       dispatch(new \App\Jobs\TestJob());
    });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::post('/create', [LandlordTenantController::class, 'createTenant'])->name('create');
Route::get('/tenants', [LandlordTenantController::class, 'viewTenants'])->name('viewTenants');

Route::get('/users', [LandlordTenantController::class, 'viewTenantUser'])->name('tenantUsers');


