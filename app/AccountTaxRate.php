<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use Illuminate\Foundation\Auth\User as Authenticatable;

class AccountTaxRate extends Model
{
    //For 
	protected $table = 'tbl_account_tax_rates';

	protected $fillable = ['taxname', 'tax'];
}
