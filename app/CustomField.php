<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use Illuminate\Foundation\Auth\User as Authenticatable;

class CustomField extends Model
{
    //For 
	protected $table = 'tbl_custom_fields';

	protected $fillable = ['form_name','label','type','required','always_visable'];
}
