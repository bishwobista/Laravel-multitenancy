<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Spatie\Multitenancy\Models\Tenant;
class Tenants extends Tenant
{
    use HasFactory;
    protected $guarded = [];
//    protected $connection = 'landlord';
    private mixed $database;

    protected static function booted()
    {
        static::creating(fn(Tenants $model) => $model->createDatabase());
    }

    public function createDatabase()
    {
        $this->database = $this->getDatabaseName();

        DB::enableQueryLog();
        try {

            DB::statement("create database if not exists $this->database");
        }catch (QueryException $ex){
            dump($ex->getMessage());
        }
        dump(DB::getQueryLog());
        //use connection tenant database
        //"php artisan tenants:artisan "migrate --database=?", $this->db
        //migrate -> seed test user
    }
}
