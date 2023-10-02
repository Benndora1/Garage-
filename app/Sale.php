<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Sale extends Model
{
    //For 
	protected $table = 'tbl_sales';

	protected $fillable = ['customer_id','bill_no','payment_type_id','date','vehicle_brand','chassisno','status','vehicle_id','registration_no','color_id','quantity','price','total_price','no_of_services','interval','date_gap','salesmanname','assigne_to','custom_field'];
}
