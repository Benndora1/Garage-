<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Vehicletype extends Model
{
    //
    protected $table = 'tbl_vehicle_types';
}
