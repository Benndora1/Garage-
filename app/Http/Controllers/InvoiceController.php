<?php

namespace App\Http\Controllers;

use DB;
use URL;
use PDF;
use Mail;
use Auth;

use App\Http\Requests;
use Illuminate\Mail\Mailer;
use Illuminate\Http\Request;
use App\Illuminate\Support\Facades\Gate;

use App\User;
use App\tbl_incomes;
use App\tbl_services;
use App\tbl_invoices;
use App\tbl_payment_records;
use App\tbl_income_history_records;

use App\Invoice;
use App\Service;
use App\Income;
use App\IncomeHistoryRecord;
use App\Sale;
use App\MailNotification;
use App\CustomField;
use App\Updatekey;
use App\Setting;
use App\JobcardDetail;
use App\Vehicle;
use App\RtoTax;
use App\SalePart;
use App\Product;

/*Following path is for invoice sales and service add and edit form*/
use App\Http\Requests\InvoiceAddEditFormRequest;
/*Following path is only for invoice salespart edit form*/
use App\Http\Requests\StoreInvoiceEditFormRequest;

class InvoiceController extends Controller
{	
	public function __construct()
    {
		
        $this->middleware('auth');
    }
	
	//get customer
	public function sales_customer(Request $request)
	{
		//$type = input::get('type');
		$type = $request->type;
		if($type == 1)
		{
			$customer = DB::table('tbl_sales')->select('customer_id')->groupBy('customer_id')->get()->toArray();
		}
		else
		{
			$customer = DB::table('tbl_services')->where('done_status','=',1)->groupBy('customer_id')->get()->toArray();
		}
			?>
			<?php foreach($customer as $customers)
			{ ?>
				<option value="<?php echo $customers->customer_id;?>"><?php echo getCustomerName($customers->customer_id); ?></option>
			<?php 
			} 	
	}
	
	//invoice add form
    public function index(Request $request)
	{		
		/*Code fore Generate Invoice number 1 to continued number*/
		$last_order = DB::table('tbl_invoices')->latest()->first();

		if(!empty($last_order))
		{
			$new_number = str_pad($last_order->invoice_number + 1, 8, 0, STR_PAD_LEFT); 
		}else{
			$new_number = '00000001';
		}

		$code = $new_number;
		$total_rto = "";
		$id = $request->id;

		//$characters = '0123456789';
		//$code =  substr(str_shuffle($characters),0,8);
		$characterss = '0123456789';
		$codepay =  'P'.''.substr(str_shuffle($characterss),0,6);
		
		$tax = DB::table('tbl_account_tax_rates')->where('soft_delete','=',0)->get()->toArray();
		$tbl_payments = DB::table('tbl_payments')->where('soft_delete','=',0)->get()->toArray();
		
		$tbl_sales = DB::table('tbl_sales')->where('id','=',$id)->first();
		if(!empty($tbl_sales))
		{
			$vehicleid = $tbl_sales->vehicle_id;
			$tbl_rto_taxes = DB::table('tbl_rto_taxes')->where('vehicle_id','=',$vehicleid)->first();
			if(!empty($tbl_rto_taxes))
			{
				$registration_tax = $tbl_rto_taxes->registration_tax;
				$number_plate_charge = $tbl_rto_taxes->number_plate_charge;
				$muncipal_road_tax = $tbl_rto_taxes->muncipal_road_tax;
				$total_rto = $registration_tax + $number_plate_charge + $muncipal_road_tax;
			}
			else
			{
				$total_rto =0;			
			}			
		}

		$tbl_custom_fields = DB::table('tbl_custom_fields')->where([['form_name','=','invoice'],['always_visable','=','yes'],['soft_delete','=',0]])->get()->toArray();
		
		return view('invoice.add',compact('code','tax','tbl_sales','codepay','total_rto','tbl_payments','tbl_custom_fields')); 
	}
	
	
	// sale part add
	public function sale_part_index(Request $request)
	{	
		/*Code fore Generate Invoice number 1 to continued number*/
		$last_order = DB::table('tbl_invoices')->latest()->first();

		if(!empty($last_order))
		{
			$new_number = str_pad($last_order->invoice_number + 1, 8, 0, STR_PAD_LEFT); 
		}else{
			$new_number = '00000001';
		}

		$id=$request->id;
		$code = $new_number;

		/*$id=$request->id;
		$characters = '0123456789';
		$code =  substr(str_shuffle($characters),0,8);*/
		$characterss = '0123456789';
		$codepay =  'P'.''.substr(str_shuffle($characterss),0,6);

		$tax = DB::table('tbl_account_tax_rates')->where('soft_delete','=',0)->get()->toArray();
		$tbl_payments = DB::table('tbl_payments')->where('soft_delete','=',0)->get()->toArray();

		$tbl_sales = DB::table('tbl_sale_parts')->where('id','=',$id)->first();
		
		$tbl_saless = DB::table('tbl_sale_parts')->select(DB::raw("SUM(total_price) AS total_price,bill_no,quantity,date,product_id,price ,customer_id,id,salesmanname"))->where('bill_no','=',$tbl_sales->bill_no)->get();
		$tbl_salessd = DB::table('tbl_sale_parts')->where('bill_no','=',$tbl_sales->bill_no)->get();

		/*RTO tax not addd to sale vehicle parts*/
		/*if(!empty($tbl_sales))
		{
			$vehicleid=$tbl_sales->product_id;
			$tbl_rto_taxes=DB::table('tbl_rto_taxes')->where('vehicle_id','=',$vehicleid)->first();
			if(!empty($tbl_rto_taxes))
			{
				$registration_tax = $tbl_rto_taxes->registration_tax;
				$number_plate_charge = $tbl_rto_taxes->number_plate_charge;
				$muncipal_road_tax = $tbl_rto_taxes->muncipal_road_tax;
				$total_rto = $registration_tax + $number_plate_charge + $muncipal_road_tax;
			}
			else
			{
				$total_rto =0;
			}
		}*/

		return view('invoice.sale_part_add',compact('code','tax','tbl_sales','codepay','tbl_payments','tbl_saless','tbl_salessd')); 
	}
	
	//invoice list
	public function showall()
	{	
		if (!isAdmin(Auth::User()->role_id)) 
		{
			if (getUsersRole(Auth::User()->role_id) == "Customer") 
			{
				/*$invoice = DB::table('tbl_invoices')->where('customer_id','=',Auth::User()->id)->where('type','!=',2)->orderBy('id','DESC')->get()->toArray();*/
				//$invoice = Invoice::where('customer_id','=',Auth::User()->id)->where('type','!=',2)->orderBy('id','DESC')->get();
				/*$invoice = Invoice::where([['customer_id','=',Auth::User()->id],['soft_delete','=',0]])->where('type','!=',2)->orderBy('id','DESC')->get();*/

				$invoice = Invoice::where([['customer_id','=',Auth::User()->id],['soft_delete','=',0]])->where('type','!=',2)->orderBy('id','DESC')->get();
				
				//$updatekey = DB::table('updatekey')->first();
				$updatekey = Updatekey::first();
				//$logo = DB::table('tbl_settings')->first();
				$logo = Setting::first();
			}
			elseif (getUsersRole(Auth::User()->role_id) == "Employee") 
			{
				/*$invoice = DB::table('tbl_services')
						->join('tbl_invoices','tbl_services.id','=','tbl_invoices.sales_service_id')
						->where('tbl_services.assign_to','=',Auth::User()->id)
						->where('type','!=',2)
						->orderBy('tbl_invoices.id','DESC')->get()->toArray();*/

				/*$invoice = Service::
						join('tbl_invoices','tbl_services.id','=','tbl_invoices.sales_service_id')
						->where('tbl_services.assign_to','=',Auth::User()->id)
						->where('type','!=',2)
						->orderBy('tbl_invoices.id','DESC')->get();*/

				$invoice = Service::
						join('tbl_invoices','tbl_services.id','=','tbl_invoices.sales_service_id')
						->where('tbl_services.assign_to','=',Auth::User()->id)
						->where('type','!=',2)
						->where('tbl_invoices.soft_delete','=',0)
						->orderBy('tbl_invoices.id','DESC')->get();

				//$updatekey = DB::table('updatekey')->first();
				$updatekey = Updatekey::first();
				//$logo = DB::table('tbl_settings')->first();
				$logo = Setting::first();
			}
			elseif (getUsersRole(Auth::user()->role_id) == 'Support Staff' || getUsersRole(Auth::user()->role_id) == 'Accountant') {

				/*$invoice = DB::table('tbl_invoices')->where('type','!=',2)->orderBy('id','DESC')->get()->toArray();*/
				
				//$invoice = Invoice::where('type','!=',2)->orderBy('id','DESC')->get();
				$invoice = Invoice::where([['type','!=',2],['soft_delete','=',0]])->orderBy('id','DESC')->get();

				//$updatekey = DB::table('updatekey')->first();
				$updatekey = Updatekey::first();
				//$logo = DB::table('tbl_settings')->first();
				$logo = Setting::first();
			}
		}
		else
		{
			/*$invoice = DB::table('tbl_invoices')->where('type','!=',2)->orderBy('id','DESC')->get()->toArray();*/
			//$invoice = Invoice::where('type','!=',2)->orderBy('id','DESC')->get();
			$invoice = Invoice::where([['type','!=',2],['soft_delete','=',0]])->orderBy('id','DESC')->get();

			//$updatekey = DB::table('updatekey')->first();
			$updatekey = Updatekey::first();
			//$logo = DB::table('tbl_settings')->first();
			$logo = Setting::first();	
		}

		return view('invoice.list',compact('invoice','updatekey','logo'));
	}

