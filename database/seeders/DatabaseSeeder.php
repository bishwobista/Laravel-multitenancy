<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Tenants;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Multitenancy\Models\Tenant;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'dave',
            'email' => 'dave@malinator.com',
            'password' => 'Pa$$w0rd!'
        ]);

//        Tenant::checkCurrent()
//            ? $this->runTenantSpecificSeeders()
//            : $this->runLandlordSpecificSeeders();
//        $this->call(LandlordSeeder::class);

//        Tenants::factory()->create([
//            'name' => 'Bishwo',
//            'domain' => 'bishwo.laravel',
//            'database' => 'tenant1'
//        ]);

    }


    public function runTenantSpecificSeeders()
    {
         \App\Models\User::factory()->create([
             'name' => 'dave',
             'email' => 'dave@malinator.com',
             'password' => 'Pa$$w0rd!'
         ]);
    }

    public function runLandlordSpecificSeeders()
    {
        // run landlord specific seeders
    }
}
