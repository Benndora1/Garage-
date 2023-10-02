<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use Illuminate\Foundation\Auth\User as Authenticatable;

class PaymentMethod extends Model
{
    //For 
	protected $table = 'tbl_payments';

	protected $fillable = ['payment'];
}
