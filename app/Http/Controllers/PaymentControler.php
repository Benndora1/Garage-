<?php

namespace App\Http\Controllers;

use DB;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\PaymentMethod;
use App\tbl_payments;
use App\Http\Requests\StorePaymentMethodRequest;

class PaymentControler extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

	//payment add form
	public function index()
	{   
        return view('payment.add');
	}

	//payment store
	public function paymentstore(StorePaymentMethodRequest $request)
	{
		$paymenttype = $request->payment;
		//$count = DB::table('tbl_payments')->where('payment','=',$paymenttype)->count();
		$count = PaymentMethod::where('payment','=',$paymenttype)->count();

		if($count == 0)
		{
			$payment = new PaymentMethod;
			$payment->payment=$paymenttype;
			$payment->save();
			return redirect('payment/list')->with('message','Successfully Submitted');
		}
		else
		{
			return redirect('payment/add')->with('message','Duplicate Data');
		}
	}
	
	//payment list
	public function paymentlist()
	{
		//$payment_methods=DB::table('tbl_payments')->orderBy('id','DESC')->get()->toArray();
		//$payment_methods = PaymentMethod::orderBy('id','DESC')->get();
		$payment_methods = PaymentMethod::where('soft_delete','=',0)->orderBy('id','DESC')->get();

		return view('payment.list',compact('payment_methods'));
	}
    
	//payment delete
    public function destory($id)
    {
    	//$vehical = DB::table('tbl_payments')->where('id','=',$id)->delete();
    	//$payment_methods = PaymentMethod::where('id','=',$id)->delete();
    	$payment_methods = PaymentMethod::where('id','=',$id)->update(['soft_delete' => 1]);
    	
    	return redirect('/payment/list')->with('message','Successfully Deleted');
    }

	//payment edit
    public function editpayment($id)
    {   
    	$editid = $id;
    	//$vehicals = DB::table('tbl_payments')->where('id','=',$id)->first();
    	$payment_methods = PaymentMethod::where('id','=',$id)->first();

    	return view('payment.edit',compact('payment_methods','editid'));
    }

	//payment update
    public function updatepayment(StorePaymentMethodRequest $request, $id)
    {
    	$paymenttype = $request->payment;
		//$count = DB::table('tbl_payments')->where([['payment','=',$paymenttype],['id','!=',$id]])->count();
		$count = PaymentMethod::where([['payment','=',$paymenttype],['id','!=',$id]])->count();
		
		if($count == 0)
		{
			$payment = PaymentMethod::find($id);
			$payment->payment = $paymenttype;
			$payment->save();
			return redirect('payment/list')->with('message','Successfully Updated');
		}
		else
		{
			return redirect('payment/list/edit/'.$id)->with('message','Duplicate Data');
		}
    }
}