	public function viewSalePart()
	{
		if (!isAdmin(Auth::User()->role_id))
		{
			if (getUsersRole(Auth::User()->role_id) == "Customer") 
			{
				/*$invoice = DB::table('tbl_invoices')->where('customer_id','=',Auth::User()->id)->where('type',2)->orderBy('id','DESC')->get()->toArray();*/
				//$invoice = Invoice::where('customer_id','=',Auth::User()->id)->where('type',2)->orderBy('id','DESC')->get();
				$invoice = Invoice::where('customer_id','=',Auth::User()->id)->where([['type','=',2],['soft_delete','=',0]])->orderBy('id','DESC')->get();

				//$updatekey = DB::table('updatekey')->first();
				$updatekey = Updatekey::first();

				//$logo = DB::table('tbl_settings')->first();
				$logo = Setting::first();
			}
			elseif (getUsersRole(Auth::User()->role_id) == "Employee")
			{
				/*$invoice = DB::table('tbl_services')
										->join('tbl_invoices','tbl_services.id','=','tbl_invoices.sales_service_id')
										->where('tbl_services.assign_to','=',Auth::User()->id)
										->where('type',2)
										->orderBy('tbl_invoices.id','DESC')->get()->toArray();*/

				/*$invoice = Service::
									join('tbl_invoices','tbl_services.id','=','tbl_invoices.sales_service_id')
									->where('tbl_services.assign_to','=',Auth::User()->id)
									->where('type',2)
									->orderBy('tbl_invoices.id','DESC')->get();*/

				$invoice = Service::
									join('tbl_invoices','tbl_services.id','=','tbl_invoices.sales_service_id')
									->where('tbl_services.assign_to','=',Auth::User()->id)
									->where('type',2)
									->where('tbl_invoices.soft_delete','=',0)
									->orderBy('tbl_invoices.id','DESC')->get();

				//$updatekey = DB::table('updatekey')->first();
				$updatekey = Updatekey::first();

				//$logo = DB::table('tbl_settings')->first();
				$logo = Setting::first();
			}
			elseif (getUsersRole(Auth::user()->role_id) == 'Support Staff' || getUsersRole(Auth::user()->role_id) == 'Accountant') {

				/*$invoice = DB::table('tbl_invoices')->where('type',2)->orderBy('id','DESC')->get()->toArray();*/
				//$invoice = Invoice::where('type',2)->orderBy('id','DESC')->get();
				$invoice = Invoice::where([['type','=',2],['soft_delete','=',0]])->orderBy('id','DESC')->get();

				//$updatekey = DB::table('updatekey')->first();
				$updatekey = Updatekey::first();

				//$logo = DB::table('tbl_settings')->first();
				$logo = Setting::first();
			}
		}
		else
		{
			/*$invoice = DB::table('tbl_invoices')->where('type',2)->orderBy('id','DESC')->get()->toArray();*/
			//$invoice = Invoice::where('type',2)->orderBy('id','DESC')->get();
			$invoice = Invoice::where([['type','=',2],['soft_delete','=',0]])->orderBy('id','DESC')->get();
			
			//$updatekey = DB::table('updatekey')->first();
			$updatekey = Updatekey::first();

			//$logo = DB::table('tbl_settings')->first();
			$logo = Setting::first();
		}
		
		return view('invoice.salepartlist',compact('invoice','updatekey','logo'));
	}


	//get jobcard number for which service has not generated Invoice
	public function get_jobcard_no(Request $request)
	{	
		//$cus_id = Input::get('cus_name');
		$cus_id = $request->cus_name;

		$getJobcardNoFromServiceTbl = DB::table('tbl_services')->where([['customer_id','=', $cus_id],['done_status','=',1],['job_no','like','J%']])->get()->toArray();

		$serviceTblJobcardArray = array();
		foreach ($getJobcardNoFromServiceTbl as $getJobcardNoFromServiceTbls) {
			$serviceTblJobcardArray[]	= $getJobcardNoFromServiceTbls->job_no;		
		}


		$invoiceTblJobcardNo = DB::table('tbl_invoices')->where([['customer_id','=', $cus_id],['job_card','like','J%'],['type', '=', 0]])->get()->toArray();

		$invoiceTblJobcardArray = array();
		foreach ($invoiceTblJobcardNo as $invoiceTblJobcardNos) {
			$invoiceTblJobcardArray[] = $invoiceTblJobcardNos->job_card;
		}


		$diff_value = array_diff($serviceTblJobcardArray, $invoiceTblJobcardArray);

		$diff_normalvalue = implode(',', $diff_value);

		$getJobcardServiceTbl = DB::table('tbl_services')->where('job_no','=', $diff_normalvalue)->get()->toArray();

		?>

		<?php if($diff_normalvalue == '') { foreach ($getJobcardServiceTbl as $getJobcardServiceTbls) { ?>
			<option class="invoice_job_number" value="<?php echo $getJobcardServiceTbls->job_no; ?>" >		<?php echo $getJobcardServiceTbls->job_no; ?>
			</option>
		<?php } } else{  foreach ($getJobcardServiceTbl as $getJobcardServiceTbls) { ?>

			<option class="invoice_job_number" value="<?php echo $getJobcardServiceTbls->job_no; ?>" >		<?php echo $getJobcardServiceTbls->job_no; ?>
			</option>

		<?php } } ?>

		<?php 
	}
	
	//get service number
	public function get_service_no(Request $request)
	{		
		//$job_no = Input::get('job_no');
		$job_no = $request->job_no;

		$invoice_data = substr($job_no,0,1);
		if($invoice_data == "J")
		{
			$job = DB::table('tbl_services')->where([['job_no','=',$job_no],['done_status','=',1],['job_no','like','J%']])->first();
			$ser_id = $job->id;
			$cus_id = $job->customer_id;
			$service_pro = DB::table('tbl_service_pros')->where([['service_id','=',$ser_id],['chargeable','=',1]])->SUM('total_price');
			
			$othr_charges =  DB::table('tbl_service_pros')->where([['service_id','=',$ser_id],['product_id','=',0]])->SUM('total_price');
			
			$service_charge = DB::table('tbl_services')->where('id','=',$ser_id)->first();
			$charge = $service_charge->charge;
			
			$total_amount = $service_pro + $othr_charges + $charge;
			
			if(!empty($total_amount))
			{
				return array($ser_id, $total_amount, $cus_id);
			}
			else
			{
				return array($ser_id, 0, 0);
			}
		}
		else
		{
			$vehi_price = DB::table('tbl_sales')->where('vehicle_id',$job_no)->first();
			$price = $vehi_price->total_price;
			$cust = $vehi_price->customer_id;
			$id = $vehi_price->id;
			$tbl_rto_taxes = DB::table('tbl_rto_taxes')->where('vehicle_id',$job_no)->first();
			if(!empty($tbl_rto_taxes))
			{
				$regi = $tbl_rto_taxes->registration_tax;
				$plate = $tbl_rto_taxes->number_plate_charge;
				$road = $tbl_rto_taxes->muncipal_road_tax;
				$total_amount = $price + $regi + $plate + $road;
			}
			else
			{
				$total_amount = $price;
			}
			if(!empty($total_amount))
			{
				return array($id, $total_amount, $cust);
			}
			else
			{
				return 0;
			}
		}
	}
	
	//get invoice into outsanding amount 
	public function get_invoice(Request $request)
	{		
		//$invoiceid = Input::get('invoiceid');
		$invoiceid = $request->invoiceid;

		$invoice_job = DB::table('tbl_invoices')->where('invoice_number','=',$invoiceid)->first();
		if(!empty($invoice_job))
		{
			$ser_id = $invoice_job->customer_id;
			$grand_total = $invoice_job->grand_total;
			$paid_amount = $invoice_job->paid_amount;
			$total = $grand_total - $paid_amount ;
			return array($ser_id, $total);
		}
		else
		{
			return 01;
		}
	}

