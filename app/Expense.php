<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Expense extends Model
{
    
    //For 
	protected $table = 'tbl_expenses';

	protected $fillable = ['main_label','status','date','custom_field'];
}
