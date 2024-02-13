<?php

namespace App\Http\Controllers;
use App\Mail\UserFileUpload;
use App\Models\Tenants;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File;
use Spatie\Multitenancy\Models\Tenant;
use Illuminate\Http\Request;

class LandlordTenantController extends Controller
{
    public function createTenant(Request $request){

//        if(app('currentTenant')){
//            return view('welcome', ['tenant' => app('currentTenant')]);
//        }
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
    public function viewTenants()
    {
        $tenants = Tenants::all();
        return view('tenants', compact('tenants'));
    }

    public function viewTenantUser(){
        config(['database.connections.tenant.database' => Tenant::current()->getDatabaseName()]);
        $users = User::all();
        return view('tenantUsers', ['users' => $users]);
    }

    public function fileUpload(Request $request){
        $validator = Validator::make($request->all(),[
            'uploaded_file' => ['required', File::image()]
        ]);
        if ($validator->fails()) {
            return redirect()->route('home')->with('error', $validator->errors()->first());
        }
        $data = $validator->validated();
        $file = $request->file('uploaded_file');
        $tenantId = Tenant::current()->id;
        $fileName = $tenantId . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
//        Storage::disk('local')->put('example.txt', 'Contents');
        $file->storeAs('tenant_'. $tenantId, $fileName);
        $user = User::find(auth()->id());
        $user->image = $fileName;
        $user->save();
        Mail::to($user->email)->send(new UserFileUpload($user));
        return redirect()->route('home')->with('error', 'File uploaded successfully.');
    }

    public function cache(){
        $tenant = Tenant::current();
        $tenant->makeCurrent();
        cache()->put('key', $tenant->getDatabaseName());
    }

    public function getCache(){
        $tenant = Tenant::current();
        $tenant->makeCurrent();
        return cache('key');
    }

}