	//get vehicle total price 
	public function get_vehicle_total(Request $request)
	{
		//$vehi_id = Input::get('vehi_id');
		$vehi_id = $request->vehi_id;

		$vehi_data = DB::table('tbl_sales')->where('vehicle_id',$vehi_id)->first();
		$total_price1 = $vehi_data->total_price;
		$tbl_rto_taxes = DB::table('tbl_rto_taxes')->where('vehicle_id','=',$vehi_id)->first();

		if(!empty($tbl_rto_taxes))
		{
			$registration_tax= $tbl_rto_taxes->registration_tax;
			$number_plate_charge= $tbl_rto_taxes->number_plate_charge;
			$muncipal_road_tax= $tbl_rto_taxes->muncipal_road_tax;
			$total_rto=$registration_tax + $number_plate_charge + $muncipal_road_tax;
			$total_price= $total_price1 + $total_rto;
		}
		else
		{
			$total_price= $total_price1;
		}
		$sale_id = $vehi_data->id;
		return array($sale_id, $total_price);
	}

	
	//get vehicle id for create Invoice(Which sales not generated Invoice) 
	public function get_vehicle(Request $request)
	{
		//$cus_id = Input::get('cus_name');
		$cus_id = $request->cus_name;
		
		$get_sales_id = DB::table('tbl_sales')->where('customer_id', '=', $cus_id)->get()->toArray();

		$sales_id_array = array();

		foreach ($get_sales_id as $get_sales_ids) {
			$sales_id_array[] = $get_sales_ids->id;
		}

		$invoice_id = DB::table('tbl_invoices')->where('customer_id', '=', $cus_id)
											->where('type', '=', 1)->get()->toArray();

		$salesId_inside_invoiceTbl = array();

		foreach ($invoice_id as $invoice_ids) {
			$salesId_inside_invoiceTbl[] = $invoice_ids->sales_service_id;
		}

		$diff_value = array_diff($sales_id_array, $salesId_inside_invoiceTbl);

		$diff_normalvalue = implode(',', $diff_value);

		$vehicleid = DB::table('tbl_sales')->where('id', '=', $diff_normalvalue)->get()->toArray();

		?>
		<?php if($diff_normalvalue == '') { foreach ($vehicleid as $vehicleids) { ?>
			<option class="invoice_vehicle_name" value="<?php echo $vehicleids->vehicle_id;?>" ><?php echo getVehicleName($vehicleids->vehicle_id) ?></option>
		<?php } } else{  foreach ($vehicleid as $vehicleids) { ?>

			<option class="invoice_vehicle_name" value="<?php echo $vehicleids->vehicle_id;?>" ><?php echo getVehicleName($vehicleids->vehicle_id) ?></option>

		<?php } } ?>
		<?php 
	}


	public function get_part(Request $request)
	{
		//$cus_id = Input::get('cus_name');
		$cus_id = $request->cus_name;

		$invoice_job = DB::table('tbl_invoices')->where('customer_id','=',$cus_id)->select('job_card')->get()->toArray();
		$invoice_jobss = array();
		foreach($invoice_job as $invoice_jobs)
		{
			$invoice_jobss[] =  $invoice_jobs->job_card;
		}
		$job = DB::table('tbl_sales')->where('customer_id','=',$cus_id)->where('product_id','!=',NULL)->get()->toArray();
		?>
		<?php foreach($job as $job) { ?>
			<option class="invoice_vehicle_name" value="<?php echo $job->product_id;?>" ><?php echo getPart($job->product_id)->name ?></option>	
		<?php } ?>
		<?php 
	}
	
