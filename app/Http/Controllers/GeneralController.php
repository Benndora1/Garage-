<?php

namespace App\Http\Controllers;

use DB;
use File;
use Auth;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\User;
use App\tbl_settings;
use App\tbl_holidays;
use App\tbl_business_hours;

use App\Setting;
use App\Http\Requests\StoreGeneralSettingEditFormRequest;

class GeneralController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
	
	//general settings form
    public function index()
	{	
		$country = DB::table('tbl_countries')->get()->toArray();
		$state = [];
		$city = [];
		//$settings_data = DB::table('tbl_settings')->first();
		$settings_data = Setting::first();
		if($settings_data != null || $settings_data != '') {
			if($settings_data->country_id != null) {
				$state = DB::table('tbl_states')->where('country_id', '=', $settings_data->country_id)->get()->toArray();
			}

			if($settings_data->state_id != null) {
				$city = DB::table('tbl_cities')->where('state_id', '=', $settings_data->state_id)->get()->toArray();
			}
			
		}
		return view('general_setting.list',compact('settings_data','country','state','city'));
	}
	
	//general settings store
	public function store(StoreGeneralSettingEditFormRequest $request)
	{
		/*$this->validate($request, [
	        'System_Name' => 'regex:/^[(a-zA-Z\s)]+$/u',
	        'Phone_Number' => 'required|max:12|min:6|regex:/^[0-9]*$/',
	        'Email' => 'email',
	        'Paypal_Id' => 'nullable|email',
			'Logo_Image' => 'image|mimes:jpg,png,jpeg',
	        'Cover_Image' => 'image|mimes:jpg,png,jpeg',
		]);*/
		
		//dd($request->all());

		$settings_data = DB::table('tbl_settings')->first();
		
		$logo = $settings_data->logo_image;
		$cover = $settings_data->cover_image;
		
		$sys_name = $request->System_Name;
		$strt_year = $request->start_year;
		$ph_no = $request->Phone_Number;
		$email = $request->Email;
		$coutry = $request->country_id;
		$state = $request->state_id;
		$city = $request->city;
		$paypal_id = $request->Paypal_Id;
		$address = $request->address;
		
		$data = Setting::find(1);
		$data->address = $address;
		$data->system_name = $sys_name;
		$data->starting_year = $strt_year;
		$data->phone_number = $ph_no;
		$data->email = $email;
		$data->city_id = $city;
		$data->state_id = $state;
		$data->country_id = $coutry;

		$Logo_Image = $request->Logo_Image;
		if($Logo_Image)
		
			{
				
				$file = $Logo_Image;
				
				$extension = $file->getClientOriginalExtension();
				$filename = str_random(15).'.'.$extension; 
				$file->move(public_path().'/general_setting/', $filename);
				$data->logo_image = $filename;
			}
		
		$Cover_Image = $request->Cover_Image;
		if($Cover_Image)
		{
			
             $file2 = $Cover_Image;
             $extension1 = $file2->getClientOriginalExtension();
			 $filename1 = str_random(15).'.'.$extension1; 
             $file2->move(public_path() . '/general_setting/', $filename1);
             $data->cover_image = $filename1;
		}
		
		 $data->paypal_id = $paypal_id;
		 
		 $data->save();
									
		return redirect('/setting/general_setting/list')->with('message','Successfully Updated');	
	}

}	
