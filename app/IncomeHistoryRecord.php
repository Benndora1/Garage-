<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use Illuminate\Foundation\Auth\User as Authenticatable;

class IncomeHistoryRecord extends Model
{
   //For 
	protected $table = 'tbl_income_history_records';

	protected $fillable = ['tbl_income_id','income_amount','income_label'];
}
