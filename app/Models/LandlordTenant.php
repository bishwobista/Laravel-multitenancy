<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandlordTenant extends Model
{
    use HasFactory;

    public function createTenant(){
        dd('1');
    }
}
