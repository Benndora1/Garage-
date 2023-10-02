<?php

namespace App\Http\Controllers;

use DB;
use URL;
use Mail;
use Auth;

use App\Http\Requests;
use Illuminate\Mail\Mailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\User;
use App\tbl_sales;
use App\tbl_colors;
use App\tbl_services;
use App\tbl_vehicals;
use App\tbl_rto_taxes;
use App\tbl_sales_taxes;
use App\tbl_mail_notifications;

use App\Service;
use App\Sale;
use App\MailNotification;
use App\Role;
use App\Role_user;
use App\CustomField;
use App\Http\Requests\SupportstaffAddEditFormRequest;

class Supportstaffcontroller extends Controller
{	
	public function __construct()
    {
        $this->middleware('auth');
    }
	
	//supportstaff add form
	public function supportstaffadd()
	{	
		$country = DB::table('tbl_countries')->get()->toArray();
		
		$tbl_custom_fields = DB::table('tbl_custom_fields')->where([['form_name','=','supportstaff'],['always_visable','=','yes'],['soft_delete','=',0]])->get()->toArray();

		return view('supportstaff.add',compact('country','tbl_custom_fields'));
	}
	
	//supportstaff store
	public function store_supportstaff(SupportstaffAddEditFormRequest $request)
	{		

		 /*$this->validate($request, [  
         'firstname' => 'regex:/^[(a-zA-Z\s)]+$/u',
		 'lastname'=>'regex:/^[(a-zA-Z\s)]+$/u',
		 'displayname'=>'regex:/^[(a-zA-Z\s)]+$/u',
		 'email'=>'unique:users',
		 'password'=>'required|min:6',
         //'mobile'=>'required|max:12|min:6|regex:/^[- +()]*[0-9][- +()0-9]*$/',
         'mobile'=>'required|max:12|min:6|regex:/^[0-9]*$/',
         //'landlineno'=>'nullable|max:12|min:6|regex:/^[- +()]*[0-9][- +()0-9]*$/',
         'landlineno'=>'nullable|max:12|min:6|regex:/^[0-9]*$/',
		 'password_confirmation' => 'required|same:password',
		 'image' => 'image|mimes:jpg,png,jpeg',
	      ],[
			'displayname.regex' => 'Enter valid display name',
			'firstname.regex' => 'Enter valid first name',
			'lastname.regex' => 'Enter valid last name',
			'landlineno.regex' => 'Enter valid landline no',
		]);*/

		/*$firstname=Input::get('firstname');
		$lastname=Input::get('lastname');
		$displayname=Input::get('displayname');
		$gender=Input::get('gender');
		$birthdate= Input::get('dob');
		$email=Input::get('email');
		$password=Input::get('password');
		$mobile=Input::get('mobile');
		$landlineno=Input::get('landlineno');
		$address=Input::get('address');
		$country=Input::get('country_id');
		$state=Input::get('state_id');
		$city=Input::get('city');*/

		$email = $request->email;
		$firstname = $request->firstname;
		$lastname = $request->lastname;
		$displayname = $request->displayname;
		$gender = $request->gender;
		$birthdate = $request->dob;
		$password = $request->password;
		$mobile = $request->mobile;
		$landlineno = $request->landlineno;
		$address = $request->address;
		$country = $request->country_id;
		$state = $request->state_id;
		$city = $request->city;
				
		$dob = null;
		if(!empty($birthdate))
		{
			if(getDateFormat() == 'm-d-Y')
			{
				$dob = date('Y-m-d',strtotime(str_replace('-','/', $birthdate)));
			}
			else
			{
				$dob = date('Y-m-d',strtotime($birthdate));
			}
		}

		//Get user role id from Role table
		$getRoleId = Role::where('role_name', '=', 'Support Staff')->first();
					
		$supportstaff = new User;
		$supportstaff->name = $firstname;
		$supportstaff->lastname = $lastname;
		$supportstaff->display_name = $displayname;
		$supportstaff->gender = $gender;
		$supportstaff->birth_date = $dob;
		$supportstaff->email = $email;
		$supportstaff->password = bcrypt($password);
		$supportstaff->mobile_no = $mobile;
		$supportstaff->landline_no = $landlineno;
		$supportstaff->address = $address;
		$supportstaff->country_id = $country;
		$supportstaff->state_id = $state;
		$supportstaff->city_id = $city;

		$image = $request->image;
		if(!empty($image))
		{
			$file = $image;
			$filename = $file->getClientOriginalName();
			$file->move(public_path().'/supportstaff/', $file->getClientOriginalName());
			$supportstaff->image = $filename;
		}
		else
		{
			$supportstaff->image = 'avtar.png';
		}		

		$supportstaff->role_id = $getRoleId->id; /*Store Role table User Role Id*/

		$supportstaff->role = "supportstaff";
		$supportstaff->language = "en";
		$supportstaff->timezone = "UTC";
		
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
				$supportstaffData = $val1;
			}	
			$supportstaff->custom_field = $supportstaffData;
		}
		$supportstaff -> save();

		/*For data store inside Role_user table*/
		if ( $supportstaff->save() )
		{
			$currentUserId = $supportstaff->id;

			$role_user_table = new Role_user;
			$role_user_table->user_id = $currentUserId;
			$role_user_table->role_id = $getRoleId->id;
			$role_user_table->save();
		}
			
		//email format
		$logo = DB::table('tbl_settings')->first();
		$systemname = $logo->system_name;
		$emailformats = DB::table('tbl_mail_notifications')->where('notification_for','=','User_registration')->first();
		if($emailformats->is_send == 0)
		{
			if($supportstaff -> save())
			{
				$emailformat = DB::table('tbl_mail_notifications')->where('notification_for','=','User_registration')->first();
				$mail_format = $emailformat->notification_text;		
				$mail_subjects = $emailformat->subject;		
				$mail_send_from = $emailformat->send_from;
				$search1 = array('{ system_name }');
				$replace1 = array($systemname);
				$mail_sub = str_replace($search1, $replace1, $mail_subjects);	

				$systemlink = URL::to('/');	
				$search = array('{ system_name }','{ user_name }', '{ email }', '{ Password }', '{ system_link }' );
				$replace = array($systemname, $firstname, $email, $password, $systemlink);
				
				$email_content = str_replace($search, $replace, $mail_format);
				$actual_link = $_SERVER['HTTP_HOST'];
			     $startip = '0.0.0.0';
			    $endip = '255.255.255.255';
				if(($actual_link == 'localhost' || $actual_link == 'localhost:8080') || ($actual_link >= $startip && $actual_link <= $endip ))
				{
				
					//local format email				
					$data = array(
					'email'=>$email,
					'mail_sub1' => $mail_sub,
					'email_content1' => $email_content,
					'emailsend' =>$mail_send_from, 
					);
					$data1 = Mail::send('customer.customermail',$data, function ($message) use ($data){

						$message->from($data['emailsend'],'noreply');
						$message->to($data['email'])->subject($data['mail_sub1']);
					});
				}
				else
				{
					//live format email				
					$headers = 'Content-type: text/plain; charset=iso-8859-1' . "\r\n";
					$headers .= 'From:'. $mail_send_from . "\r\n";
					$data = mail($email,$mail_sub,$email_content,$headers);
				}								
			}	
		}

		return redirect('/supportstaff/list')->with('message','Successfully Submitted');
	}
	
	//supportstaff list
	public function index()
	{    
		/*$supportstaff=DB::table('users')->where('role','=','supportstaff')->orderBy('id','DESC')->get()->toArray();*/
	    //$supportstaff = User::where('role','=','supportstaff')->orderBy('id','DESC')->get();
		$supportstaff = User::where([['role','=','supportstaff'],['soft_delete',0]])->orderBy('id','DESC')->get();

		return view('supportstaff.list',compact('supportstaff'));
	}
	
	//supportstaff show
	public function supportstaff_show($id)
	{	
		$viewid = $id;
	    $supportstaff = User::where('id','=',$id)->first();
		$service = Service::where([['customer_id','=',$id],['done_status','=','1']])->get();
		$servic = Service::where([['customer_id','=',$id],['done_status','=','2']])->get();
		$sales = Sale::where('customer_id','=',$id)->get();
		$taxes = DB::table('tbl_sales_taxes')->where('sales_id','=',$id)->get()->toArray();
		$tbl_custom_fields = CustomField::where([['form_name','=','supportstaff'],['always_visable','=','yes']])->get();
		
		return view('supportstaff.view',compact('supportstaff','viewid','sales','service','servic','tbl_custom_fields'));
	}
	
	//supportstaff delete
    public function destory($id)	
	{		  
		//$supportstaff = DB::table('users')->where('id','=',$id)->delete();
		$supportstaff = User::where('id','=',$id)->update(['soft_delete' => 1]);	  
	 	
		return redirect('/supportstaff/list')->with('message','Successfully Deleted');
	}	

	//supportstaff edit
    public function edit($id)
	{   

	    $editid = $id;

	    if (!isAdmin(Auth::User()->role_id)) 
	    {
			if (Gate::allows('supportstaff_owndata'))
			{				
				if (Auth::User()->id == $id) {
					$country = DB::table('tbl_countries')->get()->toArray();
					$supportstaff = DB::table('users')->where('id','=',$id)->first();
			
					$state = DB::table('tbl_states')->where('country_id', $supportstaff->country_id)->get()->toArray();
					$city = DB::table('tbl_cities')->where('state_id', $supportstaff->state_id)->get()->toArray();

					$tbl_custom_fields = DB::table('tbl_custom_fields')->where([['form_name','=','supportstaff'],['always_visable','=','yes'],['soft_delete','=',0]])->get()->toArray();

					return view('supportstaff.update',compact('country','supportstaff','state','city','editid','tbl_custom_fields'));
				}
				else if (Gate::allows('supportstaff_edit')) 
				{
					$country = DB::table('tbl_countries')->get()->toArray();
					$supportstaff = DB::table('users')->where('id','=',$id)->first();
				
					$state = DB::table('tbl_states')->where('country_id', $supportstaff->country_id)->get()->toArray();
					$city = DB::table('tbl_cities')->where('state_id', $supportstaff->state_id)->get()->toArray();

					$tbl_custom_fields = DB::table('tbl_custom_fields')->where([['form_name','=','supportstaff'],['always_visable','=','yes'],['soft_delete','=',0]])->get()->toArray();

					return view('supportstaff.update',compact('country','supportstaff','state','city','editid','tbl_custom_fields'));
				}
				else 
				{
					return abort('403', 'This action is unauthorized.');
				}			
			}
			else if (Gate::allows('supportstaff_edit'))
			{
				$country = DB::table('tbl_countries')->get()->toArray();
				$supportstaff = DB::table('users')->where('id','=',$id)->first();
			
				$state = DB::table('tbl_states')->where('country_id', $supportstaff->country_id)->get()->toArray();
				$city = DB::table('tbl_cities')->where('state_id', $supportstaff->state_id)->get()->toArray();

				$tbl_custom_fields = DB::table('tbl_custom_fields')->where([['form_name','=','supportstaff'],['always_visable','=','yes'],['soft_delete','=',0]])->get()->toArray();

				return view('supportstaff.update',compact('country','supportstaff','state','city','editid','tbl_custom_fields'));
			}
			else 
			{
				return abort('403', 'This action is unauthorized.');
			}
		}
		else
		{
			$country = DB::table('tbl_countries')->get()->toArray();
			$supportstaff = DB::table('users')->where('id','=',$id)->first();
			
			$state = DB::table('tbl_states')->where('country_id', $supportstaff->country_id)->get()->toArray();
			$city = DB::table('tbl_cities')->where('state_id', $supportstaff->state_id)->get()->toArray();

			$tbl_custom_fields = DB::table('tbl_custom_fields')->where([['form_name','=','supportstaff'],['always_visable','=','yes'],['soft_delete','=',0]])->get()->toArray();

			return view('supportstaff.update',compact('country','supportstaff','state','city','editid','tbl_custom_fields'));
		}		
	}	

	//supportstaff update
    public function update($id, SupportstaffAddEditFormRequest $request)
	{
		/*$this->validate($request, [  
        'firstname' => 'regex:/^[(a-zA-Z\s)]+$/u',
		'lastname'=>'regex:/^[(a-zA-Z\s)]+$/u',
		'displayname'=>'regex:/^[(a-zA-Z\s)]+$/u',
		'password'=>'nullable|min:6|max:12|regex:/(^[A-Za-z0-9]+$)+/',
        //'mobile'=>'required|max:12|min:6|regex:/^[- +()]*[0-9][- +()0-9]*$/',
        'mobile'=>'required|max:12|min:6|regex:/^[0-9]*$/',
        //'landlineno'=>'nullable|max:12|min:6|regex:/^[- +()]*[0-9][- +()0-9]*$/',
        'landlineno'=>'nullable|max:12|min:6|regex:/^[0-9]*$/',
		'password_confirmation' => 'nullable|same:password',
		'image' => 'image|mimes:jpg,png,jpeg',
	      ],[
			'displayname.regex' => 'Enter valid display name',
			'firstname.regex' => 'Enter valid first name',
			'lastname.regex' => 'Enter valid last name',
			'landlineno.regex' => 'Enter valid landline no',
		]);*/
		   
		$usimgdtaa = DB::table('users')->where('id','=',$id)->first();
		$email = $usimgdtaa->email;

		/*if($email != $request->email)
		{
			$this->validate($request, [
				'email' => 'required|email|unique:users'				   
			]);
		}*/
		   
		/*$firstname=Input::get('firstname');
		$lastname=Input::get('lastname');
		$displayname=Input::get('displayname');
		$gender=Input::get('gender');
		$email=Input::get('email');
		$password=(Input::get('password'));
		$mobile=Input::get('mobile');
		$landlineno=Input::get('landlineno');
		$address=Input::get('address');
		$country=Input::get('country_id');
		$state=Input::get('state_id');
		$city=Input::get('city');*/

		$firstname = $request->firstname;
		$lastname = $request->lastname;
		$displayname = $request->displayname;
		$gender = $request->gender;
		$email = $request->email;
		$password = $request->password;
		$mobile = $request->mobile;
		$landlineno = $request->landlineno;
		$address = $request->address;
		$country = $request->country_id;
		$state = $request->state_id;
		$city = $request->city;
		$birtDate = $request->dob;

		$dob = null;
		if(!empty($birtDate))
		{
			if(getDateFormat() == 'm-d-Y')
			{
				$dob = date('Y-m-d',strtotime(str_replace('-','/', $birtDate)));
			}
			else
			{
				$dob = date('Y-m-d',strtotime($birtDate));
			}
		}
		
	    $supportstaff = User::find($id);		
	    $supportstaff->name = $firstname;
		$supportstaff->lastname = $lastname;
		$supportstaff->display_name = $displayname;
		$supportstaff->gender = $gender;
		$supportstaff->birth_date = $dob;				
		$supportstaff->email = $email;

		if(!empty($password)){
			$supportstaff->password = bcrypt($password);
		}

		$supportstaff->mobile_no = $mobile;
		$supportstaff->landline_no = $landlineno;
		$supportstaff->address = $address;
		$supportstaff->country_id = $country;
		$supportstaff->state_id = $state;
		$supportstaff->city_id = $city;
		
		$image = $request->image;
		if(!empty($image))
		{
			$file = $image;
			$filename = $file->getClientOriginalName();
			$file->move(public_path().'/supportstaff/', $file->getClientOriginalName());
			$supportstaff->image = $filename;
		}		
		$supportstaff->role = "supportstaff";
		
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
				$supportstaffData = $val1;
			}	
			$supportstaff->custom_field = $supportstaffData;
		}
		$supportstaff->save();
		
		//email format
		$logo = DB::table('tbl_settings')->first();
		$systemname = $logo->system_name;
		$emailformats = DB::table('tbl_mail_notifications')->where('notification_for','=','User_registration')->first();
		if($emailformats->is_send == 0)
		{
			if($supportstaff -> save())
			{
				$emailformat = DB::table('tbl_mail_notifications')->where('notification_for','=','User_registration')->first();
				$mail_format = $emailformat->notification_text;		
				$mail_subjects = $emailformat->subject;		
				$mail_send_from = $emailformat->send_from;
				$search1 = array('{ system_name }');
				$replace1 = array($systemname);
				$mail_sub = str_replace($search1, $replace1, $mail_subjects);
				$systemlink = URL::to('/');
				$search = array('{ system_name }','{ user_name }', '{ email }', '{ Password }', '{ system_link }' );
				$replace = array($systemname, $firstname, $email, $password, $systemlink);
				
				$email_content = str_replace($search, $replace, $mail_format);
				
				$actual_link = $_SERVER['HTTP_HOST'];
			    $startip = '0.0.0.0';
			    $endip = '255.255.255.255';
				if(($actual_link == 'localhost' || $actual_link == 'localhost:8080') || ($actual_link >= $startip && $actual_link <= $endip ))
				{
					//local format email
				
					$data = array(
					'email'=>$email,
					'mail_sub1' => $mail_sub,
					'email_content1' => $email_content,
					'emailsend' =>$mail_send_from, 
					);
					$data1 = Mail::send('customer.customermail',$data, function ($message) use ($data){

							$message->from($data['emailsend'],'noreply');
							$message->to($data['email'])->subject($data['mail_sub1']);
						});
				}
				else
				{
					//live format email				
					$headers = 'Content-type: text/plain; charset=iso-8859-1' . "\r\n";
					$headers .= 'From:'. $mail_send_from . "\r\n";
					$data = mail($email,$mail_sub,$email_content,$headers);
				}								
			}		
		}
		return redirect('/supportstaff/list')->with('message','Successfully Updated');
	}		
}