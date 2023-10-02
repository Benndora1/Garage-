<?php

namespace App\Http\Controllers;

use DB;
use Auth;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\User;
use App\tbl_mail_notifications;



use App\MailNotification;

class Mailcontroller extends Controller
{	
	public function __construct()
    {
        $this->middleware('auth');
    }
	
	//mail form
	public function index()
	{
		//$mailformat=DB::table('tbl_mail_notifications')->get()->toArray();
		$mailformat = MailNotification::get();
		
		return view('mail.mail',compact('mailformat')); 
		
	}
	
	//mail update
	public function emailupadte($id, Request $request)
	{
		$emailformat = MailNotification::find($id);
		
		$emailformat->subject = $request->subject;
		$emailformat->send_from = $request->send_from; 
		$emailformat->notification_text = $request->notification_text;
		$emailformat->is_send = $request->is_send;
		$emailformat->save();
		
		return redirect('/mail/mail')->with('message','Successfully Updated');
	}
	
	//mail for user
    public function user()
	{	
		return view('mail.user'); 
	}
	
	//mail for sales
	public function sales()
	{	
		return view('mail.sales');
	}
	
	//mail for service
	public function services()
	{	
		return view('mail.service');
	}
	
}	
