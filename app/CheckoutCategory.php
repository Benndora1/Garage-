<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use Illuminate\Foundation\Auth\User as Authenticatable;

class CheckoutCategory extends Model
{
    //For 
	protected $table = 'tbl_checkout_categories';

	protected $fillable = ['vehicle_id','checkout_point','create_by'];
}
