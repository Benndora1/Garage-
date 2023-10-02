<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Mail;
use Config;
use Session;
use DateTime;
use App\tbl_sales;
use App\tbl_services;
use App\tbl_vehicles;
use App\tbl_products;
use App\tbl_business_hours;
use App\tbl_jobcard_details;
use App\tbl_mail_notifications;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Mail\Mailer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use App\User;
use App\Vehicle;
use App\Service;
use App\Product;
use App\JobcardDetail;
use App\Sale;
use App\MailNotification;
use App\BusinessHour;
use App\Holiday;

class homecontroller extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth');
    }
   
   	
   	// Dashboard view render with proper data role wise
    public function dashboard()
    {
    	$Customer = null;
    	$Customer = $Supplier = $employee = $product = $sales = $service = null;
		$data = "";
		$one_day = "";
		$two_day = "";
		$more = "";
		$openinghours = "";
		$upcomingservice = "";
		$set_email_send = Session::get('email_sended');
		
		//timezone in run
		$users = DB::table('users')->where('id','=',Auth::user()->id)->first();
		$timezone=$users->timezone;
		
		config(['app.timezone' => $timezone]);
		$currentfirstdate = new Carbon('first day of this month');
		$currentlastdate = new Carbon('last day of this month');
		
		$startdate = new Carbon('first day of next month');
		$lastdate = new Carbon('last day of next month');
		
		$nowmonthdate=$startdate->format('Y-m-d');
		$nowmonthdate1=$lastdate->format('Y-m-d');
		$nowdate=date('Y-m-d');
		$m1=$startdate->format('M');
		$y1=$startdate->format('Y');
		
		$laststart = new Carbon('first day of last month');
		$lastend = new Carbon('last day of last month');
		$laststart1=$laststart->format('Y-m-d');
		$lastend1=$lastend->format('Y-m-d');
		$m=$laststart->format('m');
		$y=$laststart->format('Y');
		
		
		$admin=DB::table('users')->where('role','=','admin')->first();
		$firstname=$admin->name;
		$email=$admin->email;
		$monthservice= DB::select("SELECT * FROM tbl_services where (done_status=1) and (service_date BETWEEN '" . $laststart1 . "' AND  '" . $lastend1 . "')");
		
		
		
		
		$logo = DB::table('tbl_settings')->first();
		$systemname=$logo->system_name;
		//Email notification for last monthly service for admin
				
		
		if(empty($set_email_send))
		{	
			$emailformats=DB::table('tbl_mail_notifications')->where('notification_for','=','Monthly_service_notification')->first();
			if($emailformats->is_send == 0)
			{		
				if($currentfirstdate == $nowdate)
				{
					$emailformat=DB::table('tbl_mail_notifications')->where('notification_for','=','Monthly_service_notification')->first();
					$mail_format = $emailformat->notification_text;		
					$mail_subjects = $emailformat->subject;		
					$mail_send_from = $emailformat->send_from;
					$search1 = array('{ system_name }','{ month }','{ year }');
					$replace1 = array($systemname,$m,$y);
					$mail_sub = str_replace($search1, $replace1, $mail_subjects);
					
					$message = '<html><body>';
					$message .= '<br/><table rules="all" width="100%"style="border-color: #666;" border="1" cellpadding="10">';
					
					$message .='<table class="table table-bordered" width="100%"  style="border-collapse:collapse;">
					<h4 align="center" style="margin:0px;">Last Month Service List</h4></table><hr/>';
				
					$message .='<table class="table table-bordered" width="100%"  style="border-collapse:collapse;">';
					$message .='<tr><th align="left">#</th> <th align="left"><b>Jobcard Number</b></th> <th align="left"><b>Customer Name</b></th> <th align="left"><b>Vehicle Name</b></th> <th align="left"><b>Service Date</b></th> <th align="left"><b>AssignedTo</b></th> </tr><br/>';
					  
					if(!empty($monthservice))
					{
						$i=1;
						foreach($monthservice as $services)
						{			  
							$message .='<tr><td align="left">'. $i++ .'</td><td align="left">' . $services->job_no .'</td>
											<td align="left">'. getCustomerName($services->customer_id).'</td>
											<td align="left">'. getModelName($services->vehicle_id).'</td>
											<td align="left">' . date('Y-m-d', strtotime($services->service_date)) . ' </td>
											<td align="left">' . getAssignTo($services->assign_to) .'</td></tr> ';
						}
					}
					$message .='</table><hr/>';
					$message .= "</table><br/><br/>";
							$message .= "</body></html>";
					
					$search = array('{ system_name }','{ admin }','{ service_list }');
					$replace = array($systemname, $firstname,$message);
					
					$email_content = str_replace($search, $replace, $mail_format);
					$actual_link = $_SERVER['HTTP_HOST'];
					$startip='0.0.0.0';
					$endip='255.255.255.255';
					if(($actual_link == 'localhost' || $actual_link == 'localhost:8080') || ($actual_link >= $startip && $actual_link <=$endip ))
					{
						//local format email
						$data=array(
							'email'=>$email,
							'mail_sub1' => $mail_sub,
							'email_content1' => $email_content,
							'emailsend' =>$mail_send_from,
							'monthservice'=> $monthservice,
							);
						$data1 =	Mail::send('dashboard.monthlyservice',$data, function ($message) use ($data){

								$message->from($data['emailsend'],'noreply');

								$message->to($data['email'])->subject($data['mail_sub1']);

							});
					}
					else
					{
						//Live format email
						
						$headers = "Content-type: text/html; charset=iso-8859-1\r\n";
						$headers .= 'From:'. $mail_send_from . "\r\n";
							
						$data = mail($email,$mail_sub,$email_content,$headers);
					}			
				}
			}
			 //next month service notifcation for admin, employee,customer
			 $emailformats=DB::table('tbl_mail_notifications')->where('notification_for','=','Service Due')->first();
			if($emailformats->is_send == 0)
			{
				if($currentfirstdate == $nowdate)
				{
					$emailformat=DB::table('tbl_mail_notifications')->where('notification_for','=','Service Due')->first();
					
					$mail_format = $emailformat->notification_text;		
					$mail_subjects = $emailformat->subject;		
					$mail_send_from = $emailformat->send_from;
					$search1 = array('{ month_week }','{ system_name }','{ month }','{ year }');
					$replace1 = array('Month', $systemname,$m1,$y1);
					$mail_sub = str_replace($search1, $replace1, $mail_subjects);
					
					$message = '<html><body>';
					$message .= '<br/><table rules="all" width="100%"style="border-color: #666;" border="1" cellpadding="10">';
					
					$message .='<table class="table table-bordered" width="100%"  style="border-collapse:collapse;">
					<h4 align="center" style="margin:0px;">Next Month Service List</h4></table><hr/>';
				
					$message .='<table class="table table-bordered" width="100%"  style="border-collapse:collapse;">';
					$message .='<tr><th align="left">#</th> <th align="left"><b>Coupon Number</b></th> <th align="left"><b>Customer Name</b></th> <th align="left"><b>Vehicle Name</b></th> <th align="left"><b>Service Date</b></th> <th align="left"><b>AssignedTo</b></th> </tr><br/>';
					
					$Upmonthservice= DB::select("SELECT * FROM tbl_services where (done_status=2) and (service_date BETWEEN '" . $nowmonthdate . "' AND  '" . $nowmonthdate1 . "')");
					
					
					$admin=DB::table('users')->where('role','=','admin')->first();
					if(!empty($admin))
					{
						if(!empty($Upmonthservice))
						{
							$i=1;
						
							foreach($Upmonthservice as $services)
							{
								$salesid = $services->sales_id;
								if(!empty(getEmployeeservice($services->assign_to,$salesid,$nowmonthdate,$nowmonthdate1)))
								{
								
									$message .='<tr><td align="left">'. $i++ .'</td><td align="left">' . $services->job_no .'</td>
												<td align="left">'. getCustomerName($services->customer_id).'</td>
												<td align="left">'. getModelName($services->vehicle_id).'</td>
												<td align="left">' .date('Y-m-d', strtotime($services->service_date)) . ' </td>
												<td align="left">' . getAssignTo($services->assign_to) .'</td></tr> ';
								}
								
								
							}
						}
					}
					$message .='</table><hr/>';
					$message .= "</table><br/><br/>";
					$message .= "</body></html>";
					//admin notification
					$admin=DB::table('users')->where('role','=','admin')->first();
					if(!empty($admin))
					{
						$search = array('{ system_name }','{ user_name }','{ month }','{ year }','{ service_list }');
						$replace = array($systemname, $firstname,$m1,$y1,$message);
						
						$email_content = str_replace($search, $replace, $mail_format);
						$actual_link = $_SERVER['HTTP_HOST'];
						$startip='0.0.0.0';
						$endip='255.255.255.255';
						
						if(($actual_link == 'localhost' || $actual_link == 'localhost:8080') || ($actual_link >= $startip && $actual_link <=$endip ))
						{
							//local format email
							$data=array(
								'email'=>$email,
								'mail_sub1' => $mail_sub,
								'email_content1' => $email_content,
								'emailsend' =>$mail_send_from,
								'monthservice'=> $monthservice,
								);
							$data1 =	Mail::send('dashboard.monthlyservice',$data, function ($message) use ($data){

									$message->from($data['emailsend'],'noreply');

									$message->to($data['email'])->subject($data['mail_sub1']);

								});
						}
						else
						{
							//Live format email
							
							$headers = "Content-type: text/html; charset=iso-8859-1\r\n";
							$headers .= 'From:'. $mail_send_from . "\r\n";
								
							$data = mail($email,$mail_sub,$email_content,$headers);
						}
					}
					//Employee notification
					if(!empty($Upmonthservice))
					{
						$i=1;
						foreach($Upmonthservice as $services)
						{
							$assign_to=$services->assign_to;
							$customer_id=$services->customer_id;
								
								$emplo=DB::table('users')->where([['id','=',$assign_to],['role','=','employee']])->first();	
								if(!empty($emplo))
								{
									$email1=$emplo->email;
									$name=$emplo->name;
									
									$search = array('{ system_name }','{ user_name }','{ month }','{ year }','{ service_list }');
									$replace = array($systemname, $name,$m1,$y1,$message);
									
									$email_content = str_replace($search, $replace, $mail_format);
									$actual_link = $_SERVER['HTTP_HOST'];
									$startip='0.0.0.0';
									$endip='255.255.255.255';
								
									if(($actual_link == 'localhost' || $actual_link == 'localhost:8080') || ($actual_link >= $startip && $actual_link <=$endip ))
									{
										//local format email
										$data=array(
											'email'=>$email1,
											'mail_sub1' => $mail_sub,
											'email_content1' => $email_content,
											'emailsend' =>$mail_send_from,
											'monthservice'=> $monthservice,
											);
										$data1 =	Mail::send('dashboard.monthlyservice',$data, function ($message) use ($data){

												$message->from($data['emailsend'],'noreply');

												$message->to($data['email'])->subject($data['mail_sub1']);

											});
									}
									else
									{
										//Live format email
										
										$headers = "Content-type: text/html; charset=iso-8859-1\r\n";
										$headers .= 'From:'. $mail_send_from . "\r\n";
											
										$data = mail($email1,$mail_sub,$email_content,$headers);
									}
								}
								$custo=DB::table('users')->where([['id','=',$customer_id],['role','=','Customer']])->first();	
								if(!empty($custo))
								{
									$cemail1=$custo->email;
									$cname=$custo->name;
									
									$search = array('{ system_name }','{ user_name }','{ month }','{ year }','{ service_list }');
									$replace = array($systemname, $cname,$m1,$y1,$message);
									
									$email_content = str_replace($search, $replace, $mail_format);
									$actual_link = $_SERVER['HTTP_HOST'];
									$startip='0.0.0.0';
									$endip='255.255.255.255';
								
									if(($actual_link == 'localhost' || $actual_link == 'localhost:8080') || ($actual_link >= $startip && $actual_link <=$endip ))
									{
										//local format email
										$data=array(
											'email'=>$cemail1,
											'mail_sub1' => $mail_sub,
											'email_content1' => $email_content,
											'emailsend' =>$mail_send_from,
											'monthservice'=> $monthservice,
											);
										$data1 =	Mail::send('dashboard.monthlyservice',$data, function ($message) use ($data){

												$message->from($data['emailsend'],'noreply');

												$message->to($data['email'])->subject($data['mail_sub1']);

											});
									}
									else
									{
										//Live format email
										
										$headers = "Content-type: text/html; charset=iso-8859-1\r\n";
										$headers .= 'From:'. $mail_send_from . "\r\n";
											
										$data = mail($cemail1,$mail_sub,$email_content,$headers);
									}
								}		
							
						}
					}
				}
			}
			//Email notification weekly in Employee
			$startdate = new Carbon('first day of this month');
			$m=$startdate->format('m');
			$y=$startdate->format('Y');
			$nowdate=date('Y-m-d');
		
			$day = date('w');
			$week_start = date('Y-m-d', strtotime('-'.$day.' days'));
			$week_end = date('Y-m-d', strtotime('+'.(6-$day).' days'));
			// $week_end1 = date('Y-m-d', strtotime('+'.(7-$day).' days'));
			// var_dump();
			// exit;
			$logo = DB::table('tbl_settings')->first();
			$systemname=$logo->system_name;
			$employee=DB::table('users')->where('role','=','employee')->get()->toArray();
			foreach($employee as $employees)
			{
				$firstname=$employees->name;
				$emp_id=$employees->id;
				$email=$employees->email;
	        
			  	$weekservice= DB::select("SELECT * FROM tbl_services where (done_status=1) and (assign_to='$emp_id') and(service_date BETWEEN '" . $week_start . "' AND  '" . $week_end . "')");
				$emailformats=DB::table('tbl_mail_notifications')->where('notification_for','=','weekly_servicelist')->first();
				if($emailformats->is_send == 0)
				{
					if($week_start == $nowdate)
					{
						$emailformat=DB::table('tbl_mail_notifications')->where('notification_for','=','weekly_servicelist')->first();
						$mail_format = $emailformat->notification_text;		
						$mail_subjects = $emailformat->subject;		
						$mail_send_from = $emailformat->send_from;
						$search1 = array('{ system_name }','{ month }','{ year }');
						$replace1 = array($systemname,$m,$y);
						$mail_sub = str_replace($search1, $replace1, $mail_subjects);
						
						// employee in service list
						
						$message = '<html><body>';
						$message .= '<br/><table rules="all" width="100%"style="border-color: #666;" border="1" cellpadding="10">';
						
						$message .='<table class="table table-bordered" width="100%"  style="border-collapse:collapse;">
						<h4 align="center" style="margin:0px;">Last Week Service List</h4></table><hr/>';
					
						$message .='<table class="table table-bordered" width="100%"  style="border-collapse:collapse;">';
						$message .='<tr><th align="left">#</th> <th align="left"><b>Job Number</b></th> <th align="left"><b>Customer Name</b></th> <th align="left"><b>Vehicle Name</b></th> <th align="left"><b>Service Date</b></th> <th align="left"><b>Model Name</b></th> </tr><br/>';
						  
						if(!empty($weekservice))
						{
							$i=1;
							foreach($weekservice as $services)
							{			  
								$message .='<tr><td align="left">'. $i++ .'</td><td align="left">' . $services->job_no .'</td>
												<td align="left">'. getCustomerName($services->customer_id).'</td>
												<td align="left">'. getModelName($services->vehicle_id).'</td>
												<td align="left">' .date('Y-m-d', strtotime($services->service_date)) . ' </td>
												<td align="left">' . getVehicleName($services->vehicle_id) .'</td></tr> ';
							}
						}
						$message .='</table><hr/>';
						$message .= "</table><br/><br/>";
						$message .= "</body></html>";
						
						$search = array('{ system_name }','{ employee }','{ service_list }');
						$replace = array($systemname, $firstname,$message);
						
						$email_content = str_replace($search, $replace, $mail_format);
						$actual_link = $_SERVER['HTTP_HOST'];
						$startip='0.0.0.0';
						$endip='255.255.255.255';
						if(($actual_link == 'localhost' || $actual_link == 'localhost:8080') || ($actual_link >= $startip && $actual_link <=$endip ))
						{
							//local format email

						
							$data=array(
								'email'=>$email,
								'mail_sub1' => $mail_sub,
								'email_content1' => $email_content,
								'emailsend' =>$mail_send_from,
								'weekservice'=> $weekservice,
							
							);
							$data1 =	Mail::send('dashboard.weeklyservice',$data, function ($message) use ($data){

									$message->from($data['emailsend'],'noreply');

									$message->to($data['email'])->subject($data['mail_sub1']);

								});
						}
						else
						{
							//live format email
							
							$headers = "Content-type: text/html; charset=iso-8859-1\r\n";
							$headers .= 'From:'. $mail_send_from . "\r\n";
								
							$data = mail($email,$mail_sub,$email_content,$headers);
						}
					}
				}
			}
		
			$d = strtotime("+1 week -1 day");
			$start_week = strtotime("last sunday midnight",$d);
			$end_week = strtotime("next saturday",$d);
			$start = date("Y-m-d",$start_week); 
			$end = date("Y-m-d",$end_week); 
		
			//next week service notification for admin
			$emailformats=DB::table('tbl_mail_notifications')->where('notification_for','=','Service Due')->first();
			if($emailformats->is_send == 0)
			{
			if($week_start == $nowdate)
			{
				$emailformat=DB::table('tbl_mail_notifications')->where('notification_for','=','Service Due')->first();
				
				$mail_format = $emailformat->notification_text;		
				$mail_subjects = $emailformat->subject;		
				$mail_send_from = $emailformat->send_from;
				$search1 = array('{ month_week }','{ system_name }','{ month }','{ year }');
				$replace1 = array('Weekly', $systemname,$m1,$y1);
				$mail_sub = str_replace($search1, $replace1, $mail_subjects);
				
				$message = '<html><body>';
				$message .= '<br/><table rules="all" width="100%"style="border-color: #666;" border="1" cellpadding="10">';
				
				$message .='<table class="table table-bordered" width="100%"  style="border-collapse:collapse;">
				<h4 align="center" style="margin:0px;">Next Week Service List</h4></table><hr/>';
			
				$message .='<table class="table table-bordered" width="100%"  style="border-collapse:collapse;">';
				$message .='<tr><th align="left">#</th> <th align="left"><b>Coupon Number</b></th> <th align="left"><b>Customer Name</b></th> <th align="left"><b>Vehicle Name</b></th><th align="left"><b>Service Date</b></th> <th align="left"><b>AssignedTo</b></th> </tr><br/>';
				
				$Upnextweekservice= DB::select("SELECT * FROM tbl_services where (done_status=2) and (service_date BETWEEN '" . $start . "' AND  '" . $end . "')");
				
				
					if(!empty($Upnextweekservice))
					{
						$i=1;
					
						foreach($Upnextweekservice as $services)
						{
							// $salesid = $services->sales_id;
							// if(!empty(getEmployeeservice($services->assign_to,$salesid,$nowmonthdate,$nowmonthdate1)))
							// {
							
								$message .='<tr><td align="left">'. $i++ .'</td><td align="left">' . $services->job_no .'</td>
											<td align="left">'. getCustomerName($services->customer_id).'</td>
											<td align="left">'. getModelName($services->vehicle_id).'</td>
											<td align="left">' .date('Y-m-d', strtotime($services->service_date)) . ' </td>
											<td align="left">' . getAssignTo($services->assign_to) .'</td></tr> ';
							// }
							
							
						}
					}
				
				$message .='</table><hr/>';
				$message .= "</table><br/><br/>";
						$message .= "</body></html>";
				//admin notification
				$admin=DB::table('users')->where('role','=','admin')->first();
				if(!empty($admin))
				{
					$email=$admin->email;
					$firstname=$admin->name;
					
					$search = array('{ system_name }','{ user_name }','{ month }','{ year }','{ service_list }');
					$replace = array($systemname, $firstname,$m1,$y1,$message);
					
					$email_content = str_replace($search, $replace, $mail_format);
					$actual_link = $_SERVER['HTTP_HOST'];
					$startip='0.0.0.0';
					$endip='255.255.255.255';
					
					if(($actual_link == 'localhost' || $actual_link == 'localhost:8080') || ($actual_link >= $startip && $actual_link <=$endip ))
					{
						//local format email
						$data=array(
							'email'=>$email,
							'mail_sub1' => $mail_sub,
							'email_content1' => $email_content,
							'emailsend' =>$mail_send_from,
							'monthservice'=> $monthservice,
							);
						$data1 =	Mail::send('dashboard.monthlyservice',$data, function ($message) use ($data){

								$message->from($data['emailsend'],'noreply');

								$message->to($data['email'])->subject($data['mail_sub1']);

							});
					}
					else
					{
						//Live format email
						
						$headers = "Content-type: text/html; charset=iso-8859-1\r\n";
						$headers .= 'From:'. $mail_send_from . "\r\n";
							
						$data = mail($email,$mail_sub,$email_content,$headers);
					}
				}
				
				//Employee notification
				if(!empty($Upnextweekservice))
				{
					$i=1;
					foreach($Upnextweekservice as $services)
					{
						$assign_to=$services->assign_to;
						$customer_id=$services->customer_id;
							
							$emplo=DB::table('users')->where([['id','=',$assign_to],['role','=','employee']])->first();	
							if(!empty($emplo))
							{
								$email1=$emplo->email;
								$name=$emplo->name;
								
								$search = array('{ system_name }','{ user_name }','{ month }','{ year }','{ service_list }');
								$replace = array($systemname, $name,$m1,$y1,$message);
								
								$email_content = str_replace($search, $replace, $mail_format);
								$actual_link = $_SERVER['HTTP_HOST'];
								$startip='0.0.0.0';
								$endip='255.255.255.255';
							
								if(($actual_link == 'localhost' || $actual_link == 'localhost:8080') || ($actual_link >= $startip && $actual_link <=$endip ))
								{
									//local format email
									$data=array(
										'email'=>$email1,
										'mail_sub1' => $mail_sub,
										'email_content1' => $email_content,
										'emailsend' =>$mail_send_from,
										'monthservice'=> $monthservice,
										);
									$data1 =	Mail::send('dashboard.monthlyservice',$data, function ($message) use ($data){

											$message->from($data['emailsend'],'noreply');

											$message->to($data['email'])->subject($data['mail_sub1']);

										});
								}
								else
								{
									//Live format email
									
									$headers = "Content-type: text/html; charset=iso-8859-1\r\n";
									$headers .= 'From:'. $mail_send_from . "\r\n";
										
									$data = mail($email1,$mail_sub,$email_content,$headers);
								}
							}
							$custo=DB::table('users')->where([['id','=',$customer_id],['role','=','Customer']])->first();	
							if(!empty($custo))
							{
								$cemail1=$custo->email;
								$cname=$custo->name;
								
								$search = array('{ system_name }','{ user_name }','{ month }','{ year }','{ service_list }');
								$replace = array($systemname, $cname,$m1,$y1,$message);
								
								$email_content = str_replace($search, $replace, $mail_format);
								$actual_link = $_SERVER['HTTP_HOST'];
								$startip='0.0.0.0';
								$endip='255.255.255.255';
							
								if(($actual_link == 'localhost' || $actual_link == 'localhost:8080') || ($actual_link >= $startip && $actual_link <=$endip ))
								{
									//local format email
									$data=array(
										'email'=>$cemail1,
										'mail_sub1' => $mail_sub,
										'email_content1' => $email_content,
										'emailsend' =>$mail_send_from,
										'monthservice'=> $monthservice,
										);
									$data1 =	Mail::send('dashboard.monthlyservice',$data, function ($message) use ($data){

											$message->from($data['emailsend'],'noreply');

											$message->to($data['email'])->subject($data['mail_sub1']);

										});
								}
								else
								{
									//Live format email
									
									$headers = "Content-type: text/html; charset=iso-8859-1\r\n";
									$headers .= 'From:'. $mail_send_from . "\r\n";
										
									$data = mail($cemail1,$mail_sub,$email_content,$headers);
								}
							}		
						
					}
				}
			}
			}
		}
		Session::put('email_sended',1);
		
		//Monthly  service barchart
		$nowmonth = date('F-Y');
		$start = new Carbon('first day of this month');
		$end = new Carbon('last day of this month');
		
		 $dates = [];
        for($date = $start; $date->lte($end); $date->addDay())
		{
			$dates[] = $date->format('d');
	    }
		
		$month = date('m');
		$year = date('Y');
		$start_date = "$year/$month/01";
        $end_date = "$year/$month/30";
		
		//top five vehicle service
		$vehical= DB::select("SELECT count(id) as count,`vehicle_id` as vid FROM tbl_services where (done_status=1) and (service_date BETWEEN '" . $start_date . "' AND  '" . $end_date . "') group by `vehicle_id` limit 5");
		
		//top five employee performance
		$performance= DB::select("SELECT count(id) as count,`assign_to` as a_id FROM tbl_services where (done_status=1) and (service_date BETWEEN '" . $start_date . "' AND  '" . $end_date . "') group by `assign_to` limit 5");
		
		// ontime service 
		$datediff = DB::select("SELECT DATEDIFF(tbl_gatepasses.service_out_date,tbl_services.service_date) as days,COUNT(tbl_services.job_no) as counts FROM `tbl_services` join tbl_gatepasses on tbl_services.job_no=tbl_gatepasses.jobcard_id where tbl_services.done_status=1 and (tbl_services.service_date BETWEEN '" . $start_date . "' AND  '" . $end_date . "') and (tbl_gatepasses.service_out_date BETWEEN '" . $start_date . "' AND  '" . $end_date . "')GROUP BY days ");
		
		if(!empty($datediff))
		{
			foreach($datediff as $datediffs)
			{
			$days = $datediffs->days;
			if($days == 0)
			{
				$one_day = $datediffs->counts;
				
			}
			if($days == 1)
			{
				$two_day = $datediffs->counts;
			
			}
			if($days >1)
			{
				$more = $datediffs->counts;
			
			}
			}
			
		}

		//Get data of Dashboard related to assign Role
		if (!isAdmin(Auth::User()->role_id)) 
		{	
			if (getUsersRole(Auth::user()->role_id) == 'Customer') 
			{
				if (Gate::allows('dashboard_owndata')) 
				{
					//Free Service					
					$sale = Service::
									where([['tbl_services.done_status','!=',2],['tbl_services.service_type','=','free']])
									->where('tbl_services.customer_id','=',Auth::User()->id)
									->orderBy('tbl_services.id','desc')->take(5)
									->where('soft_delete','=',0)
									->select('tbl_services.*')
									->get();

					//Paid Service
					$sale1 = Service::
		                            where([['tbl_services.done_status','!=',2],['tbl_services.service_type','=','paid']])
									->where('tbl_services.customer_id','=',Auth::User()->id)
									->orderBy('tbl_services.id','desc')->take(5)
									->where('soft_delete','=',0)
									->select('tbl_services.*')
									->get();

					//Repeat Job			
					$sale2 = Service::
									where([['tbl_services.done_status','!=',2],['tbl_services.service_category','=','repeat job']])
									->where('tbl_services.customer_id','=',Auth::User()->id)
								   ->orderBy('tbl_services.id','desc')->take(5)
								   ->where('soft_delete','=',0)
									->select('tbl_services.*')
									->get();	
					
					//Calendar Events 				
					$serviceevent = Service::where([['done_status','!=',2],['customer_id','=',Auth::User()->id]])->where('soft_delete','=',0)->get();
					
					//opening hours
					$openinghours = BusinessHour::ORDERBY('day','ASC')->get();

					//holiday
					$holiday = Holiday::ORDERBY('date','ASC')->get();

					//upcoming service
					$nowdate = date('Y-m-d');

					$upcomingservice = Service::where([['customer_id','=',Auth::User()->id],['job_no','like','C%'],['service_date','>',$nowdate]])->where('soft_delete','=',0)->take(5)->get();

					$Customer = "";
					$Supplier = "";
					$employee = "";
					$product = "";
					$sales = "";
					$service = "";
					$Customere = "";

					$have_supportstaff = "";
					$have_vehicle = "";
					$have_product = "";
					$have_purchase = "";
					$have_observationCount = "";			
				}
				else
				{
					//Free Service
					$sale=DB::table('tbl_services')
		                            ->where([['tbl_services.done_status','!=',2],['tbl_services.service_type','=','free']])
									->where('tbl_services.customer_id','=',Auth::User()->id)
									->orderBy('tbl_services.id','desc')->take(5)
									->select('tbl_services.*')
									->get()->toArray();
					
					//Paid Service
					$sale1=DB::table('tbl_services')
		                            ->where([['tbl_services.done_status','!=',2],['tbl_services.service_type','=','paid']])
									->where('tbl_services.customer_id','=',Auth::User()->id)
									->orderBy('tbl_services.id','desc')->take(5)
									->select('tbl_services.*')
									->get()->toArray();
					
					//Repeat Job
					$sale2=DB::table('tbl_services')
									->where([['tbl_services.done_status','!=',2],['tbl_services.service_category','=','repeat job']])
									->where('tbl_services.customer_id','=',Auth::User()->id)
								   ->orderBy('tbl_services.id','desc')->take(5)
									->select('tbl_services.*')
									->get()->toArray();	
					
					$sale = null;
					$sale1 = null;
					$sale2 = null;

					//Calendar Events 
					$serviceevent = null;

					//opening hours
					$openinghours = BusinessHour::ORDERBY('day','ASC')->get();

					//holiday
					$holiday = Holiday::ORDERBY('date','ASC')->get();

					//upcoming service
					$nowdate=date('Y-m-d');
					$upcomingservice = null;

					$Customer = "";
					$Supplier = "";
					$employee = "";
					$product = "";
					$sales = "";
					$service = "";
					$Customere = "";

					$have_supportstaff = "";
					$have_vehicle = "";
					$have_product = "";
					$have_purchase = "";
					$have_observationCount = "";
				}	
			}
			elseif (getUsersRole(Auth::user()->role_id) == 'Employee') 
			{
				//free service		
				$sale = Service::
									where([['tbl_services.done_status','!=',2],['tbl_services.service_type','=','free']])
									->where('tbl_services.assign_to','=',Auth::User()->id)
									->orderBy('tbl_services.id','desc')->take(5)
									->where('soft_delete','=',0)
									->select('tbl_services.*')
									->get();
			
				//Paid Service
				$sale1 = Service::
									where([['tbl_services.done_status','!=',2],['tbl_services.service_type','=','paid']])
									->where('tbl_services.assign_to','=',Auth::User()->id)
									->orderBy('tbl_services.id','desc')->take(5)
									->where('soft_delete','=',0)
									->select('tbl_services.*')
									->get();
			
				//Repeat Job					
				$sale2 = Service::
									where([['tbl_services.done_status','!=',2],['tbl_services.service_category','=','repeat job']])
									->where('tbl_services.assign_to','=',Auth::User()->id)
								   ->orderBy('tbl_services.id','desc')->take(5)
								   ->where('soft_delete','=',0)
									->select('tbl_services.*')
									->get();


				//Recently Joined customer            
            	$Customere = User::
            							join('tbl_services','users.id','=','tbl_services.customer_id')
										->where([['tbl_services.assign_to','=',Auth::User()->id],['tbl_services.done_status','!=',2]])
										->orderBy('tbl_services.assign_to','desc')
										->groupBy("tbl_services.customer_id")
										->take(5)->get();


				//Calendar Events 
				$serviceevent = Service::where([['done_status','!=',2],['assign_to','=',Auth::User()->id],['soft_delete','=',0]])->get();
			
				//opening hours
				$openinghours = BusinessHour::ORDERBY('day','ASC')->get();

				//holiday
				$holiday = Holiday::ORDERBY('date','ASC')->get();
			
				//upcoming service
				$nowdate=date('Y-m-d');

				$upcomingservice = Service::where([['assign_to','=',Auth::User()->id],['job_no','like','C%'],['service_date','>',$nowdate],['soft_delete','=',0]])->take(5)->get();

				$product = null;
				$sales = null;
				$service = null;

				$Customer = User::where([['role','=','Customer'],['soft_delete','=',0]])->count();
				$employee = User::where([['role','=','employee'],['soft_delete','=',0]])->count();
				$Supplier = User::where([['role','=','Supplier'],['soft_delete','=',0]])->count();
				$have_supportstaff = User::where([['role','=','supportstaff'],['soft_delete','=',0]])->count();
				$have_vehicle = Vehicle::where('soft_delete','=',0)->count();
				$have_product = Product::where('soft_delete','=',0)->count();
				$have_purchase = DB::table('tbl_purchases')->count();
				$have_observationCount = DB::table('tbl_points')->where('soft_delete','=',0)->count();
			}
			elseif (getUsersRole(Auth::user()->role_id) == 'Support Staff' || getUsersRole(Auth::user()->role_id) == 'Accountant')
			{

				$employee = User::where([['role','=','employee'],['soft_delete','=',0]])->count();
				$Customer = User::where([['role','=','Customer'],['soft_delete','=',0]])->count();
				$Supplier = User::where([['role','=','Supplier'],['soft_delete','=',0]])->count();
				$product = Product::where('soft_delete','=',0)->count();
				$sales = Sale::where('soft_delete','=',0)->count();
				$service = Service::where([['job_no','like','J%'],['soft_delete','=',0]])->count();

				$have_supportstaff = User::where([['role','=','supportstaff'],['soft_delete','=',0]])->count();
				$have_vehicle = Vehicle::where('soft_delete','=',0)->count();
				$have_product = Product::where('soft_delete','=',0)->count();
				$have_purchase = DB::table('tbl_purchases')->count();
				$have_observationCount = DB::table('tbl_points')->where('soft_delete','=',0)->count();

				//free service
				$sale = Service::
									where([['tbl_services.done_status','!=',2],['tbl_services.service_type','=','free']])->orderBy('tbl_services.id','desc')->take(5)
										->where('soft_delete','=',0)
										->select('tbl_services.*')
										->get();

				//Paid service					
				$sale1 = Service::
									where([['tbl_services.done_status','!=',2],['tbl_services.service_type','=','paid']])->orderBy('tbl_services.id','desc')->take(5)
									->where('soft_delete','=',0)
									->select('tbl_services.*')
									->get();

				//Repeat job service
				$sale2 = Service::
									where([['tbl_services.done_status','!=',2],['tbl_services.service_category','=','repeat job']])
									->orderBy('tbl_services.id','desc')->take(5)
									->where('soft_delete','=',0)
									->select('tbl_services.*')
									->get();

				//Recent join customer
				$Customere = User::where([['role','=','Customer'],['soft_delete',0]])->orderBy('id','desc')->take(5)->get();
			
				//Calendar Events
				$serviceevent = Service::where('tbl_services.done_status','!=',2)->where('soft_delete','=',0)->get();

				//holiday show Calendar
				$holiday = Holiday::ORDERBY('date','ASC')->get();
			}
			
		}
		else
		{
			//count employee,customer,supplier,product,sales,service			
			$employee = User::where([['role','=','employee'],['soft_delete','=',0]])->count();
			$Customer = User::where([['role','=','Customer'],['soft_delete','=',0]])->count();
			$Supplier = User::where([['role','=','Supplier'],['soft_delete','=',0]])->count();
			$product = Product::where('soft_delete','=',0)->count();
			$sales = Sale::where('soft_delete','=',0)->count();
			$service = Service::where([['job_no','like','J%'],['soft_delete','=',0]])->count();

			$have_supportstaff = User::where([['role','=','supportstaff'],['soft_delete','=',0]])->count();
			$have_vehicle = Vehicle::where('soft_delete','=',0)->count();
			$have_product = Product::where('soft_delete','=',0)->count();
			$have_purchase = DB::table('tbl_purchases')->count();
			$have_observationCount = DB::table('tbl_points')->where('soft_delete','=',0)->count();

			//free service
			$sale = Service::
								where([['tbl_services.done_status','!=',2],['tbl_services.service_type','=','free']])->orderBy('tbl_services.id','desc')->take(5)
								->where('soft_delete','=',0)
								->select('tbl_services.*')
								->get();

			//Paid service						
			$sale1 = Service::
								where([['tbl_services.done_status','!=',2],['tbl_services.service_type','=','paid']])->orderBy('tbl_services.id','desc')->take(5)
								->where('soft_delete','=',0)
								->select('tbl_services.*')
								->get();

			//Repeat job service
			$sale2 = Service::
								where([['tbl_services.done_status','!=',2],['tbl_services.service_category','=','repeat job']])
								->orderBy('tbl_services.id','desc')->take(5)
								->where('soft_delete','=',0)
								->select('tbl_services.*')
								->get();

			//Recent join customer
			$Customere = User::where([['role','=','Customer'],['soft_delete',0]])->orderBy('id','desc')->take(5)->get();
			
			//Calendar Events 
			$serviceevent = Service::where('tbl_services.done_status','!=',2)->where('soft_delete','=',0)->get();

			//holiday show Calendar
			$holiday = Holiday::ORDERBY('date','ASC')->get();
		}

		//dd($Customer, $employee, $Supplier, $have_supportstaff, $have_vehicle, $have_product, $have_purchase, $have_observationCount);

        return view('dashboard.dashboard',compact('employee','Customer','Supplier','product','sales','service','Customere','sale','sale1','sale2','dates','data','vehical','performance','serviceevent','one_day','two_day','more','nowmonth','openinghours','holiday','upcomingservice', 'have_supportstaff', 'have_vehicle', 'have_product', 'have_purchase', 'have_observationCount'));
		 
    }

	//free service modal
    public function openmodel(Request $request)
    {
		//$serviceid = Input::get('open_id');		
		$serviceid = $request->open_id;
		
		$tbl_services = DB::table('tbl_services')->where('id','=',$serviceid)->first();
			
		$c_id=$tbl_services->customer_id;
		$v_id=$tbl_services->vehicle_id;
		
		$s_id = $tbl_services->sales_id;
		$sales = DB::table('tbl_sales')->where('id','=',$s_id)->first();
		
		$job=DB::table('tbl_jobcard_details')->where('service_id','=',$serviceid)->first();
		$s_date = DB::table('tbl_sales')->where('vehicle_id','=',$v_id)->first();
		
		$vehical=DB::table('tbl_vehicles')->where('id','=',$v_id)->first();
		
		$customer=DB::table('users')->where('id','=',$c_id)->first();
		$service_pro=DB::table('tbl_service_pros')->where('service_id','=',$serviceid)
												  ->where('type','=',0)
												  ->get()->toArray();
		
		$service_pro2=DB::table('tbl_service_pros')->where('service_id','=',$serviceid)
												  ->where('type','=',1)->get()->toArray();
				
		$tbl_service_observation_points = DB::table('tbl_service_observation_points')->where('services_id','=',$serviceid)->get()->toArray();
		
		$service_tax = DB::table('tbl_invoices')->where('sales_service_id','=',$serviceid)->first();
		if(!empty($service_tax->tax_name))
		{
		  $service_taxes = explode(', ', $service_tax->tax_name);
		}
		else
		{
		  $service_taxes='';
		}

		$discount = null;
		if (!empty($service_tax->discount)) {
			$discount = $service_tax->discount;
		}

		$logo = DB::table('tbl_settings')->first();
		
		$html = view('dashboard.freeservice')->with(compact('serviceid','tbl_services','sales','logo','job','s_date','vehical','customer','service_pro','service_pro2','tbl_service_observation_points','service_tax','discount','service_taxes'))->render();
		return response()->json(['success' => true, 'html' => $html]);
		
	}

	//paid service modal
    public function closemodel(Request $request)
    {
		//$serviceid = Input::get('open_id');
		$serviceid = $request->open_id;
		
		$tbl_services = DB::table('tbl_services')->where('id','=',$serviceid)->first();
		
		$c_id=$tbl_services->customer_id;
		$v_id=$tbl_services->vehicle_id;
		
		$s_id = $tbl_services->sales_id;
		$sales = DB::table('tbl_sales')->where('id','=',$s_id)->first();
		
		$job=DB::table('tbl_jobcard_details')->where('service_id','=',$serviceid)->first();
		$s_date = DB::table('tbl_sales')->where('vehicle_id','=',$v_id)->first();
		
		$vehical=DB::table('tbl_vehicles')->where('id','=',$v_id)->first();
		
		$customer=DB::table('users')->where('id','=',$c_id)->first();
		$service_pro=DB::table('tbl_service_pros')->where('service_id','=',$serviceid)
												  ->where('type','=',0)
												  ->where('chargeable','=',1)
												  ->get()->toArray();
		
		$service_pro2=DB::table('tbl_service_pros')->where('service_id','=',$serviceid)
												  ->where('type','=',1)->get()->toArray();
				
		$tbl_service_observation_points = DB::table('tbl_service_observation_points')->where('services_id','=',$serviceid)->get();
		
		$service_tax = DB::table('tbl_invoices')->where('sales_service_id','=',$serviceid)->first();
		if(!empty($service_tax->tax_name))
		{
			$service_taxes = explode(', ', $service_tax->tax_name);
		}
		else
		{
			$service_taxes="";
		}
		$discount = $service_tax->discount;
		$logo = DB::table('tbl_settings')->first();
		
		
		$html = view('dashboard.paidservice')->with(compact('serviceid','tbl_services','sales','logo','job','s_date','vehical','customer','service_pro','service_pro2','tbl_service_observation_points','service_tax','service_taxes','discount'))->render();
		return response()->json(['success' => true, 'html' => $html]);
		
	}
	
	//repeat service modal
    public function upmodel(Request $request)
    {
		//$serviceid = Input::get('open_id');
		$serviceid = $request->open_id;
		
		$tbl_services = DB::table('tbl_services')->where('id','=',$serviceid)->first();
			
		$c_id=$tbl_services->customer_id;
		$v_id=$tbl_services->vehicle_id;
		
		$s_id = $tbl_services->sales_id;
		$sales = DB::table('tbl_sales')->where('id','=',$s_id)->first();
		
		$job=DB::table('tbl_jobcard_details')->where('service_id','=',$serviceid)->first();
		$s_date = DB::table('tbl_sales')->where('vehicle_id','=',$v_id)->first();
		
		$vehical=DB::table('tbl_vehicles')->where('id','=',$v_id)->first();
		
		$customer=DB::table('users')->where('id','=',$c_id)->first();
		$service_pro=DB::table('tbl_service_pros')->where('service_id','=',$serviceid)
												  ->where('type','=',0)
												  ->get()->toArray();
		
		$service_pro2=DB::table('tbl_service_pros')->where('service_id','=',$serviceid)
												  ->where('type','=',1)->get()->toArray();
				
		$tbl_service_observation_points = DB::table('tbl_service_observation_points')->where('services_id','=',$serviceid)->get()->toArray();
		
		$service_tax = DB::table('tbl_invoices')->where('sales_service_id','=',$serviceid)->first();
		if(!empty($service_tax->tax_name))
		{
			$service_taxes = explode(', ', $service_tax->tax_name);
		}
		else
		{
			$service_taxes="";
		}
		$discount = $service_tax->discount;
		
		$logo = DB::table('tbl_settings')->first();
		
		
		$html = view('dashboard.paidservice')->with(compact('serviceid','tbl_services','sales','logo','job','s_date','vehical','customer','service_pro','service_pro2','tbl_service_observation_points','service_tax','discount','service_taxes'))->render();
		return response()->json(['success' => true, 'html' => $html]);
		
	}	
}
