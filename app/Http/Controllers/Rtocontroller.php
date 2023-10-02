<?php

namespace App\Http\Controllers;

use DB;
use Auth;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\User;
use App\tbl_rto_taxes;

use App\RtoTax;
use App\Vehicle;
use App\CustomField;
use App\Http\Requests\StoreRtoTaxAddEditFormRequest;

class Rtocontroller extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
	
	//rto list
    public function index()
	{	
		$rto = RtoTax::where('soft_delete','=',0)->orderBy('id','DESC')->get();

		//Custom Field Data
		$tbl_custom_fields = CustomField::where([['form_name','=','rto'],['always_visable','=','yes']])->get();

		return view('rto.list',compact('rto','tbl_custom_fields')); 
	}
	
	//rto add form
	public function addrto()
	{	
		/*$vehicle = DB::table("tbl_vehicles")->select('*')
				->whereNOTIn('tbl_vehicles.id',function($query){
				$query->select('tbl_rto_taxes.vehicle_id')->from('tbl_rto_taxes');
				})->get()->toArray();*/

		$vehicle = DB::table("tbl_vehicles")->select('*')
				->whereNOTIn('tbl_vehicles.id',function($query){
				$query->select('tbl_rto_taxes.vehicle_id')->from('tbl_rto_taxes');
				})->where('soft_delete','=',0)->get()->toArray();

		$tbl_custom_fields = DB::table('tbl_custom_fields')->where([['form_name','=','rto'],['always_visable','=','yes'],['soft_delete','=',0]])->get()->toArray();
		
		return view('rto.add',compact('vehicle','tbl_custom_fields')); 
	}
	
	//rto store
	public function store(Request $request)
	{	
		/*$this->validate($request, [  
         	'rto_tax' => 'numeric',
         	'num_plate_tax' => 'numeric',
         	'mun_tax' => 'numeric',
         	],
		 	[
		 	'rto_tax.numeric' => 'RTO tax must be digits only',
		 	'num_plate_tax.numeric' => 'Number Plate must be digits only',
		 	'mun_tax.numeric' => 'Municipal road tax must be digits only',
		]);*/

		$rto = new RtoTax;
		$rto->vehicle_id = $request->v_id;
		$rto->registration_tax = $request->rto_tax;
		$rto->number_plate_charge = $request->num_plate_tax;
		$rto->muncipal_road_tax = $request->mun_tax;

		//custom field	
		$custom = $request->custom;
		$custom_fileld_value = array();	
		$custom_fileld_value_jason_array = array();
		if(!empty($custom))
		{
			foreach($custom as $key=>$value)
			{
				if (is_array($value)) 
				{
					$add_one_in = implode(",",$value);
					$custom_fileld_value[] = array("id" => "$key", "value" => "$add_one_in");					
				}
				else
				{
					$custom_fileld_value[] = array("id" => "$key", "value" => "$value");	
				}				
			}	
		   
			$custom_fileld_value_jason_array['custom_fileld_value'] = json_encode($custom_fileld_value); 

			foreach($custom_fileld_value_jason_array as $key1 => $val1)
			{
				$rtoData = $val1;
			}	
			$rto->custom_field = $rtoData;
		}

		$rto->save();
		
		return redirect('/rto/list')->with('message','Successfully Submitted');
	}
	
	//rto delete
	public function destroy($id)
	{	
		//$rto = DB::table('tbl_rto_taxes')->where('id','=',$id)->delete();
		$rto = DB::table('tbl_rto_taxes')->where('id','=',$id)->update(['soft_delete' => 1]);

		return redirect('/rto/list')->with('message','Successfully Deleted');
	}
	
	//rto editform
	public function edit($id)
	{	
		$editid = $id;
		//$vehicle = DB::table('tbl_vehicles')->get()->toArray();
		$vehicle = Vehicle::where('soft_delete','=',0)->get();
		//$rto = DB::table('tbl_rto_taxes')->where('id','=',$id)->first();
		$rto = RtoTax::where('id','=',$id)->first();

		//Custom Field Data
		$tbl_custom_fields = CustomField::where([['form_name','=','rto'],['always_visable','=','yes'],['soft_delete','=',0]])->get();
		
		return view('rto.edit',compact('rto','editid','vehicle','tbl_custom_fields'));
	}
	
	//rto update
	public function update($id, Request $request)
	{
		/*$this->validate($request, [  
         	'rto_tax' => 'numeric',
         	'num_plate_tax' => 'numeric',
         	'mun_tax' => 'numeric',
         	],
		 	[
		 	'rto_tax.numeric' => 'RTO tax must be digits only',
		 	'num_plate_tax.numeric' => 'Number Plate must be digits only',
		 	'mun_tax.numeric' => 'Municipal road tax must be digits only',
		]);*/

		$rto = RtoTax::find($id);
		$rto->vehicle_id = $request->v_id;
		$rto->registration_tax = $request->rto_tax;
		$rto->number_plate_charge = $request->num_plate_tax;
		$rto->muncipal_road_tax = $request->mun_tax;

		//custom field	
		$custom = $request->custom;
		$custom_fileld_value = array();	
		$custom_fileld_value_jason_array = array();
		if(!empty($custom))
		{
			foreach($custom as $key=>$value)
			{
				if (is_array($value)) 
				{
					$add_one_in = implode(",",$value);
					$custom_fileld_value[] = array("id" => "$key", "value" => "$add_one_in");					
				}
				else
				{
					$custom_fileld_value[] = array("id" => "$key", "value" => "$value");	
				}				
			}	
		   
			$custom_fileld_value_jason_array['custom_fileld_value'] = json_encode($custom_fileld_value); 

			foreach($custom_fileld_value_jason_array as $key1 => $val1)
			{
				$rtoData = $val1;
			}	
			$rto->custom_field = $rtoData;
		}

		$rto->save();
		
		return redirect('/rto/list')->with('message','Successfully Updated');
	}
}	