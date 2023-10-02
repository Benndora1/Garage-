<?php

namespace App\Http\Controllers;

use DB;
use Auth; 
use App\User;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\Role;

class Accessrightscontroller extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
	
	//accessright list
    public function index()
	{	
		$accessright=DB::table('tbl_accessrights')->get()->toArray();
		return view('accessrights.accessright',compact('accessright'));
	}
	
	//accessright store
	public function store()
	{
		$Customers=Input::get('Customers_id');
		$value = Input::get('value');
		DB::update("update tbl_accessrights set customers='$value' where id='$Customers'");
		
	}
	//emp store
	public function Employeestore()
	{
		$Employee_id=Input::get('Employee_id');
		$value = Input::get('value');
		DB::update("update tbl_accessrights set employee='$value' where id='$Employee_id'");
	}
	
	//staff store
	public function staffstore()
	{
		$Support_staff_id=Input::get('Support_staff_id');
		$value = Input::get('value');
		DB::update("update tbl_accessrights set support_staff='$value' where id='$Support_staff_id'");
	}
	
	//accountant store
	public function Accountantstore()
	{
		$Accountant_id=Input::get('Accountant_id');
		$value = Input::get('value');
		DB::update("update tbl_accessrights set accountant='$value' where id='$Accountant_id'");
	}



	/*********************New Access Rights Code**********************/

	//accessright list
    public function shows()
	{	

		//$get_rights = DB::table('roles')->where([['status', '=', 1], ["id", '!=', 1]])->get();
        $get_rights = Role::where([['status', '=', 1], ["id", '!=', 1]])->get();

		//dd($get_rights);

        return view('accessrights.new_accessrights', compact('get_rights'));
	}


	public function storeAccessRights(Request $request)
	{
		//dd($request->all());

		$id = $request->id;
        $vehicle = $request->vehicle;
        $supplier = $request->supplier;
        $product = $request->product;
        $purchase = $request->purchase;
        $stock = $request->stock;
        $dashboard = $request->dashboard;
        $customer = $request->customer;
        $employee = $request->employee;
        $supportstaff = $request->supportstaff;
        $accountant = $request->accountant;
        $vehicletype = $request->vehicletype;
        $vehiclebrand = $request->vehiclebrand;
        $colors = $request->colors;
        $service = $request->service;
        $invoice = $request->invoice;
        $jobcard = $request->jobcard;
        $gatepass = $request->gatepass;
        $taxrate = $request->taxrate;
        $paymentmethod = $request->paymentmethod;
        $income = $request->income;
        $expense = $request->expense;
        $sales = $request->sales;
        $salespart = $request->salespart;
        $rto = $request->rto;
        $report = $request->report;
        $emailtemplate = $request->emailtemplate;
        $customfield = $request->customfield;
        $observationlibrary = $request->observationlibrary;
        $generalsetting = $request->generalsetting;
        $timezone = $request->timezone;
        $language = $request->language;
        $dateformat = $request->dateformat;
        $currency = $request->currency;
        $accessrights = $request->accessrights;
        $businesshours = $request->businesshours;
        $stripesetting = $request->stripesetting;
        $quotation = $request->quotation;

        $data = "";
		
        if (!empty($vehicle)) {
            $data.= $this->store_regex($vehicle) . ',';
        }
        if (!empty($supplier)) {
            $data.= $this->store_regex($supplier) . ',';
        }	
       	if (!empty($product)) {
            $data.= $this->store_regex($product) . ',';
        }
        if (!empty($purchase)) {
            $data.= $this->store_regex($purchase) . ',';
        }
        if (!empty($stock)) {
            $data.= $this->store_regex($stock) . ',';
        }
        if (!empty($dashboard)) {
            $data.= $this->store_regex($dashboard) . ',';
        }
        if (!empty($customer)) {
            $data.= $this->store_regex($customer) . ',';
        }
        if (!empty($employee)) {
            $data.= $this->store_regex($employee) . ',';
        }
        if (!empty($supportstaff)) {
            $data.= $this->store_regex($supportstaff) . ',';
        }
        if (!empty($accountant)) {
            $data.= $this->store_regex($accountant) . ',';
        }
        if (!empty($vehicletype)) {
            $data.= $this->store_regex($vehicletype) . ',';
        }
        if (!empty($vehiclebrand)) {
            $data.= $this->store_regex($vehiclebrand) . ',';
        }
        if (!empty($colors)) {
            $data.= $this->store_regex($colors) . ',';
        }
        if (!empty($service)) {
            $data.= $this->store_regex($service) . ',';
        }
        if (!empty($invoice)) {
            $data.= $this->store_regex($invoice) . ',';
        }
        if (!empty($jobcard)) {
            $data.= $this->store_regex($jobcard) . ',';
        }
        if (!empty($gatepass)) {
            $data.= $this->store_regex($gatepass) . ',';
        }
        if (!empty($taxrate)) {
            $data.= $this->store_regex($taxrate) . ',';
        }
        if (!empty($paymentmethod)) {
            $data.= $this->store_regex($paymentmethod) . ',';
        }
        if (!empty($income)) {
            $data.= $this->store_regex($income) . ',';
        }
        if (!empty($expense)) {
            $data.= $this->store_regex($expense) . ',';
        }
        if (!empty($sales)) {
            $data.= $this->store_regex($sales) . ',';
        }
        if (!empty($salespart)) {
            $data.= $this->store_regex($salespart) . ',';
        }
        if (!empty($rto)) {
            $data.= $this->store_regex($rto) . ',';
        }
        if (!empty($report)) {
            $data.= $this->store_regex($report) . ',';
        }
        if (!empty($emailtemplate)) {
            $data.= $this->store_regex($emailtemplate) . ',';
        }
        if (!empty($customfield)) {
            $data.= $this->store_regex($customfield) . ',';
        }
        if (!empty($observationlibrary)) {
            $data.= $this->store_regex($observationlibrary) . ',';
        }
        if (!empty($generalsetting)) {
            $data.= $this->store_regex($generalsetting) . ',';
        }
        if (!empty($timezone)) {
            $data.= $this->store_regex($timezone) . ',';
        }
        if (!empty($language)) {
            $data.= $this->store_regex($language) . ',';
        }
        if (!empty($dateformat)) {
            $data.= $this->store_regex($dateformat) . ',';
        }
        if (!empty($currency)) {
            $data.= $this->store_regex($currency) . ',';
        }
        if (!empty($accessrights)) {
            $data.= $this->store_regex($accessrights) . ',';
        }
        if (!empty($businesshours)) {
            $data.= $this->store_regex($businesshours) . ',';
        }
        if (!empty($stripesetting)) {
            $data.= $this->store_regex($stripesetting) . ',';
        }

        if (!empty($quotation)) {
            $data.= $this->store_regex($quotation) . ',';
        }
        
          
        
        $final_regex = $data;
        $final = '{' . rtrim($final_regex, ',') . '}';
        
        //$access_right = DB::table('roles')->where('id', $id)->update(['permissions' => $final]);
        $access_right = Role::where('id', $id)->update(['permissions' => $final]);
        
		if ($access_right) 
		{ 
            return redirect('setting/accessrights/show')->with('message','Successfully Updated');
        }
        
        return redirect('setting/accessrights/show');
	}


	public function store_regex($modules) {
		
        $regexs = [];
        foreach ($modules as $key => $value) {
            $regexs+= [$value => true];
        }
        $regex = str_replace(array('[', ']'), '', htmlspecialchars(json_encode($regexs), ENT_NOQUOTES));
        $regex = str_replace(array('{', '}'), '', htmlspecialchars($regex, ENT_NOQUOTES));
        return $regex;
    }






}
