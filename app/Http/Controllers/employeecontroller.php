<?php

namespace App\Http\Controllers;

use DB;
use URL;
use Mail;
use Auth;

use App\Http\Requests;
use Illuminate\Mail\Mailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Gate;

use App\tbl_mail_notifications;
use App\User;
use App\Sale;
use App\MailNotification;
use App\CustomField;
use App\Role;
use App\Role_user;
use App\Service;
use App\Http\Requests\EmployeeAddEditFormRequest;

class employeecontroller extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
	
   	public function employeelist()
   	{
		if (!isAdmin(Auth::User()->role_id)) 
		{
			if (getUsersRole(Auth::User()->role_id) == "Customer") 
			{	
				$user = User::where('role','=','employee')->where('soft_delete','=',0)->orderBy('id','DESC')->get();	
			}
			elseif (getUsersRole(Auth::User()->role_id) == "Employee") 
			{
	
				$user = User::where('role','=','employee')->where('soft_delete','=',0)->orderBy('id','DESC')->get();
			}
			elseif (getUsersRole(Auth::user()->role_id) == 'Support Staff' || getUsersRole(Auth::user()->role_id) == 'Accountant') {
	
				$user = User::where('role','=','employee')->where('soft_delete','=',0)->orderBy('id','DESC')->get();
			}
			else
			{
				$user = User::where('role','=','employee')->where('soft_delete','=',0)->orderBy('id','DESC')->get();
			}
		}
		else 
		{
			$user = User::where('role','=','employee')->where('soft_delete','=',0)->orderBy('id','DESC')->get();
		}

		return view('employee.list',compact('user'));
   }
   
   // employee addform
   public function addemployee()
   {
   		$country = DB::table('tbl_countries')->get()->toArray();
   		
		//$tbl_custom_fields = DB::table('tbl_custom_fields')->where([['form_name','=','employee'],['always_visable','=','yes']])->get()->toArray();
		$tbl_custom_fields = DB::table('tbl_custom_fields')->where([['form_name','=','employee'],['always_visable','=','yes'],['soft_delete','=',0]])->get()->toArray();

	   return view('employee.add',compact('country','tbl_custom_fields'));
   }
   
   // employee store
   public function store(EmployeeAddEditFormRequest $request)
   {
   	    /*  $this->validate($request, [  
			'firstname' => 'required|regex:/^[(a-zA-Z\s)]+$/u',
			'lastname'=>'required|regex:/^[(a-zA-Z\s)]+$/u',
			'displayname'=>'required|regex:/^[(a-zA-Z\s)]+$/u',
			'designation'=>'required',
			'email'=>'unique:users',
			'password'=>'min:6',
			//'mobile'=>'required|max:15|min:10|regex:/^[- +()]*[0-9][- +()0-9]*$/',
			//'mobile'=>'required|max:12|min:6|regex:/^[- +()]*[0-9][- +()0-9]*$/',
			'mobile'=>'required|max:12|min:6|regex:/^[0-9]*$/',
			//Solved by Mukesh [Bug list row number: 625]
			//'landlineno'=>'max:15|min:12|regex:/^[- +()]*[0-9][- +()0-9]*$/',
			//'landlineno'=>'nullable|max:12|min:6|regex:/^[- +()]*[0-9][- +()0-9]*$/',
			'landlineno'=>'nullable|max:12|min:6|regex:/^[0-9]*$/',
			'password_confirmation' => 'required|same:password',
			// 'join_date'  => 'required|date',
			// 'left_date'  => 'date|after:join_date',
			'image' => 'image|mimes:jpg,png,jpeg',
			'join_date' => 'required',
	      ],[
			'displayname.regex' => 'Enter valid display name',
			'firstname.regex' => 'Enter valid first name',
			'lastname.regex' => 'Enter valid last name',
			'landlineno.regex' => 'Enter valid landline no',
		]);*/
		  
		/*$firstname=Input::get('firstname');
		$email=Input::get('email');
		$password=Input::get('password');*/


		$dob = null;
		if(!empty($request->dob))
		{
			if(getDateFormat() == 'm-d-Y')
			{
				$dob = date('Y-m-d',strtotime(str_replace('-','/',$request->dob)));
			}
			else
			{
				$dob = date('Y-m-d',strtotime($request->dob));
			}
		}
		
		if(getDateFormat() == 'm-d-Y')
		{		   
			//$dob=date('Y-m-d',strtotime(str_replace('-','/',Input::get('dob'))));
			
			$join_date = date('Y-m-d',strtotime(str_replace('-','/',$request->join_date)));
			
			$leftdate = $request->left_date;
		
			if($leftdate == '')
			{
				$left_date = "";
			}
			else
			{
				$left_date = date('Y-m-d',strtotime(str_replace('-','/',$request->left_date)));
			}
		}
		else
		{
			//$dob=date('Y-m-d',strtotime(Input::get('dob')));

			$join_date = date('Y-m-d',strtotime($request->join_date));
			 
			$leftdate = $request->left_date;
		
			if($leftdate == '')
			{
				$left_date = "";
			}
			else
			{
				$left_date = date('Y-m-d',strtotime($request->left_date));
			}		
		}

		//Get user role id from Role table
		$getRoleId = Role::where('role_name', '=', 'Employee')->first();
		$firstname = $request->firstname;
		$email = $request->email;				
		$password = $request->password;

		$user = new User;
		$user->name = $firstname;  
		$user->lastname = $request->lastname;
		$user->display_name = $request->displayname;
		$user->gender = $request->gender;
		$user->birth_date = $dob;
		$user->email = $email;
	    $user->password = bcrypt($password);
		$user->mobile_no = $request->mobile;
		$user->landline_no = $request->landlineno;
		$user->address = $request->address;

		if(!empty($request->image))
		{
			$file = $request->image;
			$filename = $file->getClientOriginalName();
			$file->move(public_path().'/employee/', $file->getClientOriginalName());
			$user->image = $filename;
		}
		else
		{
			$user->image = 'avtar.png';
		}
		
		$user->join_date = $join_date;
		$user->designation = $request->designation;
		$user->left_date = $left_date;
		$user->country_id = $request->country_id;
		$user->state_id = $request->state;
		$user->city_id = $request->city;
		$user->role = 'employee';

		$user->role_id = $getRoleId->id; /*Store Role table User Role Id*/

		$user->timezone = "UTC";
		$user->language = "en";
		//custom field	
		//$custom = Input::get('custom');
		$custom = $request->custom;
		
		$custom_fileld_value = array();	
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
				$customerdata = $val1;
			}	
			$user->custom_field = $customerdata;
		}
		$user->save();

		/*For data store inside Role_user table*/
		if ( $user->save() ) 
		{
			$currentUserId = $user->id;

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
			if($user->save())
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
					$headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$headers .= 'From:'. $mail_send_from . "\r\n";
				
					$data = mail($email,$mail_sub,$email_content,$headers);
				}										
			}
		}

		return redirect('/employee/list')->with('message','Successfully Submitted');
	}
	
	//employee edit
	public function edit($id)
	{
		$editid = $id;
		
		if (!isAdmin(Auth::User()->role_id)) 
	    {
			if (Gate::allows('employee_owndata'))
			{				
				if (Auth::User()->id == $id)
				{
					$user = DB::table('users')->where('id','=',$id)->first();

					$country = DB::table('tbl_countries')->get()->toArray();
					$state = DB::table('tbl_states')->where('country_id', $user->country_id)->get()->toArray();
					$city = DB::table('tbl_cities')->where('state_id', $user->state_id)->get()->toArray();

					$tbl_custom_fields = DB::table('tbl_custom_fields')->where([['form_name','=','employee'],['always_visable','=','yes'],['soft_delete','=',0]])->get()->toArray();

					return view('employee.edit',compact('country','state','city','user','editid','tbl_custom_fields'));
				}
				else if (Gate::allows('employee_edit')) 
				{
					$user = DB::table('users')->where('id','=',$id)->first();

					$country = DB::table('tbl_countries')->get()->toArray();
					$state = DB::table('tbl_states')->where('country_id', $user->country_id)->get()->toArray();
					$city = DB::table('tbl_cities')->where('state_id', $user->state_id)->get()->toArray();

					$tbl_custom_fields = DB::table('tbl_custom_fields')->where([['form_name','=','employee'],['always_visable','=','yes'],['soft_delete','=',0]])->get()->toArray();

					return view('employee.edit',compact('country','state','city','user','editid','tbl_custom_fields'));
				}
				else 
				{
					return abort('403', 'This action is unauthorized.');
				}			
			}
			else if (Gate::allows('employee_edit'))
			{
				$user = DB::table('users')->where('id','=',$id)->first();

				$country = DB::table('tbl_countries')->get()->toArray();
				$state = DB::table('tbl_states')->where('country_id', $user->country_id)->get()->toArray();
				$city = DB::table('tbl_cities')->where('state_id', $user->state_id)->get()->toArray();

				$tbl_custom_fields = DB::table('tbl_custom_fields')->where([['form_name','=','employee'],['always_visable','=','yes'],['soft_delete','=',0]])->get()->toArray();

				return view('employee.edit',compact('country','state','city','user','editid','tbl_custom_fields'));
			}
			else 
			{
				return abort('403', 'This action is unauthorized.');
			}
		}
		else
		{
			$user = DB::table('users')->where('id','=',$id)->first();

			$country = DB::table('tbl_countries')->get()->toArray();
			$state = DB::table('tbl_states')->where('country_id', $user->country_id)->get()->toArray();
			$city = DB::table('tbl_cities')->where('state_id', $user->state_id)->get()->toArray();

			$tbl_custom_fields = DB::table('tbl_custom_fields')->where([['form_name','=','employee'],['always_visable','=','yes'],['soft_delete','=',0]])->get()->toArray();

			return view('employee.edit',compact('country','state','city','user','editid','tbl_custom_fields'));
		}
				
	}
	
	// employee update
	public function update($id ,EmployeeAddEditFormRequest $request)
	{
		 /*$this->validate($request, [  
         'firstname' => 'regex:/^[(a-zA-Z\s)]+$/u',
		 'lastname'=>'regex:/^[(a-zA-Z\s)]+$/u',
		 'displayname'=>'regex:/^[(a-zA-Z\s)]+$/u',
		 'password'=>'nullable|min:6|max:12|regex:/(^[A-Za-z0-9]+$)+/',
         //'mobile'=>'required|max:15|min:10|regex:/^[- +()]*[0-9][- +()0-9]*$/',
         //'mobile'=>'required|max:12|min:6|regex:/^[- +()]*[0-9][- +()0-9]*$/',
         'mobile'=>'required|max:12|min:6|regex:/^[0-9]*$/',
         //Solved by Mukesh [Bug list row number: 625]
         //'landlineno'=>'max:15|min:12|regex:/^[- +()]*[0-9][- +()0-9]*$/',
         //'landlineno'=>'nullable|max:12|min:6|regex:/^[- +()]*[0-9][- +()0-9]*$/',
         'landlineno'=>'nullable|max:12|min:6|regex:/^[0-9]*$/',
		'password_confirmation' => 'nullable|same:password',
		'designation'=>'required',
		// 'join_date'  => 'required|date',
		 // 'left_date'  => 'date|after:join_date',
		 'image' => 'image|mimes:jpg,png,jpeg',
		 // 'dob' => 'required|date|before:today',
	      ],[
			'displayname.regex' => 'Enter valid display name',
			'firstname.regex' => 'Enter valid first name',
			'lastname.regex' => 'Enter valid last name',
			'landlineno.regex' => 'Enter valid landline no',
			'landlineno.max' => 'Landline number should not more than 12 digits',
			'landlineno.min' => 'Landline number should more than 6 digits',
		]);*/
		   
		$usimgdtaa = DB::table('users')->where('id','=',$id)->first();
		$email = $usimgdtaa->email;
		$emails = $request->email;

		if($email != $emails)
		{
			$this->validate($request, [
				'email' => 'required|email|unique:users'			
			]);
		}

		//$password =Input::get('password');
		$password = $request->password;
						
		if(getDateFormat() == 'm-d-Y')
	    {
			//$dob=date('Y-m-d',strtotime(str_replace('-','/',Input::get('dob'))));
			$join_date = date('Y-m-d',strtotime(str_replace('-','/', $request->join_date)));
			
			$leftdate = $request->left_date;
		
			if($leftdate == '')
			{
				$left_date = "";
			}
			else
			{
				$left_date = date('Y-m-d',strtotime(str_replace('-','/', $request->left_date)));
			}
		}
		else
		{
			//$dob=date('Y-m-d',strtotime(Input::get('dob')));
			$join_date = date('Y-m-d',strtotime( $request->join_date));
			
			$leftdate = $request->left_date;
		
			if($leftdate == '')
			{
				$left_date = "";
			}
			else
			{
				$left_date = date('Y-m-d',strtotime($request->left_date));
			}
		}

		$dob = null;
		$birthDate = $request->dob;

		if(!empty($birthDate))
		{
			if(getDateFormat() == 'm-d-Y')
			{
				$dob = date('Y-m-d',strtotime(str_replace('-','/', $birthDate)));
			}
			else
			{
				$dob = date('Y-m-d',strtotime($birthDate));
			}
		}

		$firstname = $request->firstname;
		$email = $request->email;

		$user = User::find($id);
		$user->name = $firstname;
		$user->lastname = $request->lastname;
		$user->display_name = $request->displayname;
		$user->gender = $request->gender;
		$user->birth_date = $dob;
		$user->email = $email;
		
		if(!empty($password)){
			$user->password = bcrypt($password);
		}
		
		$user->mobile_no = $request->mobile;
		$user->landline_no = $request->landlineno;
		$user->address = $request->address;
		
		$image = $request->image;
		if(!empty($image))
		{
			$file = $image;
			$filename = $file->getClientOriginalName();
			$file->move(public_path().'/employee/', $file->getClientOriginalName());
			$user->image = $filename;
		}
					
		$user->country_id = $request->country_id;
		$user->state_id = $request->state;
		$user->city_id = $request->city;
		$user->join_date = $join_date;
		$user->designation = $request->designation;
		$user->left_date = $left_date;
		$user->role = 'employee';
				
		//custom field	
		//$custom = Input::get('custom');
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
				$customerdata = $val1;
			}	
			$user->custom_field = $customerdata;
		}

		$user->save();
		
		$logo = DB::table('tbl_settings')->first();
		$systemname = $logo->system_name;
		$emailformats = DB::table('tbl_mail_notifications')->where('notification_for','=','User_registration')->first();

		if($emailformats->is_send == 0)
		{
			if($user->save())
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
				$replace = array($systemname, $firstname, $email, $password, $systemlink );
				
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
					$headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$headers .= 'From:'. $mail_send_from . "\r\n";
				
					$data = mail($email,$mail_sub,$email_content,$headers);
				}							
			}
		}

		return redirect('/employee/list')->with('message','Successfully Updated');
	}
	
	// employee show
	public function showemployer($id)
	{
		$viewid = $id;
		//$user = DB::table('users')->where('id','=',$id)->first();
		$user = User::where('id','=',$id)->first();
		
		/*$tbl_custom_fields=DB::table('tbl_custom_fields')->where([['form_name','=','employee'],['always_visable','=','yes']])->get()->toArray();*/
		$tbl_custom_fields = CustomField::where([['form_name','=','employee'],['always_visable','=','yes']])->get();
		
		/*$emp_free_service=DB::table('tbl_services')
									// ->join('tbl_sales', 'tbl_sales.vehicle_id', '=', 'tbl_services.vehicle_id')
									// ->join('tbl_invoices','tbl_services.id','=','tbl_invoices.sales_service_id')
		                            ->where([['tbl_services.done_status','!=',2],['tbl_services.service_type','=','free']])
									->where('tbl_services.assign_to','=',$id)
									->orderBy('tbl_services.id','desc')->take(5)
									->select('tbl_services.*')
									->get()->toArray();*/

		$emp_free_service = Service::
									where([['tbl_services.done_status','!=',2],['tbl_services.service_type','=','free']])
									->where('tbl_services.assign_to','=',$id)
									->orderBy('tbl_services.id','desc')->take(5)
									->select('tbl_services.*')
									->get();
									
		/*$emp_paid_service=DB::table('tbl_services')
									// ->join('tbl_sales', 'tbl_sales.vehicle_id', '=', 'tbl_services.vehicle_id')
									// ->join('tbl_invoices','tbl_services.id','=','tbl_invoices.sales_service_id')
		                            ->where([['tbl_services.done_status','!=',2],['tbl_services.service_type','=','paid']])
									->where('tbl_services.assign_to','=',$id)
									->orderBy('tbl_services.id','desc')->take(5)
									->select('tbl_services.*')
									->get()->toArray();*/

		$emp_paid_service = Service::
									where([['tbl_services.done_status','!=',2],['tbl_services.service_type','=','paid']])
									->where('tbl_services.assign_to','=',$id)
									->orderBy('tbl_services.id','desc')->take(5)
									->select('tbl_services.*')
									->get();
								
		/*$emp_repeatjob=DB::table('tbl_services')
									// ->join('tbl_sales', 'tbl_sales.vehicle_id', '=', 'tbl_services.vehicle_id')
									// ->join('tbl_invoices','tbl_services.id','=','tbl_invoices.sales_service_id')
									->where([['tbl_services.done_status','!=',2],['tbl_services.service_category','=','repeat job']])
									->where('tbl_services.assign_to','=',$id)
								   ->orderBy('tbl_services.id','desc')->take(5)
									->select('tbl_services.*')
									->get()->toArray();*/

		$emp_repeatjob = Service::
									where([['tbl_services.done_status','!=',2],['tbl_services.service_category','=','repeat job']])
									->where('tbl_services.assign_to','=',$id)
								   ->orderBy('tbl_services.id','desc')->take(5)
									->select('tbl_services.*')
									->get();
		
		return view('employee.show',compact('user','viewid','emp_free_service','emp_paid_service','emp_repeatjob','tbl_custom_fields'));
	}
	
	// employee delete
	public function destory($id)
	{
		//When any employee delete at that time only soft_delete field update with 1
		//$user=DB::table('users')->where('id','=',$id)->update(['soft_delete' => 1]);
		$user = User::where('id','=',$id)->update(['soft_delete' => 1]);

        /*$user=DB::table('users')->where('id','=',$id)->delete();
        $tbl_sales=DB::table('tbl_sales')->where('assigne_to','=',$id)->delete();
        $tbl_services=DB::table('tbl_services')->where('assign_to','=',$id)->delete();*/
		
        return redirect('employee/list')->with('message','Successfully Deleted');
	}
	
	// employee free service
	public function free_service(Request $request)
	{
		//$serviceid=Input::get('emp_free');
		$serviceid = $request->emp_free;
		
		$tbl_services = DB::table('tbl_services')->where('id','=',$serviceid)->first();
			
		$c_id = $tbl_services->customer_id;
		$v_id = $tbl_services->vehicle_id;
		
		$s_id = $tbl_services->sales_id;
		$sales = DB::table('tbl_sales')->where('id','=',$s_id)->first();
		
		$job = DB::table('tbl_jobcard_details')->where('service_id','=',$serviceid)->first();
		$s_date = DB::table('tbl_sales')->where('vehicle_id','=',$v_id)->first();
		
		$vehical = DB::table('tbl_vehicles')->where('id','=',$v_id)->first();
		
		$customer = DB::table('users')->where('id','=',$c_id)->first();
		$service_pro = DB::table('tbl_service_pros')->where('service_id','=',$serviceid)
												  ->where('type','=',0)
												  ->get()->toArray();
		
		$service_pro2 = DB::table('tbl_service_pros')->where('service_id','=',$serviceid)
												  ->where('type','=',1)->get()->toArray();
				
		$tbl_service_observation_points = DB::table('tbl_service_observation_points')->where('services_id','=',$serviceid)->get();
		
		$service_tax = DB::table('tbl_invoices')->where('sales_service_id','=',$serviceid)->first();
		if(!empty($service_tax->tax_name))
		{
			$service_taxes = explode(', ', $service_tax->tax_name);
		}
		else
		{
			$service_taxes = '';
		}
		$discount = $service_tax->discount;
		
		$logo = DB::table('tbl_settings')->first();
		
		$html = view('employee.freeservice')->with(compact('serviceid','tbl_services','sales','logo','job','s_date','vehical','customer','service_pro','service_pro2','tbl_service_observation_points','service_tax','discount','service_taxes'))->render();
		return response()->json(['success' => true, 'html' => $html]);	
	}
	
	// employee paid service
	public function paid_service(Request $request)
	{
		//$serviceid=Input::get('emp_paid');
		$serviceid = $request->emp_paid;
		
		$tbl_services = DB::table('tbl_services')->where('id','=',$serviceid)->first();
		
		$c_id = $tbl_services->customer_id;
		$v_id = $tbl_services->vehicle_id;
		
		$s_id = $tbl_services->sales_id;
		$sales = DB::table('tbl_sales')->where('id','=',$s_id)->first();
		
		$job = DB::table('tbl_jobcard_details')->where('service_id','=',$serviceid)->first();
		$s_date = DB::table('tbl_sales')->where('vehicle_id','=',$v_id)->first();
		
		$vehical = DB::table('tbl_vehicles')->where('id','=',$v_id)->first();
		
		$customer = DB::table('users')->where('id','=',$c_id)->first();
		$service_pro = DB::table('tbl_service_pros')->where('service_id','=',$serviceid)
												  ->where('type','=',0)
												  ->where('chargeable','=',1)
												  ->get()->toArray();
		
		$service_pro2 = DB::table('tbl_service_pros')->where('service_id','=',$serviceid)
												  ->where('type','=',1)->get()->toArray();
				
		$tbl_service_observation_points = DB::table('tbl_service_observation_points')->where('services_id','=',$serviceid)->get()->toArray();
		$service_tax = DB::table('tbl_invoices')->where('sales_service_id','=',$serviceid)->first();
		if(!empty($service_tax->tax_name))
		{
			$service_taxes = explode(', ', $service_tax->tax_name);
		}
		else
		{
			$service_taxes = '';
		}
		
		$discount = $service_tax->discount;
		$logo = DB::table('tbl_settings')->first();
		
		$html = view('employee.paidservice')->with(compact('serviceid','tbl_services','sales','logo','job','s_date','vehical','customer','service_pro','service_pro2','tbl_service_observation_points','service_tax','discount','service_taxes'))->render();
		return response()->json(['success' => true, 'html' => $html]);			
	}
	
	// employee repeat service
	public function repeat_service(Request $request)
	{
		//$serviceid=Input::get('emp_repeat');
		$serviceid = $request->emp_repeat;

		$tbl_services = DB::table('tbl_services')->where('id','=',$serviceid)->first();
			
		$c_id = $tbl_services->customer_id;
		$v_id = $tbl_services->vehicle_id;
		
		$s_id = $tbl_services->sales_id;
		$sales = DB::table('tbl_sales')->where('id','=',$s_id)->first();
		
		$job = DB::table('tbl_jobcard_details')->where('service_id','=',$serviceid)->first();
		$s_date = DB::table('tbl_sales')->where('vehicle_id','=',$v_id)->first();
		
		$vehical = DB::table('tbl_vehicles')->where('id','=',$v_id)->first();
		
		$customer = DB::table('users')->where('id','=',$c_id)->first();
		$service_pro = DB::table('tbl_service_pros')->where('service_id','=',$serviceid)
												  ->where('type','=',0)
												  ->get()->toArray();
		
		$service_pro2 = DB::table('tbl_service_pros')->where('service_id','=',$serviceid)
												  ->where('type','=',1)->get()->toArray();
				
		$tbl_service_observation_points = DB::table('tbl_service_observation_points')->where('services_id','=',$serviceid)->get()->toArray();
		
		$service_tax = DB::table('tbl_invoices')->where('sales_service_id','=',$serviceid)->first();
		if(!empty($service_tax->tax_name))
		{
			$service_taxes = explode(', ', $service_tax->tax_name);
		}
		else
		{
			$service_taxes = '';
		}
		
		$discount = $service_tax->discount;
				
		$logo = DB::table('tbl_settings')->first();
		
		$html = view('employee.repeatservice')->with(compact('serviceid','tbl_services','sales','logo','job','s_date','vehical','customer','service_pro','service_pro2','tbl_service_observation_points','service_tax','discount','service_taxes'))->render();
		return response()->json(['success' => true, 'html' => $html]);			
	}
}