	//invoice store
	public function store(Request $request)
	{

		/*$sales_service_id=Input::get('jobcard_no');
		$type=Input::get('Invoice_type');
		$invoice_number = Input::get('Invoice_Number');*/

		$sales_service_id = $request->jobcard_no;
		$type = $request->Invoice_type;
		$invoice_number = $request->Invoice_Number;
		$Date = $request->Date;

		if(getDateFormat() == 'm-d-Y')
		{
			$dates = date('Y-m-d',strtotime(str_replace('-','/', $Date)));
		}
		else
		{
			$dates = date('Y-m-d',strtotime($Date));
		}
			
		$invoice = new Invoice;
		$invoice->invoice_number = $invoice_number;
		$invoice->payment_number = $request->paymentno;
		$invoice->customer_id = $request->Customer;
		$jobcard = $request->Job_card;
		$vehicle = $request->Vehicle;
			
		if($type != 2)
		{
			if(!empty($jobcard))
			{ 
				$invoice->job_card = $jobcard; 
			}
			else
			{ 
				$invoice->job_card = $vehicle; }
			}
			else
			{
				$invoice->job_card == 'NULL';
			}

			$invoice->date = $dates;
			$invoice->payment_type = $request->Payment_type;
			$invoice->payment_status = $request->Status;
			$taxs = $request->Tax;

			if(!empty($taxs))
			{
				$invoice->tax_name = implode(', ', $taxs);
			}
			
			//$invoice->tax_name = $taxes;
			$invoice->total_amount = $request->Total_Amount;
			$invoice->grand_total = $request->grandtotal;
			$invoice->paid_amount = $request->paidamount;
			$invoice->amount_recevied = $request->paidamount;
			$invoice->discount = $request->Discount;
			$invoice->details = $request->Details;
			$invoice->type = $type;
			$invoice->sales_service_id = $sales_service_id;

			//custom field save	
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
					$invoiceData = $val1;
				}	
				$invoice->custom_field = $invoiceData;
			}

			$invoice->save();
			
			$tbl_invoicess = DB::table('tbl_invoices')->orderBy('id','desc')->first();
			$invoiceid = $tbl_invoicess->id;
			
			$tbl_payment_records = new  tbl_payment_records;
			$tbl_payment_records->invoices_id = $invoiceid;
			$tbl_payment_records->payment_number = $request->paymentno;
			$tbl_payment_records->amount = $request->paidamount;
			$tbl_payment_records->payment_type = $request->Payment_type;
			$tbl_payment_records->payment_date = $dates;
			$tbl_payment_records->save();
			
			if($type == 0)
			{
				$main_label = "Service";
			}
			elseif($type == 1)
			{
				$main_label = "Sales";
			}
			else
			{ 
				$main_label = "Sale Part";
			}
			
			$tbl_incomes = new Income;
			$tbl_incomes->invoice_number = $invoice_number;
			$tbl_incomes->payment_number = $request->paymentno;
			$tbl_incomes->customer_id = $request->Customer;
			$tbl_incomes->status = $request->Status;
			$tbl_incomes->payment_type = $request->Payment_type;
			$tbl_incomes->date = $dates;
			$tbl_incomes->main_label = $main_label;
			$tbl_incomes->save();
			
			$tbl_income_id = DB::table('tbl_incomes')->orderBy('id','DESC')->first();
		
			$tbl_income_history_records = new IncomeHistoryRecord;
			$tbl_income_history_records->tbl_income_id = $tbl_income_id->id;
			$tbl_income_history_records->income_amount = $request->paidamount;
			$tbl_income_history_records->income_label = $main_label;
			$tbl_income_history_records->save();
			//email format
			//invoice for sales in email
		
			if(!empty($type == 1))
			{				
				//PDF download
				if(!empty($sales_service_id))
				{
					$id = $sales_service_id;
					$invoice_number = $invoice_number;			
				}
				else
				{
					$id = $serviceid;
					$auto_id =$invoice->id;
				}
					
				$viewid = $id;
				$sales = DB::table('tbl_sales')->where('id','=',$id)->first();
				$v_id = $sales->vehicle_id;
				$vehicale =  DB::table('tbl_vehicles')->where('id','=',$v_id)->first();
				if($sales_service_id)
				{
					$invioce = DB::table('tbl_invoices')->where([['sales_service_id',$id],['invoice_number',$invoice_number]])->first();
				}
				else
				{
					$invioce = DB::table('tbl_invoices')->where('id',$auto_id)->first();
				}	
				if(!empty($invioce->tax_name))
				{
					$taxes = explode(', ',$invioce->tax_name);
				}
				else
				{
					$taxes='';
				}
				
			
				$rto = DB::table('tbl_rto_taxes')->where('vehicle_id','=',$v_id)->first();
				$logo = DB::table('tbl_settings')->first();	
			
				$pdf = PDF::loadView('invoice.salesinvoicepdfl',compact('viewid','vehicale','sales','logo','invioce','taxes','rto'));
				
				$str = "1234567890";
				$str1 = str_shuffle($str);
				
				$pdf->save('public/pdf/sales/'.$str1.'.pdf');
				
				// return $pdf->download('salesinvoice.pdf');
																
				//end pdf
			
				$sales = DB::table('tbl_sales')->where('id','=',$sales_service_id)->first();
				
				$v_id = $sales->vehicle_id;
				$c_id = $sales->customer_id;
				$bill_no = $sales->bill_no;
				$s_date = $sales->date;
				$totalamount = $sales->total_price;
				$total_price = $sales->total_price;
			
				if(!empty($rto))
				{
					$rto_reg = $rto->registration_tax; 
					$rto_plate = $rto->number_plate_charge;
					$rto_road = $rto->muncipal_road_tax;
				}
				if(!empty($rto)){ 
					$rto_charges = $rto_reg + $rto_plate + $rto_road; 
				}
				if(!empty($rto))
				{ 
					$total_amt = $total_price + $rto_charges;
				}else{
					$total_amt = $total_price;
				}

				$discount = ($total_amt*$invioce->discount)/100;
				$after_dis_total = $total_amt - $discount;
				if(!empty($taxes)) 
				{
					$total_tax = 0;
					$taxes_amount = 0;
					foreach($taxes as $tax)
					{
						$taxes_per = preg_replace("/[^0-9,.]/", "", $tax);
						
						$taxes_amount = ($after_dis_total*$taxes_per)/100;
						
						$total_tax +=  $taxes_amount;
					}
					$final_grand_total = $after_dis_total+$total_tax;
				}
				else
				{
					$final_grand_total = $after_dis_total;
				}
			
				$vehicale =  DB::table('tbl_vehicles')->where('id','=',$v_id)->first();
				//$taxes = DB::table('tbl_sales_taxes')->where('sales_id','=',$id)->get();
				$rto = DB::table('tbl_rto_taxes')->where('vehicle_id','=',$v_id)->first();
				$invioce = DB::table('tbl_invoices')->where('sales_service_id',$sales_service_id)->first();
				if(!empty($invioce->tax_name))
				{
					$taxes = explode(', ',$invioce->tax_name);
				}
				else
				{
					$taxes='';
				}
				$user=DB::table('users')->where('id','=',$c_id)->first();
				$email=$user->email;
				$firstname=$user->name;
				$logo = DB::table('tbl_settings')->first();
				$systemname=$logo->system_name;
				$emailformats=DB::table('tbl_mail_notifications')->where('notification_for','=','Sales_notification')->first();
			
				if($emailformats->is_send == 0)
				{
					if($invoice->save())
					{
						//dynamic email data
						 $emailformat=DB::table('tbl_mail_notifications')->where('notification_for','=','Sales_notification')->first();
						 
						$mail_format = $emailformat->notification_text;		
						$mail_subjects = $emailformat->subject;		 
						$mail_send_from = $emailformat->send_from; 
						$search1 = array('{ system_name }','{ invoice_ID }');
						$replace1 = array($systemname,$invoice_number);
						$mail_sub = str_replace($search1, $replace1, $mail_subjects);
						$search = array('{ system_name }','{ Customer_name }', '{ amount }','{ date }','{ invoice }');
						$replace = array($systemname, $firstname,$final_grand_total,$s_date,'invoice');
						
						$email_content = str_replace($search, $replace, $mail_format);
			
						$server = $_SERVER['SERVER_NAME'];
						if(isset($_SERVER['HTTPS'])){
							$protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
						}
						else{
							$protocol = 'http';
						}		
						$url = URL::to('/public/pdf/sales/'.$str1.'.pdf');
						
						$fileatt = "test.pdf"; // Path to the file                  
					
						$fileatt_type = "application/pdf"; // File Type  
						$fileatt_name = $str1.'.pdf'; // Filename that will be used for the file as the attachment  
						$email_from = $mail_send_from; // Who the email is from  
						$email_subject = $mail_sub; // The Subject of the email  
						$email_message = $email_content;
						
						$email_to = $email; // Who the email is to  
						/* $headers = "{$from}";  */
						$headers = "From: ".$email_from;  
						
						$file = fopen($url,'rb');  


						$contents = file_get_contents($url); // read the remote file
						touch('temp.pdf'); // create a local EMPTY copy
						file_put_contents('temp.pdf', $contents);


						$data = fread($file,filesize("temp.pdf"));  
						// $data = fread($file,19189);  
						fclose($file);  
						$semi_rand = md5(time());  
						$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";  
							
						$headers .= "\nMIME-Version: 1.0\n" .  
									"Content-Type: multipart/mixed;\n" .  
									" boundary=\"{$mime_boundary}\"";  
						$email_message .= "This is a multi-part message in MIME format.\n\n" .  
										"--{$mime_boundary}\n" .  
										"Content-Type:text/html; charset=\"iso-8859-1\"\n" .  
									   "Content-Transfer-Encoding: 7bit\n\n" .  
						$email_message .= "\n\n";  
						// $data = chunk_split(base64_encode($data));   
						$data = chunk_split(base64_encode(file_get_contents('temp.pdf')));
						$email_message .= "--{$mime_boundary}\n" .  
										  "Content-Type: {$fileatt_type};\n" .  
										  " name=\"{$fileatt_name}\"\n" .  
										  //"Content-Disposition: attachment;\n" .  
										  //" filename=\"{$fileatt_name}\"\n" .  
										  "Content-Transfer-Encoding: base64\n\n" .  
										 $data .= "\n\n" .  
										  "--{$mime_boundary}--\n";  
										  
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
							'logo' => $logo,
							'rto' => $rto,
							'taxes' => $taxes,
							'vehicale' => $vehicale,
							'sales' => $sales,
							'pdf'=>$pdf->output(),
							'str'=>$str1.'.pdf',
							);
							 
							  
							$data1 =	Mail::send('sales.salesmail',$data, function ($message) use ($data){

									$message->from($data['emailsend'],'noreply');
									$message->attachData($data['pdf'], "salesinvoice.pdf");
									$message->to($data['email'])->subject($data['mail_sub1']);
								});
						}
						else
						{					  
							$ok = mail($email_to, $email_subject, $email_message, $headers);
						}	
					}
				}
				//Generating free service coupons in sales 
				
				$sales = DB::table('tbl_sales')->where('id','=',$sales_service_id)->first();
				$salesid = $sales->id;
				$c_id = $sales->customer_id;
				$v_id = $sales->vehicle_id;
				$vehicle = DB::table('tbl_vehicles')->where('id','=',$v_id)->first();
				$manufacturer = getVehicleBrands($vehicle->vehiclebrand_id);
				$modelname = $vehicle->modelname;
				
				$tbl_services = DB::table('tbl_services')->where('sales_id','=',$salesid)->get()->toArray();
				foreach($tbl_services as $tbl_servicess)
				{
					$coupons = $tbl_servicess->job_no;
				}
				$user = DB::table('users')->where('id','=',$c_id)->first();
				$email = $user->email;
				$firstname = $user->name;
				$logo = DB::table('tbl_settings')->first();
				$systemname = $logo->system_name;
				$emailformats = DB::table('tbl_mail_notifications')->where('notification_for','=','free_service_coupons')->first();
				if($emailformats->is_send == 0)
				{
					if($invoice->save())
					{
						$emailformat = DB::table('tbl_mail_notifications')->where('notification_for','=','free_service_coupons')->first();
						$mail_format = $emailformat->notification_text;		
						$mail_subjects = $emailformat->subject;		
						$mail_send_from = $emailformat->send_from;
						
						$search1 = array('{ manufacturer }','{ model_Number }');
						$replace1 = array($manufacturer,$modelname);
						
						$mail_sub = str_replace($search1, $replace1, $mail_subjects);
						
						$message = '<html><body>';
						$message .= '<br/><table rules="all" style="border-color: #666;" border="1" cellpadding="10">';
						$message .= "<tr style='background: #eee;'><td><strong>Free-service coupan</strong> </td></tr>";
						foreach($tbl_services as $tbl_servicess)
						{
							$message .= "<tr><td>".$tbl_servicess->job_no ."</td></tr>";
							
						}
						$message .= "</table><br/><br/>";
						$message .= "</body></html>";
						
						$search = array('{ system_name }','{ Customer_name }', '{ manufacturer }','{ model_Number }','{ coupon_list }');
						$replace = array($systemname, $firstname,$manufacturer,$modelname,$message);
						
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
							);
							$data1 =	Mail::send('sales.salescouponfree',$data, function ($message) use ($data){

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
			}

			// invoice for service in message 
			if(!empty($type == 0))
			{
				
				//pdf download
				
					$serviceid =$sales_service_id;
		
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
						$service_taxes='';
					}
					
					$discount = $service_tax->discount;
					$logo = DB::table('tbl_settings')->first();
					
					$pdf = PDF::loadView('invoice.serviceinvoicepdf',compact('serviceid','tbl_services','sales','logo','job','s_date','vehical','customer','service_pro','service_pro2','tbl_service_observation_points','service_tax','service_taxes','discount'));
					$str = "1234567890";
					$str1 = str_shuffle($str);
					
					$pdf->save('public/pdf/service/'.$str1.'.pdf');
					
				//End pdf
				
				//email format	
				$tbl_services = DB::table('tbl_services')->where('id','=',$sales_service_id)->first();
		
				$c_id=$tbl_services->customer_id;
				$title=$tbl_services->title;
				$v_id=$tbl_services->vehicle_id;
				
				$s_id = $tbl_services->sales_id;
				$sales = DB::table('tbl_sales')->where('id','=',$s_id)->first();
				
				$job=DB::table('tbl_jobcard_details')->where('service_id','=',$sales_service_id)->first();
				$outdate = $job->out_date;
				$s_date = DB::table('tbl_sales')->where('vehicle_id','=',$v_id)->first();
				
				$vehical=DB::table('tbl_vehicles')->where('id','=',$v_id)->first();
				
				$customer=DB::table('users')->where('id','=',$c_id)->first();
				
				$service_tax = DB::table('tbl_invoices')->where('sales_service_id','=',$sales_service_id)->first();
				if(!empty($service_tax->tax_name))
				{
					$service_taxes = explode(', ', $service_tax->tax_name);
				}
				else
				{
					$service_taxes = '';
				}
				
				$discount = $service_tax->discount;
				
				$service_pro = DB::table('tbl_service_pros')->where('service_id','=',$sales_service_id)
														  ->where('type','=',0)
														  ->where('chargeable','=',1)
														  ->get()->toArray();
				
				$total1=0;
				$i = 1 ;
				foreach($service_pro as $service_pros)
				{ 
					$total1 += $service_pros->total_price;
				}
				$total2=0;
				$i = 1 ;
				foreach($service_pro2 as $service_pros)
				{	
					$total2 += $service_pros->total_price;
				}
				$fix = $tbl_services->charge; 
				$total_amt = $total1 + $total2 + $fix;
				$dis = $service_tax->discount; $discount = ($total_amt*$dis)/100;
				$after_dis_total = $total_amt-$discount;
				$all_taxes = 0;
				$total_tax = 0;
				if(!empty($service_taxes))
				{
					foreach($service_taxes as $ser_tax)
					{ 
						$taxes_to_count = preg_replace("/[^0-9,.]/", "", $ser_tax);
					
						$all_taxes = ($after_dis_total*$taxes_to_count)/100;  
						
						$total_tax +=  $all_taxes;
					}
					$final_grand_total = $after_dis_total+$total_tax;	
				}
				else
				{
					$final_grand_total = $after_dis_total;
				}
				$tbl_service_observation_points = DB::table('tbl_service_observation_points')->where('services_id','=',$sales_service_id)->get()->toArray();
				
				$logo = DB::table('tbl_settings')->first();
				$systemname=$logo->system_name;
				
				$user=DB::table('users')->where('id','=',$c_id)->first();
				$email=$user->email;
				$firstname=$user->name;	
				$emailformats=DB::table('tbl_mail_notifications')->where('notification_for','=','done_service_invoice')->first();
				if($emailformats->is_send == 0)
				{
				if($invoice->save())
				{
					$emailformat=DB::table('tbl_mail_notifications')->where('notification_for','=','done_service_invoice')->first();
						$mail_format = $emailformat->notification_text;		
						$mail_subjects = $emailformat->subject;		
						$mail_send_from = $emailformat->send_from;
						
						$search1 = array('{ jobcard_no }');
						$replace1 = array($jobcard);
						$mail_sub = str_replace($search1, $replace1, $mail_subjects);
				
						$search = array('{ system_name }','{ Customer_name }', '{ service_title }','{ service_date }','{ total_amount }','{ Invoice }');
						$replace = array($systemname, $firstname,$title,$outdate,$final_grand_total,'invoice');
						
						$email_content = str_replace($search, $replace, $mail_format);
						
						//live format email
						
							$server = $_SERVER['SERVER_NAME'];
							if(isset($_SERVER['HTTPS'])){
								$protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
							}
							else{
								$protocol = 'http';
							}		
							// $url = "$protocol://$server/garage/public/pdf/service/".$str1.'.pdf';
							$url = URL::to('/public/pdf/service/'.$str1.'.pdf');
							$fileatt = "test.pdf"; // Path to the file                  
						
							$fileatt_type = "application/pdf"; // File Type  
							$fileatt_name = $str1.'.pdf'; // Filename that will be used for the file as the attachment  
							$email_from = $mail_send_from; // Who the email is from  
							$email_subject = $mail_sub; // The Subject of the email  
							$email_message = $email_content;
							
							$email_to = $email; // Who the email is to  
							/* $headers = "{$from}";  */
							$headers = "From: ".$email_from;  
							
							$file = fopen($url,'rb');  


							$contents = file_get_contents($url); // read the remote file
							touch('temp.pdf'); // create a local EMPTY copy
							file_put_contents('temp.pdf', $contents);


							$data = fread($file,filesize("temp.pdf"));  
							// $data = fread($file,19189);  
							fclose($file);  
							$semi_rand = md5(time());  
							$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";  
								
							$headers .= "\nMIME-Version: 1.0\n" .  
										"Content-Type: multipart/mixed;\n" .  
										" boundary=\"{$mime_boundary}\"";  
							$email_message .= "This is a multi-part message in MIME format.\n\n" .  
											"--{$mime_boundary}\n" .  
											"Content-Type:text/html; charset=\"iso-8859-1\"\n" .  
										   "Content-Transfer-Encoding: 7bit\n\n" .  
							$email_message .= "\n\n";  
							// $data = chunk_split(base64_encode($data));   
							$data = chunk_split(base64_encode(file_get_contents('temp.pdf')));
							$email_message .= "--{$mime_boundary}\n" .  
											  "Content-Type: {$fileatt_type};\n" .  
											  " name=\"{$fileatt_name}\"\n" .  
											  //"Content-Disposition: attachment;\n" .  
											  //" filename=\"{$fileatt_name}\"\n" .  
											  "Content-Transfer-Encoding: base64\n\n" .  
											 $data .= "\n\n" .  
											  "--{$mime_boundary}--\n"; 

					$actual_link = $_SERVER['HTTP_HOST'];
					$startip='0.0.0.0';
					$endip='255.255.255.255';
					if(($actual_link == 'localhost' || $actual_link == 'localhost:8080') || ($actual_link >= $startip && $actual_link <=$endip ))
					{
						//local format email
						
						$data=array(
						'email'=>$email,
						'mail_sub1' => $mail_sub,
						'emailsend' =>$mail_send_from,
						'email_content1' => $email_content,
						
						'service_pro' => $service_pro,
						'service_pro2' => $service_pro2,
						'tbl_services' => $tbl_services,
						'sales' => $sales,
						'job' => $job,
						's_date' => $s_date,
						'vehical' => $vehical,
						'customer' => $customer,
						'tbl_service_observation_points' => $tbl_service_observation_points,
						'service_tax' => $service_tax,
						'logo' => $logo,
						'pdf'=>$pdf->output(),
						'str'=>$str1.'.pdf',
						);
						$data1 =	Mail::send('jobcard.servicedone',$data, function ($message) use ($data){

								$message->from($data['emailsend'],'noreply');
								$message->attachData($data['pdf'], "serviceinvoice.pdf");
								$message->to($data['email'])->subject($data['mail_sub1']);
							});
					}	
					else
					{
						$ok = mail($email_to, $email_subject, $email_message, $headers);
					}
				}
			}
		}
		if(!empty($type == 2))
		{
			
				//PDF download
				if(!empty($sales_service_id))
				{
					$id = $sales_service_id;
					$invoice_number = $invoice_number;			
				}
				else
				{
					$id = $serviceid;
					$auto_id =$invoice->id;
				}
			
				$viewid = $id;
				
				
				$salespart = DB::table('tbl_sale_parts')->where('id','=',$id)->first();
				$p_id = $salespart->product_id;
				
				$products_data =  DB::table('tbl_products')->where('id','=',$p_id)->first();
			
				if($sales_service_id)
				{
					$invioce = DB::table('tbl_invoices')->where([['sales_service_id',$id],['invoice_number',$invoice_number]])->first();
					
				}
				else
				{
					$invioce = DB::table('tbl_invoices')->where('id',$auto_id)->first();
				}	
				if(!empty($invioce->tax_name))
				{
					$taxes = explode(', ',$invioce->tax_name);
				}
				else
				{
					$taxes='';
				}

				$logo = DB::table('tbl_settings')->first();	
			
				$pdf = PDF::loadView('invoice.sales_partinvoicepdfl',compact('viewid','products_data','salespart','logo','invioce','taxes'));
				
				$str = "abcdefghijklmnopqrstuvwxyz";
				$str1 = str_shuffle($str);
				
				$pdf->save('public/pdf/sales/'.$str1.'.pdf');
				
				// return $pdf->download('salesinvoice.pdf');
		
				//end pdf				
				
			return redirect('/sales_part/list')->with('message','Successfully Submitted');
		}
		return redirect('invoice/list')->with('message','Successfully Submitted');
	}
	
	public function sale_part_store(Request $request)
	{
		$Date = $request->Date;

	    if(getDateFormat() == 'm-d-Y')
		{
			$dates = date('Y-m-d',strtotime(str_replace('-','/', $Date)));
		}
		else
		{
			$dates = date('Y-m-d',strtotime($Date));
		}

		$sales_service_id=$request->jobcard_no;
		$type=$request->Invoice_type;
		$invoice_number = $request->Invoice_Number;
		
		$invoice= new Invoice;
		$invoice->invoice_number = $invoice_number;
		$invoice->payment_number = $request->paymentno;
		$invoice->customer_id = $request->Customer;
		$jobcard = $request->Job_card;
		$vehicle = $request->Vehicle;
		if(!empty($jobcard))
		{ $invoice->job_card = $jobcard; }
		else
		{ $invoice->job_card = $vehicle; }
		$invoice->date = $dates;
		$invoice->payment_type = $request->Payment_type;
		$invoice->payment_status = $request->Status;

		$Taxs = $request->Tax;
		if(!empty($Taxs))
		{
			$invoice->tax_name = implode(', ', $Taxs);
		}
		// $invoice->tax_name = $taxes;
		$invoice->total_amount = $request->Total_Amount;
		$invoice->grand_total = $request->grandtotal;
		$invoice->paid_amount = $request->paidamount;
		$invoice->amount_recevied = $request->paidamount;
		$invoice->discount = $request->Discount;
		$invoice->details = $request->Details;
		$invoice->type = $type;
		$invoice->sales_service_id =$sales_service_id;
		$invoice->save();
		
		$tbl_invoicess = DB::table('tbl_invoices')->orderBy('id','desc')->first();
		$invoiceid=$tbl_invoicess->id;
		
		$tbl_payment_records = new  tbl_payment_records;
		$tbl_payment_records->invoices_id = $invoiceid;
		$tbl_payment_records->payment_number = $request->paymentno;
		$tbl_payment_records->amount = $request->paidamount;
		$tbl_payment_records->payment_type = $request->Payment_type;
		$tbl_payment_records->payment_date = $dates;
		$tbl_payment_records->save();
		
		if($type == 0)
		{
			$main_label="Service";
		}
		elseif($type == 1)
		{
			$main_label="Sales";
		}
		else
		{ 
			$main_label="Sale Part";
		}
		$tbl_incomes = new Income;
		$tbl_incomes->invoice_number=$invoice_number;
		$tbl_incomes->payment_number=$request->paymentno;
		$tbl_incomes->customer_id=$request->Customer;
		$tbl_incomes->status=$request->Status;
		$tbl_incomes->payment_type =$request->Payment_type;
		$tbl_incomes->date=$dates;
		$tbl_incomes->main_label=$main_label;
		$tbl_incomes->save();
		
		$tbl_income_id = DB::table('tbl_incomes')->orderBy('id','DESC')->first();
	
		$tbl_income_history_records = new IncomeHistoryRecord;
		$tbl_income_history_records->tbl_income_id = $tbl_income_id->id;
		$tbl_income_history_records->income_amount = $request->paidamount;
		$tbl_income_history_records->income_label = $main_label;
		$tbl_income_history_records->save();
		//email format
		//invoice for sales in email
			
		if(!empty($type == 2))
		{
			
				//PDF download
				if(!empty($sales_service_id))
				{
					$id = $sales_service_id;
					$invoice_number = $invoice_number;			
				}
				else
				{
					$id = $serviceid;
					$auto_id =$invoice->id;
				}
			
				$viewid = $id;
				
				
				$salespart = DB::table('tbl_sale_parts')->where('id','=',$id)->first();
				$p_id = $salespart->product_id;
				
				$products_data =  DB::table('tbl_products')->where('id','=',$p_id)->first();
			
				if($sales_service_id)
				{
					$invioce = DB::table('tbl_invoices')->where([['sales_service_id',$id],['invoice_number',$invoice_number]])->first();
					
				}
				else
				{
					$invioce = DB::table('tbl_invoices')->where('id',$auto_id)->first();
				}	
				if(!empty($invioce->tax_name))
				{
					$taxes = explode(', ',$invioce->tax_name);
				}
				else
				{
					$taxes='';
				}

				$logo = DB::table('tbl_settings')->first();	
			
				$pdf = PDF::loadView('invoice.sales_partinvoicepdfl',compact('viewid','products_data','salespart','logo','invioce','taxes'));
				
				$str = "abcdefghijklmnopqrstuvwxyz";
				$str1 = str_shuffle($str);
				
				$pdf->save('public/pdf/sales/'.$str1.'.pdf');
				
				// return $pdf->download('salesinvoice.pdf');
		
				//end pdf

			return redirect('/sales_part/list')->with('message','Successfully Submitted');
		}
	}

	//invoice pay 
	public function pay(Request $request)
	{
		$id = $request->id;
		$characters = '0123456789';
		$code =  'P'.''.substr(str_shuffle($characters),0,6);
		$tbl_invoices = DB::table('tbl_invoices')->where('id','=',$id)->first();
		$total = $tbl_invoices->grand_total;
		$paid_amount = $tbl_invoices->paid_amount;
		$dueamount = $total - $paid_amount;

		//$tbl_payments = DB::table('tbl_payments')->get()->toArray();
		$tbl_payments = DB::table('tbl_payments')->where('soft_delete','=',0)->get()->toArray();

		return view('invoice/pay',compact('tbl_invoices','code','dueamount','tbl_payments'));
	}
	
	//invoice pay update
	public function payupdate(Request $request, $id)
	{

		$Date = $request->Date;
		if(getDateFormat() == 'm-d-Y')
		{
			$paymentdate = date('Y-m-d',strtotime(str_replace('-','/', $Date)));
		}
		else
		{	
			$paymentdate = date('Y-m-d',strtotime($Date));
		}

		$tbl_payment_records = new tbl_payment_records;
		$tbl_payment_records->invoices_id = $id;
		$tbl_payment_records->amount = $request->receiveamount;
		$tbl_payment_records->payment_type = $request->Payment_type;
		$tbl_payment_records->payment_date = $paymentdate;
		$tbl_payment_records->note = $request->note;
		$tbl_payment_records->payment_number = $request->paymentno;
		$tbl_payment_records->save();
		
		$tbl_invoices = DB::table('tbl_invoices')->where('id','=',$id)->first();
		$invoice_number = $tbl_invoices->invoice_number;
		$customer_id = $tbl_invoices->customer_id;
		$paid_amount = $tbl_invoices->paid_amount;
		$grandtotal = $tbl_invoices->grand_total;
		$amount = $request->receiveamount;
		$total = $paid_amount + $amount;
		
		
		$tblin = Invoice::find($id);
		$tblin->paid_amount = $total;
		if($grandtotal == $total )
		{
			$status = 2;
			$tblin->payment_status = $status;
			
		}elseif($grandtotal > $total && $total > 0)
		{
			$status = 1;
			$tblin->payment_status = $status;
			
		}elseif($total == 0)
		{
			$status = 0;
			$tblin->payment_status = $status;
		}
		$tblin->save();
		
		if($tbl_invoices->type == 0)
		{
			$main_label = "Service";
		}
		elseif($tbl_invoices->type == 1)
		{
			$main_label = "Sales";
		}
		else
		{ 
			$main_label = "";
		}
		$tbl_incomes = new Income;
		$tbl_incomes->invoice_number = $invoice_number;
		$tbl_incomes->payment_number = $request->paymentno;
		$tbl_incomes->customer_id = $customer_id;
		$tbl_incomes->status = $status;
		$tbl_incomes->payment_type = $request->Payment_type;
		$tbl_incomes->date = $paymentdate;
		$tbl_incomes->main_label = $main_label;
		$tbl_incomes->save();
		
		$tbl_income_id = DB::table('tbl_incomes')->orderBy('id','DESC')->first();
	
		$tbl_income_history_records = new IncomeHistoryRecord;
		$tbl_income_history_records->tbl_income_id = $tbl_income_id->id;
		$tbl_income_history_records->income_amount = $amount;
		$tbl_income_history_records->income_label = $main_label;
		$tbl_income_history_records->save();
		
		return redirect('/invoice/list')->with('message','Successfully Submitted');	
	}
	//invoice edit
	public function edit($id)
	{	
		$invoice_edit = DB::table('tbl_invoices')->where('id','=',$id)->first();
		$type = $invoice_edit->type; 
		
		if($type == 1)
		{
			$customer = DB::table('tbl_sales')->select('customer_id')->groupBy('customer_id')->get()->toArray();
		}
		else
		{
			$customer = DB::table('tbl_services')->where('done_status','=',1)->groupBy('customer_id')->get()->toArray();
		}
		$total=$invoice_edit->grand_total;
		$paid_amount=$invoice_edit->paid_amount;
		$dueamount=$total - $paid_amount;

		/*$tax = DB::table('tbl_account_tax_rates')->get()->toArray();
		$tbl_payments = DB::table('tbl_payments')->get()->toArray();*/
		$tax = DB::table('tbl_account_tax_rates')->where('soft_delete','=',0)->get()->toArray();
		$tbl_payments = DB::table('tbl_payments')->where('soft_delete','=',0)->get()->toArray();

		//Custom Field Data of Invoice Table
		$tbl_custom_fields = DB::table('tbl_custom_fields')->where([['form_name','=','invoice'],['always_visable','=','yes'],['soft_delete','=',0]])->get()->toArray();

		return view('invoice/edit',compact('invoice_edit','customer','tax','dueamount','tbl_payments','tbl_custom_fields'));
	}

	//invoice update
	public function update(Request $request, $id)
	{
		//dd($request->all());
		$tbl_invoices = DB::table('tbl_invoices')->where('id','=',$id)->first();
		$paid_amount = $tbl_invoices->paid_amount;
		$invoice_number = $tbl_invoices->invoice_number;
		
		$payment_number = $tbl_invoices->payment_number;
		
		$type = $tbl_invoices->type;
		$amount_recevied = 0;
		$amount_recevied = $tbl_invoices->amount_recevied;
		
		$paidamount = $request->paidamount;
		
		if($amount_recevied > $paidamount )
		{
			$amount = $amount_recevied - $paidamount;
			$paid_amount1 = $paid_amount - $amount;
		}
		if($amount_recevied < $paidamount )
		{
			$amount = $paidamount - $amount_recevied;
			$paid_amount1 = $paid_amount + $amount;
		}
		if($amount_recevied == $paidamount )
		{
			$paid_amount1 = $paid_amount;
		}

		$Date = $request->Date;
		if(getDateFormat() == 'm-d-Y')
		{
			$dates = date('Y-m-d',strtotime(str_replace('-','/', $Date)));
		}
		else
		{
			$dates = date('Y-m-d',strtotime($Date));
		}
		$invoice = Invoice::find($id);
		// $taxes = implode(', ',Input::get('Tax'));
		
		$invoice->invoice_number = $request->Invoice_Number;
		//$invoice->customer_id = Input::get('Customer');
		//$invoice->job_card = Input::get('Job_card');
		$invoice->date = $dates;
		$invoice->payment_type = $request->Payment_type;
		$invoice->payment_status = $request->Status;

		$taxs = $request->Tax;
		if(!empty($taxs))
		{
			$invoice->tax_name = implode(', ', $taxs);
		}
		// $invoice->tax_name = $taxes;
		$invoice->total_amount = $request->Total_Amount;
		$invoice->grand_total = $request->grandtotal;
		$invoice->discount = $request->Discount;
		$invoice->amount_recevied = $request->paidamount;
		$invoice->paid_amount = $paid_amount1;
		$invoice->details = $request->Details;
		$invoice->sales_service_id = $request->jobcard_no;

		//Custom Field Data for Invoice table
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
				$invoiceData = $val1;
			}	
			$invoice->custom_field = $invoiceData;
		}

		$invoice->save();
			
			$tbl_payment_records = DB::table('tbl_payment_records')->where([['invoices_id','=',$id],['payment_number','=',$payment_number]])->first();
			if(!empty($tbl_payment_records))
			{
				$paymentno = $tbl_payment_records->payment_number;
				$payid = $tbl_payment_records->id;
				$invoiceid = $tbl_payment_records->invoices_id;
				
				$tbl_payment_records = tbl_payment_records::find($payid);
				$tbl_payment_records->invoices_id = $invoiceid;
				$tbl_payment_records->payment_number = $paymentno;
				$tbl_payment_records->amount = $request->paidamount;
				$tbl_payment_records->payment_type = $request->Payment_type;
				$tbl_payment_records->payment_date = $dates;
				$tbl_payment_records->save();
				
				if($type == 0)
				{
					$main_label = "Service";
				}
				elseif($type == 1)
				{
					$main_label = "Sales";
				}
				else
				{ 
					$main_label="";
				}
				$tbl_incomes=DB::table('tbl_incomes')->where([['invoice_number','=',$invoice_number],['payment_number','=',$payment_number]])->first();
				
				$incomesid = $tbl_incomes->id;
				
				$tbl_incomes = Income::find($incomesid);
				$tbl_incomes->invoice_number = $invoice_number;
				$tbl_incomes->payment_number = $payment_number;
				$tbl_incomes->customer_id = $request->Customer;
				$tbl_incomes->status = $request->Status;
				$tbl_incomes->payment_type = $request->Payment_type;
				$tbl_incomes->date = $dates;
				$tbl_incomes->main_label = $main_label;
				$tbl_incomes->save();
				
				$tbl_income_id = DB::table('tbl_income_history_records')->where('tbl_income_id','=',$incomesid)->first();
				
				$tbl_incomeid = $tbl_income_id->id;
				$tbl_income_history_records = IncomeHistoryRecord::find($tbl_incomeid);
				$tbl_income_history_records->tbl_income_id = $incomesid;
				$tbl_income_history_records->income_amount = $request->paidamount;
				$tbl_income_history_records->income_label = $main_label;
				$tbl_income_history_records->save();
			}
			else
			{
				$tbl_payment_records = new  tbl_payment_records;
				$tbl_payment_records->invoices_id = $id;
				$tbl_payment_records->payment_number = $payment_number;
				$tbl_payment_records->amount = $request->paidamount;
				$tbl_payment_records->payment_type = $request->Payment_type;
				$tbl_payment_records->payment_date = $dates;
				$tbl_payment_records->save();
				
				if($type == 0)
				{
					$main_label="Service";
				}
				elseif($type == 1)
				{
					$main_label="Sales";
				}
				else
				{ 
					$main_label="";
				}
				$tbl_incomes = new Income;
				$tbl_incomes->invoice_number = $invoice_number;
				$tbl_incomes->payment_number = $payment_number;
				$tbl_incomes->customer_id = $request->Customer;
				$tbl_incomes->status = $request->Status;
				$tbl_incomes->payment_type = $request->Payment_type;
				$tbl_incomes->date = $dates;
				$tbl_incomes->main_label = $main_label;
				$tbl_incomes->save();
				
				$tbl_income_id = DB::table('tbl_incomes')->orderBy('id','DESC')->first();
			
				$tbl_income_history_records = new IncomeHistoryRecord;
				$tbl_income_history_records->tbl_income_id = $tbl_income_id->id;
				$tbl_income_history_records->income_amount = $request->paidamount;
				$tbl_income_history_records->income_label = $main_label;
				$tbl_income_history_records->save();				
			}
	
			return redirect('invoice/list')->with('message','Successfully Updated');;	
	}
	
	//invoice paymentview
	public function paymentview(Request $request)
	{
		//$invoice_id = Input::get('invoice_id');
		$invoice_id = $request->invoice_id;
		$tbl_invoices = DB::table('tbl_invoices')->where('id','=',$invoice_id)->first();
		$tbl_payment_records = DB::table('tbl_payment_records')->where('invoices_id','=',$invoice_id)->get()->toArray();
		$html = view('invoice.paymentview')->with(compact('tbl_invoices','tbl_payment_records'))->render();
		return response()->json(['success' => true, 'html' => $html]);;
	}

	//invoice delete
	public function destroy($id)
	{		
		//$tbl_payment_records=DB::table('tbl_payment_records')->where('invoices_id','=',$id)->delete();
		$tbl_payment_records=DB::table('tbl_payment_records')->where('invoices_id','=',$id)->update(['soft_delete' => 1]);

		$tbl_invoices=DB::table('tbl_invoices')->where('id','=',$id)->first();
		$invoice_no=$tbl_invoices->invoice_number;
		$incomes_id=DB::table('tbl_incomes')->where('invoice_number','=',$invoice_no)->first();


		if(!empty($incomes_id))
		{
			$incomeid = $incomes_id->id;			

			//$tbl_incomes = DB::table('tbl_incomes')->where('invoice_number','=',$invoice_no)->delete();
			$tbl_incomes = DB::table('tbl_incomes')->where('invoice_number','=',$invoice_no)->update(['soft_delete' => 1]);

			$listOfIncomeDatas = DB::table('tbl_incomes')->where('invoice_number','=',$invoice_no)->get()->toArray();
			$listOfIncomeIds = [];

			foreach ($listOfIncomeDatas as $listOfIncomeData) {
				$listOfIncomeIds[] = $listOfIncomeData->id;
				//$tbl_incomes = DB::table('tbl_income_history_records')->where('tbl_income_id','=',$incomeid)->delete();
				$tbl_incomes = DB::table('tbl_income_history_records')->where('tbl_income_id','=',$listOfIncomeData->id)->update(['soft_delete' => 1]);
			}
		}
			//Invoice::destroy($id);
			Invoice::where('id','=',$id)->update(['soft_delete' => 1]);
			
			return redirect('/invoice/list')->with('message','Successfully Deleted');;
	}	
	
	//Service pdf
	public function servicepdf($id)
	{
		//$tbl_invoices = DB::table('tbl_invoices')->where('id','=',$id)->first();
		$tbl_invoices = Invoice::where('id','=',$id)->first();
		$serviceid = $tbl_invoices->sales_service_id;
		
		//$tbl_services = DB::table('tbl_services')->where('id','=',$serviceid)->first();
		$tbl_services = Service::where('id','=',$serviceid)->first();
		
		$c_id=$tbl_services->customer_id;
		$v_id=$tbl_services->vehicle_id;
		
		$s_id = $tbl_services->sales_id;
		//$sales = DB::table('tbl_sales')->where('id','=',$s_id)->first();
		$sales = Sale::where('id','=',$s_id)->first();
		
		//$job=DB::table('tbl_jobcard_details')->where('service_id','=',$serviceid)->first();
		$job = JobcardDetail::where('service_id','=',$serviceid)->first();

		//$s_date = DB::table('tbl_sales')->where('vehicle_id','=',$v_id)->first();
		$s_date = Sale::where('vehicle_id','=',$v_id)->first();
		
		//$vehical=DB::table('tbl_vehicles')->where('id','=',$v_id)->first();
		$vehical = Vehicle::where('id','=',$v_id)->first();
		
		//$customer=DB::table('users')->where('id','=',$c_id)->first();
		$customer = User::where('id','=',$c_id)->first();

		$service_pro=DB::table('tbl_service_pros')->where('service_id','=',$serviceid)
												  ->where('type','=',0)
												  ->where('chargeable','=',1)
												  ->get()->toArray();
		
		$service_pro2=DB::table('tbl_service_pros')->where('service_id','=',$serviceid)
												  ->where('type','=',1)->get()->toArray();
				
		$tbl_service_observation_points = DB::table('tbl_service_observation_points')->where('services_id','=',$serviceid)->get();
		
		//$service_tax = DB::table('tbl_invoices')->where('sales_service_id','=',$serviceid)->first();
		$service_tax = Invoice::where('sales_service_id','=',$serviceid)->first();
		if(!empty($service_tax->tax_name))
		{
			$service_taxes = explode(', ', $service_tax->tax_name);
		}
		else
		{
			$service_taxes='';
		}
		
		$discount = $service_tax->discount;
		//$logo = DB::table('tbl_settings')->first();
		$logo = Setting::first();


		//Custom Field  Data of Invoice Module
		$tbl_custom_fields_invoice = DB::table('tbl_custom_fields')->where([['form_name','=','invoice'],['always_visable','=','yes']])->get()->toArray();

		//Custom Field  Data of Service Module
		$tbl_custom_fields_service = DB::table('tbl_custom_fields')->where([['form_name','=','service'],['always_visable','=','yes']])->get()->toArray();

		//Custom Field Data of User Table (For Customer Module)
		$tbl_custom_fields_customers = DB::table('tbl_custom_fields')->where([['form_name','=','customer'],['always_visable','=','yes']])->get()->toArray();
		
		$pdf = PDF::loadView('invoice.serviceinvoicepdf',compact('serviceid','tbl_services','sales','logo','job','s_date','vehical','customer','service_pro','service_pro2','tbl_service_observation_points','service_tax','service_taxes','discount','tbl_custom_fields_invoice','tbl_custom_fields_service','tbl_custom_fields_customers'));
		

	    return $pdf->download('INVOICE#'.$tbl_invoices->invoice_number.'.pdf');
	}
	
	
	//Sales pdf
	public function salespdf($id)
	{
		//$invioces = DB::table('tbl_invoices')->where('id','=',$id)->first();
		$invioces = Invoice::where('id','=',$id)->first();

		$sales_service_id=$invioces->sales_service_id;
		$invoice_number=$invioces->invoice_number;
		if(!empty($sales_service_id))
		{
			$id1 = $sales_service_id;
			$invoice_number = $invoice_number;			
		}
		else
		{
			$id = $serviceid;
			$auto_id =$invoice->id;
			
		}
			
		$viewid = $id;
		//$sales = DB::table('tbl_sales')->where('id','=',$id1)->first();
		$sales = Sale::where('id','=',$id1)->first();
		$v_id = $sales->vehicle_id;
		//$vehicale =  DB::table('tbl_vehicles')->where('id','=',$v_id)->first();
		$vehicale =  Vehicle::where('id','=',$v_id)->first();
		if($sales_service_id)
		{
			//$invioce = DB::table('tbl_invoices')->where([['sales_service_id',$id1],['invoice_number',$invoice_number]])->first();
			$invioce = Invoice::where([['sales_service_id',$id1],['invoice_number',$invoice_number]])->first();
		}
		else
		{
			//$invioce = DB::table('tbl_invoices')->where('id',$id)->first();
			$invioce = Invoice::where('id',$id)->first();
		}	
		if(!empty($invioce->tax_name))
		{
			$taxes = explode(', ',$invioce->tax_name);
		}
		else
		{
			$taxes='';
		}
		
	
		//$rto = DB::table('tbl_rto_taxes')->where('vehicle_id','=',$v_id)->first();
		$rto = RtoTax::where('vehicle_id','=',$v_id)->first();

		//$logo = DB::table('tbl_settings')->first();	
		$logo = Setting::first();	


		//Custom Field Data of Sales Table
		$tbl_custom_fields_sales = DB::table('tbl_custom_fields')->where([['form_name','=','sales'],['always_visable','=','yes']])->get()->toArray();


		//Custom Field Data of Invoice Table
		$tbl_custom_fields_invoice = DB::table('tbl_custom_fields')->where([['form_name','=','invoice'],['always_visable','=','yes']])->get()->toArray();

		//Custom Field Data of User Table (For Customer Module)
		$tbl_custom_fields_customers = DB::table('tbl_custom_fields')->where([['form_name','=','customer'],['always_visable','=','yes']])->get()->toArray();

	
		$pdf = PDF::loadView('invoice.salesinvoicepdfl',compact('viewid','vehicale','sales','logo','invioce','taxes','rto','tbl_custom_fields_sales','tbl_custom_fields_invoice','tbl_custom_fields_customers'));

		return $pdf->download('INVOICE#'.$invioces->invoice_number.'.pdf');
	}


	//For SalesPart Pdf (Created by Mukesh)
	public function salespartpdf($id)
	{
		//$invioces = DB::table('tbl_invoices')->where('id','=',$id)->first();
		$invioces = Invoice::where('id','=',$id)->first();
		$sales_service_id=$invioces->sales_service_id;
		$invoice_number=$invioces->invoice_number;
		if(!empty($sales_service_id))
		{
			$id1 = $sales_service_id;
			$invoice_number = $invoice_number;			
		}
		else
		{
			$id = $serviceid;
			$auto_id =$invoice->id;
		}
			
		$viewid = $id;
		//$salespart = DB::table('tbl_sale_parts')->where('id','=',$id1)->first();
		$salespart = SalePart::where('id','=',$id1)->first();

		//$salepart = DB::table('tbl_sale_parts')->where('id','=',$id1)->get()->toArray();
		
		$productId = $salespart->product_id;
		//$products_data =  DB::table('tbl_products')->where('id','=',$productId)->first();
		$products_data =  Product::where('id','=',$productId)->first();

		if($sales_service_id)
		{
			//$invioce = DB::table('tbl_invoices')->where([['sales_service_id',$id1],['invoice_number',$invoice_number]])->first();
			$invioce = Invoice::where([['sales_service_id',$id1],['invoice_number',$invoice_number]])->first();
		}
		else
		{
			//$invioce = DB::table('tbl_invoices')->where('id',$id)->first();
			$invioce = Invoice::where('id',$id)->first();
		}	
		if(!empty($invioce->tax_name))
		{
			$taxes = explode(', ',$invioce->tax_name);
		}
		else
		{
			$taxes='';
		}
		
		//RTO tax nothing For Sales Part 
		//$rto = DB::table('tbl_rto_taxes')->where('vehicle_id','=',$v_id)->first();
		
		//$logo = DB::table('tbl_settings')->first();
		$logo = Setting::first();


		//Custom Field  Data
		$tbl_custom_fields_salepart = DB::table('tbl_custom_fields')->where([['form_name','=','salepart'],['always_visable','=','yes']])->get()->toArray();
		//$tbl_custom_fields_salepart = CustomField::where([['form_name','=','salepart'],['always_visable','=','yes']])->get();

		//Custom Field Data of User Table (For Customer Module)
		$tbl_custom_fields_customers = DB::table('tbl_custom_fields')->where([['form_name','=','customer'],['always_visable','=','yes']])->get()->toArray();
		//$tbl_custom_fields_customers = CustomField::where([['form_name','=','customer'],['always_visable','=','yes']])->get();
	
		$pdf = PDF::loadView('invoice.sales_partinvoicepdfl',compact('viewid','products_data','salespart','logo','invioce','taxes','tbl_custom_fields_salepart','tbl_custom_fields_customers'));
		
		return $pdf->download('INVOICE#'.$invioces->invoice_number.'.pdf');
	}

}
