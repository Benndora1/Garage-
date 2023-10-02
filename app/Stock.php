<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Stock extends Model
{
 	//
 	protected $table = 'tbl_stock_records';
    
    protected $fillable = ['product_id','supplier_id','no_of_stoke'];

	public function scopeGetByUser($query, $id) 
	{
        $role = getUsersRole(Auth::User()->role_id);
        if (isAdmin(Auth::User()->role_id)) 
        {
            return $query;
        } 
        else 
        {
            return $query->where('id', Auth::User()->id);
        }
    }   
}
