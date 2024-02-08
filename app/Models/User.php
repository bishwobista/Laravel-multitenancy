<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Spatie\Multitenancy\Models\Tenant;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, UsesTenantConnection ;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public static function create(array $array)
    {
        $currentTenant = Tenant::current();

        // Switch to the tenant's database connection
        config(['database.connections.tenant.database' => $currentTenant->database]);
        DB::purge('tenant');

        // Create the user in the tenant's database
        return static::create([
            'name' => $array['name'],
            'email' => $array['email'],
            'password' => bcrypt($array['password']),
        ]);
    }
}
