<?php

namespace App\Http\Controllers;

use DB;
use timezone;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\User;
use App\tbl_custom_fields;
use App\CustomField;
use App\Http\Requests\SupplierAddEditFormRequest;

class Suppliercontroller extends Controller
{	
	public function __construct()
    {
        $this->middleware('auth');
    }
	
	//supplier list
    public function supplierlist()
	{	

		$user = User::where([['role','=','Supplier'],['soft_delete',0]])->orderBy('id','DESC')->get();

		$server = "http://".$_SERVER['SERVER_NAME']."/garrage";

		return view('supplier.list',compact('user','server'));
	}
	
	//supplier add in user_tbl
	public function adddata(Request $request)
	{	
		$supllier = new User;
		//$supllier->name = Input::get('name');
		$supllier->name = $request->name;
		$supplier->save();
	}
	
	//supplier add form
	public function supplieradd()
	{	
		$country = DB::table('tbl_countries')->get()->toArray();

		$tbl_custom_fields = CustomField::where([['form_name','=','supplier'],['always_visable','=','yes'],['soft_delete','=',0]])->get();

	   return view('supplier.add',compact('country','tbl_custom_fields'));
	}
	
	//supplier store
	public function storesupplier(SupplierAddEditFormRequest $request)
	{	
		
		/*$displayname = Input::get('displayname');
		$firstname = Input::get('firstname');
		$lastname = Input::get('lastname');
		//$gender = Input::get('gender');
		//$contact_person = Input::get('contact_person');
		$email = Input::get('email');
		$mobile = Input::get('mobile');
		$landlineno = Input::get('landlineno');
		$address = Input::get('address');
		$country_id = Input::get('country_id');
		$state = Input::get('state');
		$city = Input::get('city');*/

		$displayname = $request->displayname;
		$firstname = $request->firstname;
		$lastname = $request->lastname;
		$email = $request->email;
		$mobile = $request->mobile;
		$landlineno = $request->landlineno;
		$address = $request->address;
		$country_id = $request->country_id;
		$state = $request->state;
		$city = $request->city;
		$image = $request->image;

		$user = new User;
		$user->name = $firstname;
		$user->lastname = $lastname;
		$user->company_name = $displayname;
		//$user->gender = $gender;
		//$user->birth_date = $dob;
		//$user->contact_person = $contact_person;
		$user->email = $email;
		$user->mobile_no = $mobile;
		$user->landline_no = $landlineno;
		$user->address = $address;

		if(!empty($image))
		{
			$file = $image;
			$filename = $file->getClientOriginalName();
			$file->move(public_path().'/supplier/', $file->getClientOriginalName());
			$user->image = $filename;
		}
		else
		{
			$user->image = 'avtar.png';
		}
		
		$user->country_id = $country_id;
		$user->state_id = $state;
		$user->city_id = $city;
		$user->role = 'Supplier';
		$user->language="en";
		$user->timezone="UTC";

		//custom field	
		//$custom=Input::get('custom');
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
				$supplierdata = $val1;
			}	
			$user->custom_field = $supplierdata;
		}

		/*if(!empty($custom))
		{
			foreach($custom as $key=>$value)
			{
			$custom_fileld_value[] = array("id" => "$key", "value" => "$value");	
			}	
       
			$custom_fileld_value_jason_array['custom_fileld_value'] = json_encode($custom_fileld_value); 

			foreach($custom_fileld_value_jason_array as $key1=>$val1)
			{
			$casedata = $val1;
			}	
			$user->custom_field = $casedata;
		}*/

		$user->save();

		return redirect('/supplier/list')->with('message','Successfully Submitted');
	}
	
	//supplier show
	public function showsupplier($id)
	{	
		$viewid = $id;		
		/*$user = DB::table('users')->where([['role','=','Supplier'],['id','=',$id]])->first();*/
		//$user = User::where([['role','=','Supplier'],['id','=',$id]])->first();
		$user = User::where([['role','=','Supplier'],['id','=',$id],['soft_delete',0]])->first();

		/*$tbl_custom_fields=DB::table('tbl_custom_fields')->where([['form_name','=','supplier'],['always_visable','=','yes']])->get()->toArray();*/
		$tbl_custom_fields = CustomField::where([['form_name','=','supplier'],['always_visable','=','yes']])->get();

		return view('supplier.show',compact('user','viewid','tbl_custom_fields'));
	}
	
	//supplier delete
	public function destroy($id)
	{	
		//$user = DB::table('users')->where('id','=',$id)->delete();
		$user = User::where('id','=',$id)->update(['soft_delete' => 1]);

		return redirect('/supplier/list')->with('message','Successfully Deleted');
	}
	
	//supplier edit
	public function edit($id)
	{	
		$editid = $id;
		/*$country = DB::table('tbl_countries')->get()->toArray();
		$state = DB::table('tbl_states')->get()->toArray();
		$city = DB::table('tbl_cities')->get()->toArray();*/
		
		//$user = DB::table('users')->where('id','=',$id)->first();
		$user = User::where('id','=',$id)->first();

		$country = DB::table('tbl_countries')->get()->toArray();
		$state = [];
		$city = [];
		
		if($user != null || $user != '') {
			if($user->country_id != null) {
				$state = DB::table('tbl_states')->where('country_id', '=', $user->country_id)->get()->toArray();
			}

			if($user->state_id != null) {
				$city = DB::table('tbl_cities')->where('state_id', '=', $user->state_id)->get()->toArray();
			}
			
		}
			
		//$tbl_custom_fields=DB::table('tbl_custom_fields')->where([['form_name','=','supplier'],['always_visable','=','yes']])->get()->toArray();
		$tbl_custom_fields = DB::table('tbl_custom_fields')->where([['form_name','=','supplier'],['always_visable','=','yes'],['soft_delete','=',0]])->get()->toArray();
			
		return view('supplier.edit',compact('country','state','city','user','editid','tbl_custom_fields'));
	}
	
	//supplier update
	public function update(SupplierAddEditFormRequest $request, $id)
	{	

		$usimgdtaa = DB::table('users')->where('id','=',$id)->first();
		$email = $usimgdtaa->email;

		if($email != $request->email)
		{
			$this->validate($request, [
				'email' => 'email|unique:users'
			]);
		}
				
		/*$firstname = Input::get('firstname');
		$lastname = Input::get('lastname');
		$displayname = Input::get('displayname');
		$email = Input::get('email');
		//$contact_person = Input::get('contact_person');
		$password = Input::get('password');
		$mobile = Input::get('mobile');
		$landlineno = Input::get('landlineno');
		$address = Input::get('address');
		$country_id = Input::get('country_id');
		$state = Input::get('state');
		$city = Input::get('city');*/

		//$gender = Input::get('gender');
		/*$dd=Input::get('dob');
		if($dd == '')
		{
			$dob=$dd;
		}
		else
		{
			if(getDateFormat()== 'm-d-Y')
			{
				$dob=date('Y-m-d',strtotime(str_replace('-','/',Input::get('dob'))));
			}
			else
			{
				$dob=date('Y-m-d',strtotime(Input::get('dob')));
			}
		}*/
		
		$firstname = $request->firstname;
		$lastname = $request->lastname;
		$displayname = $request->displayname;
		$email = $request->email;
		$password = $request->password;
		$mobile = $request->mobile;
		$landlineno = $request->landlineno;
		$address = $request->address;
		$country_id = $request->country_id;
		$state = $request->state;
		$city = $request->city;

		$user = User::find($id);
		$user->name = $firstname;
		$user->lastname = $lastname;
		$user->company_name = $displayname;
		//$user->gender = $gender;
		//$user->birth_date = $dob;
		$user->email = $email;
		$user->mobile_no = $mobile;
		$user->landline_no = $landlineno;
		$user->address = $address;
		
		if(!empty($request->image))
		{
			$file = $request->image;
			$filename = $file->getClientOriginalName();
			$file->move(public_path().'/supplier/', $file->getClientOriginalName());
			$user->image = $filename;
		}
		
		//$user->contact_person = $contact_person;
		$user->country_id = $country_id;
		$user->state_id = $state;
		$user->city_id = $city;
		$user->role = 'Supplier';	
		$user->language="en";
		$user->timezone="UTC";

		//$custom=Input::get('custom');
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
				$supplierdata = $val1;
			}	
			$user->custom_field = $supplierdata;
		}

		/*if(!empty($custom))
		{
			foreach($custom as $key=>$value)
			{
				$custom_fileld_value[] = array("id" => "$key", "value" => "$value");	
			}	      
			$custom_fileld_value_jason_array['custom_fileld_value']=json_encode($custom_fileld_value); 

			foreach($custom_fileld_value_jason_array as $key1=>$val1)
			{
				$customdata = $val1;
			}
			$user->custom_field = $customdata;
		}*/

		$user->save();

		return redirect('/supplier/list')->with('message','Successfully Updated');
	}
}	
