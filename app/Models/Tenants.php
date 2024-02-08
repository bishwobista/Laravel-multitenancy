<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Spatie\Multitenancy\Models\Tenant;
class Tenants extends Tenant
{
    use HasFactory;
    protected $guarded = [];
//    protected $connection = 'landlord';
    private mixed $databaseName;

    protected static function booted()
    {
        static::creating(fn(Tenants $model) => $model->createDatabase());
    }

    public function createDatabase()
    {
        $databaseName = $this->getDatabaseName();
        DB::statement("create database if not exists $databaseName");
//         config('database.connections.tenant.database')= $databaseName;
//        $this->database = $databaseName;
//        $this->save();
    }
}
