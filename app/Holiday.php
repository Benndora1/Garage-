<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Holiday extends Model
{
    //For 
	protected $table = 'tbl_holidays';

	protected $fillable = ['title','date','description'];
}
