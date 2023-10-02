<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use Illuminate\Foundation\Auth\User as Authenticatable;

class ExpenseHistoryRecord extends Model
{
    
    //For 
	protected $table = 'tbl_expenses_history_records';

	protected $fillable = ['tbl_expenses_id','expense_amount','label_expense'];
}
