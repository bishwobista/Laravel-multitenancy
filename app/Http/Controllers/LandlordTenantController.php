<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Spatie\Multitenancy\Models\Tenant;
use Illuminate\Http\Request;

class LandlordTenantController extends Controller
{
    public function createTenant(Request $request){

        $validatedData = $request->validate([
            'name' => ['required', 'string'],
            'domain' => ['required', 'string'],
            'database' => ['required', 'string']
        ]);
        $tenant = Tenant::create([
            'name' => $validatedData['name'],
            'domain' => $validatedData['domain'],
            'database' => $validatedData['database']
        ]);

        DB::statement("CREATE DATABASE IF NOT EXISTS $tenant->database");
        config(['database.connections.tenant.database' => $tenant->database]);
        DB::reconnect('tenant');
        Artisan::call('migrate', ['--database' => 'tenant']);


        Artisan::call('db:seed', ['--database' => 'tenant']);

        return response()->json(['message' => 'Tenant created successfully'], 201);


    }
}
