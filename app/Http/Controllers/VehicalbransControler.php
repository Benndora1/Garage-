<?php

namespace App\Http\Controllers;

use DB;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\tbl_vehicle_types;
use App\tbl_vehicle_brands;

use App\Vehiclebrand;
use App\Vehicletype;
use App\CustomField;
use App\Http\Requests\VehicleBrandAddEditFormRequest;

class VehicalbransControler extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

	// vehiclebrand add form
	public function index()
	{   
		$vehicaltypes = DB::table('tbl_vehicle_types')->where('soft_delete','=',0)->get()->toArray();
        
        $tbl_custom_fields = DB::table('tbl_custom_fields')->where([['form_name','=','vehiclebrand'],['always_visable','=','yes'],['soft_delete','=',0]])->get()->toArray();
        
        return view('vehiclebrand.add',compact('vehicaltypes','tbl_custom_fields')); 
	}
    
	// vehiclebrand list
    public function listvehicalbrand()
    {
		$vehicalbrand = Vehiclebrand::where('soft_delete','=',0)->orderBy('id','DESC')->get();

		//Custom Field Data
		$tbl_custom_fields = CustomField::where([['form_name','=','vehiclebrand'],['always_visable','=','yes']])->get();

     	return view('vehiclebrand.list',compact('vehicalbrand','tbl_custom_fields'));     	
    }
     
	// vehiclebrand store
    public function store(VehicleBrandAddEditFormRequest $request)
    {
    	$vehiacal_id = $request->vehicaltypes;
      	$vehical_brand = $request->vehicalbrand;

        $count = DB::table('tbl_vehicle_brands')->where([['vehicle_id','=',$vehiacal_id],['vehicle_brand','=',$vehical_brand]])->count();
		if ($count==0)
		{
			$vehicalbrands = new Vehiclebrand;
			$vehicalbrands->vehicle_id = $vehiacal_id;
			$vehicalbrands->vehicle_brand = $vehical_brand;

			//custom field Data
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
					$vehicalbrandsData = $val1;
				}	
				$vehicalbrands->custom_field = $vehicalbrandsData;
			}

			$vehicalbrands->save();

			return redirect('vehiclebrand/list')->with('message','Successfully Submitted');
        }
       	else
        {
			return redirect('vehiclebrand/add')->with('message','Duplicate Data');
        }
    }
	 
	// vehiclebrand delete
	public function destory($id)
	{
	  	//$vehicalbrands = DB::table('tbl_vehicle_brands')->where('id','=',$id)->delete();
	  	$vehicalbrands = DB::table('tbl_vehicle_brands')->where('id','=',$id)->update(['soft_delete' => 1]);

	  	return redirect('vehiclebrand/list')->with('message','Successfully Deleted');
	}

	 // vehiclebrand edit form
	public function editbrand($id)
	{
		$editid = $id;
	  	$vehicaltypes = DB::table('tbl_vehicle_types')->where('soft_delete','=',0)->get()->toArray();
	  	$vehicalbrands = DB::table('tbl_vehicle_brands')->where('id','=',$id)->first();
	  	
	  	//Custom Field Data
		$tbl_custom_fields = DB::table('tbl_custom_fields')->where([['form_name','=','vehiclebrand'],['always_visable','=','yes'],['soft_delete','=',0]])->get()->toArray();

	  	return view('vehiclebrand/edit',compact('vehicalbrands','vehicaltypes','editid','tbl_custom_fields'));
	}

	// vehiclebrand update
	public function brandupdate(VehicleBrandAddEditFormRequest $request, $id)
	{
      	$vehiacal_id = $request->vehicaltypes;
      	$vehical_brand = $request->vehicalbrand;

        $count = DB::table('tbl_vehicle_brands')->where([['vehicle_id','=',$vehiacal_id],['vehicle_brand','=',$vehical_brand],['id','!=',$id]])->count();
		if ($count==0)
		{
			$vehicalbrands = Vehiclebrand::find($id);
			$vehicalbrands->vehicle_id = $vehiacal_id;
			$vehicalbrands->vehicle_brand = $vehical_brand;

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
					$vehicalbrandsData = $val1;
				}	
				$vehicalbrands->custom_field = $vehicalbrandsData;
			}
			$vehicalbrands->save();
			
			return redirect('vehiclebrand/list')->with('message','Successfully Updated');
        }
        else
        {    
        	return redirect('vehiclebrand/list/edit/'.$id)->with('message','Duplicate Data');
        }     
	 }
}