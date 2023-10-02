<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Updatekey extends Model
{
    //For 
	protected $table = 'updatekey';

	protected $fillable = ['stripe_id','secret_key','publish_key'];
}
