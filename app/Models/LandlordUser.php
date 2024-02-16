<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;

class LandlordUser extends User
{
    use UsesLandlordConnection, HasFactory;
    protected $guarded = [];
    protected $table = 'users';
}
