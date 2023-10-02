<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use Illuminate\Foundation\Auth\User as Authenticatable;

class BusinessHour extends Model
{
    //For 
	protected $table = 'tbl_business_hours';

	protected $fillable = ['day','from','to'];
}
