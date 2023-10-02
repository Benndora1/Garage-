<?php

namespace App\Http\Controllers;

use DB;
use PDF;
use Mail;
use Auth;

use App\Http\Requests;
use Illuminate\Mail\Mailer;
use Illuminate\Http\Request;

use App\User;
use App\tbl_sales;
use App\tbl_colors;
use App\tbl_services;
use App\tbl_rto_taxes;
use App\tbl_sale_parts;
use App\tbl_sales_taxes;
use App\tbl_mail_notifications;

use App\Color;
use App\Service;
use App\Sale;
use App\SalePart;
use App\Vehicle;
use App\PaymentMethod;
use App\Product;
use App\CustomField;
use App\Invoice;
use App\RtoTax;
use App\Setting;
use App\Updatekey;

class SalesPartcontroller extends Controller
{	
	public function __construct()
    {
        $this->middleware('auth');
    }

	//sales list
    public function index()
	{	
		if (!isAdmin(Auth::User()->role_id)) 
		{
			if (getUsersRole(Auth::user()->role_id) == 'Customer')
			{
				$sales = SalePart::where('product_id','!=','<>')->groupby('bill_no')->where('customer_id','=',Auth::User()->id)->orderBy('id','DESC')->get();
			}
			elseif (getUsersRole(Auth::user()->role_id) == 'Employee')
			{
				$sales = SalePart::where('salesmanname','=',Auth::User()->id)->groupby('bill_no')->where('product_id','!=','<>')->orderBy('id','DESC')->get();
			}
			elseif (getUsersRole(Auth::user()->role_id) == 'Support Staff' || getUsersRole(Auth::user()->role_id) == 'Accountant') {
				
				$sales = SalePart::where('product_id','!=','<>')->groupby('bill_no')->orderBy('id','DESC')->get();
			}
			else
			{
				$sales = SalePart::where('product_id','!=','<>')->groupby('bill_no')->orderBy('id','DESC')->get();
			}
		}
		else
		{
			$sales = SalePart::where('product_id','!=','<>')->groupby('bill_no')->orderBy('id','DESC')->get();
		}

		/*$userid=Auth::User()->id;
		if(!empty(getActiveCustomer($userid)=='yes'))
		{
			$sales = DB::table('tbl_sale_parts')->where('product_id','!=','<>')->groupby('bill_no')->orderBy('id','DESC')->get()->toArray();
		}
		elseif(!empty(getActiveEmployee($userid)=='yes'))
		{
			$sales = DB::table('tbl_sale_parts')->where('salesmanname','=',Auth::User()->id)->groupby('bill_no')->where('product_id','!=','<>')->orderBy('id','DESC')->get()->toArray();
		}
		else
		{
			$sales = DB::table('tbl_sale_parts')->where('product_id','!=','<>')->groupby('bill_no')->where('customer_id','=',Auth::User()->id)->orderBy('id','DESC')->get()->toArray();
		}*/

		return view('sales_part.list',compact('sales')); 
	}

	//sales add form
	public function addsales()
	{	
		$characters = '0123456789';
		$code =  'SP'.''.substr(str_shuffle($characters),0,6);
		//$color = DB::table('tbl_colors')->get()->toArray();
		$color = DB::table('tbl_colors')->where('soft_delete', '=', 0)->get()->toArray();

		$employee = DB::table('users')->where('role','=','Employee')->where('soft_delete', '=', 0)->get()->toArray();
		//$customer = DB::table('users')->where('role','=','Customer')->get()->toArray();
		$customer = DB::table('users')->where([['role','=','Customer'],['soft_delete', '=', 0]])->get()->toArray();

		//$taxes = DB::table('tbl_account_tax_rates')->get()->toArray();
		$taxes = DB::table('tbl_account_tax_rates')->where('soft_delete', '=', 0)->get()->toArray();

		//$payment = DB::table('tbl_payments')->get()->toArray();
		$payment = DB::table('tbl_payments')->where('soft_delete', '=', 0)->get()->toArray();

		//$brand = DB::table('tbl_products')->where('category',1)->get()->toArray();
		$brand = DB::table('tbl_products')->where([['category','=',1],['soft_delete', '=', 0]])->get()->toArray();

		//$manufacture_name = DB::table('tbl_product_types')->get()->toArray();
		$manufacture_name = DB::table('tbl_product_types')->where('soft_delete', '=', 0)->get()->toArray();

		//$tbl_custom_fields = DB::table('tbl_custom_fields')->where([['form_name','=','salepart'],['always_visable','=','yes']])->get()->toArray();
		$tbl_custom_fields = DB::table('tbl_custom_fields')->where([['form_name','=','salepart'],['always_visable','=','yes'],['soft_delete','=',0]])->get()->toArray();
		
		return view('sales_part.add',compact('customer','employee','code','color','taxes','payment','brand','manufacture_name', 'tbl_custom_fields'));
	}

	//color add
	public function coloradd(Request $request)
	{   
		$color_name = $request->c_name;
		$colors = DB::table('tbl_colors')->where('color','=',$color_name)->count();
		if($colors == 0)
		{
			$color = new Color;
			$color->color=$color_name;
			$color->save();
			echo $color->id;
		}
		else
		{
			return '01';
		}
	}

	//color delete
	public function colordelete(Request $request)
	{
		$id = $request->colorid;
		//$color = DB::table('tbl_colors')->where('id','=',$id)->delete();
		$color = DB::table('tbl_colors')->where('id','=',$id)->update(['soft_delete' => 1]);
	}
	
	//get chassis
	public function getchasis(Request $request)
	{	
		$modelname = $request->modelname;
		$vehicle_id = $request->vehicle_id;	
		$sales = DB::table('tbl_sales')->where('vehicle_id','!=',$vehicle_id)->get()->toArray();
		$count = DB::table('tbl_sales')->where('vehicle_id','!=',$vehicle_id)->count();	
		if($count > 0 )
		{		
			foreach ($sales as $sale)
			{
				$ve_id[] = $sale->vehicle_id;
				$csno[] = $sale->chassisno;				
			}
			$data = DB::table('tbl_vehicles')->whereNotIn('id',$ve_id)->where('modelname',$modelname)->get()->toArray();
		}
		else
		{
			$data = DB::table('tbl_vehicles')->where('modelname','=',$modelname)->get()->toArray();
		}
		?>
		<?php foreach ($data as $datas) { ?>
			<option value="<?php echo $datas->chassisno;?>" ><?php echo $datas->chassisno;?></option>
		<?php	} ?>		
		<?php
	}

	//get vehicle data
	public function getrecord(Request $request)
	{	
		$vid = $request->vehicale_id;
		$v_record = DB::table('tbl_vehicles')->where('id','=',$vid)->first();
		$record = json_encode($v_record);
		echo $record;
	}

	//get model name
	public function getmodel_name(Request $request)
	{
		$brand_name = $request->vehicale_id;	
		//$data = DB::table('tbl_products')->where('id','=',$brand_name)->first();
		//$purchase = DB::table('tbl_purchase_history_records')->where('product_id',$brand_name)->where('category',1)->get();

		$data = DB::table('tbl_products')->where([['id','=',$brand_name],['soft_delete','=',0]])->first();
		$purchase = DB::table('tbl_purchase_history_records')->where([['product_id',$brand_name],['soft_delete','=',0]])->where('category',1)->get();

		$s = [];
		$sp = [];
		foreach($purchase as $purchases)
		{
			$s[] = $purchases->qty;
		}
		$sums = array_sum($s);
		$purchase_p = DB::table('tbl_sale_parts')->where('product_id',$brand_name)->get();
		foreach($purchase_p as $purchasesd)
		{
			$sp[] = $purchasesd->quantity;
		}
		$sumsd = array_sum($sp);
		if($sums >= $sumsd || $sumsd == 0)
		{
			if($sumsd == 0)
			{
				$diff = $sums;
			}
			else
			{
				$diff = $sums - $sumsd;
			}
		}
		else
		{
			$diff ="not available";
		}
		return array('price'=>$data->price,'qty'=>$diff);
	}

	//get tax per
	public function gettaxespercentage(Request $request)
	{	
		$t_name = $request->t_name;
		if(!empty($t_name)){
		$t_record = DB::table('tbl_account_tax_rates')->where('taxname','=',$t_name)->first();
		$tax = $t_record->tax;
		echo $tax;
		}
		else{
			echo 0;
		}
	}

	// free services
	public function getservices(Request $request)
	{	
		$interval = $request->interval;
		$date_gape = $request->date_gape;
		$no_service = $request->no_service;		
		$characters = '0123456789';
		$code =  'C'.''.substr(str_shuffle($characters),0,6);	
		$new_interval=$interval;

		$new_interval_array=array();
		$no_service_arry=array();
		$get_service_data=date('Y-m-d');

		$addmonth=(int)$interval;
		$addday = (int)$date_gape;
		for($j=1;$j<=$no_service;$j++){
			
			$no_service_date = date('Y-m-d', strtotime("+".$addmonth." months", strtotime($get_service_data)));
			$no_service_date_gap = date('Y-m-d', strtotime("+".$addday." days", strtotime($no_service_date)));
			
			$get_service_data=$no_service_date;
			$codes = $code.$j;
			$no_service_arry[$get_service_data]=("$j Service");
		?>
			<table class="table" align="center" style="width:80%;">
			<tr class="data_of_type">
				<td class="text-center"><?php echo $j; ?></td>
				<td class="text-center"><input type="text" class="form-control first_width" value="<?php echo $no_service_date.'  To  '.$no_service_date_gap; ?>" name="service[service_date][]"></td>
				<td class="text-center"><input type="text" class="form-control second_width" name="service[service_text][]" value="<?php echo $no_service_arry[$get_service_data];?>" ></td>
				<td class="text-center"><input type="text" class="form-control second_width" name="service[service_job][]" value="<?php echo $codes;?>" readonly></td>
			</tr>
			</table>
		<?php
		}			
	}

	//get taxes
	public function gettaxes(Request $request)
	{
		$id = $request->row_id;
		$ids = $id+1;
		$rowid = 'row_id_'.$ids;
	
		$taxes = DB::table('tbl_account_tax_rates')->get()->toArray();		
		?>		
		<tr id="<?php echo $rowid;?>">
		<input type="hidden" value="<?php echo $ids;?>" name="account[tr_id][]"/>
		<td><select name="account[tax_name][]" url="<?php  echo url('sales/add/gettaxespercentage'); ?>" class="form-control tax_name" row_did="<?php echo $ids;?>" data-id="<?php echo $ids;?>" required="">
		<option value="0">Select Tax</option><?php  foreach($taxes as $tax) { ?><option value="<?php echo $tax->taxname;?>"><?php echo $tax->taxname;?></option> <?php } ?> </select>
		</td>
		<td>
			<input type="text" name="account[tax][]" class="form-control tax" value="" id="tax_<?php echo $ids;?>" readonly="true">
		</td>
		<td>
			<span class="trash_account" data-id="<?php echo $ids; ?>"><i class="fa fa-trash"></i> Delete</span>
		</td>
		</tr>
		<?php
	}

	//get qty
	public function getqty(Request $request)
	{	
		$qty = $request->qty;
		$price = $request->price;
		echo $qty;
		echo $price;
	}

	//sales store
	public function store(Request $request)
	{
		//dd($request->all());

		$this->validate($request, [  
         'qty' => 'numeric',
         // 'price' => 'numeric',
	    ]);

		if(getDateFormat()== 'm-d-Y')
		{
			$s_date=date('Y-m-d',strtotime(str_replace('-','/',$request->date)));
		}
		else
		{
			$s_date=date('Y-m-d',strtotime($request->date));
		}
		/* $sales = new tbl_sale_parts;
		$sales->customer_id = $request->cus_name;
		$sales->bill_no = $request->bill_no;
		$sales->date =$s_date;
		$sales->quantity = $request->qty;
		$sales->price = $request->price;
		$sales->total_price = $request->total_price;
		$sales->salesmanname = $request->salesmanname;
		$sales->product_id = $request->product_id;
		$sales->save(); */
		
		$products = $request->product;
		if(!empty($products)){
			foreach($products['product_id'] as $key => $value)
			{		
			    //$Manufacturer_id = $products['Manufacturer_id'][$key];
			    $Product_id = $products['product_id'][$key];
				$qty = $products['qty'][$key];
				$price = $products['price'][$key];
				$total_price = $products['total_price'][$key];
				$manufacturer_id = $products['Manufacturer_id'][$key];

				$sales = new SalePart;
				$sales->customer_id = $request->cus_name;
				$sales->bill_no = $request->bill_no;
				$sales->date =$s_date;
				$sales->quantity = $qty;
				$sales->price = $price;
				$sales->total_price = $total_price;
				$sales->salesmanname = $request->salesmanname;
				$sales->product_id = $Product_id;
				$sales->product_type_id = $manufacturer_id;


				//custom field save	
				$custom=$request->custom;
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
						$salesPartData = $val1;
					}	
					$sales->custom_field = $salesPartData;
				}
				$sales->save();
			}
		}
		return redirect('sales_part/list')->with('message','Successfully Submitted');
	}
	
	//modal view for sales
	public function view(Request $request)
	{
		
		if(!empty($request->saleid))
		{
			$id = $request->saleid;
			$invoice_number = $request->invoice_number;			
		}
		else
		{
			$id = $request->serviceid;
			$auto_id = $request->auto_id;
		}

		$viewid = $id;
		//$sales = DB::table('tbl_sale_parts')->where('id','=',$id)->first();
		$sales = SalePart::where('id','=',$id)->first();
		//$saless = DB::table('tbl_sale_parts')->where('bill_no','=',$sales->bill_no)->get();
		$saless = SalePart::where('bill_no','=',$sales->bill_no)->get();
		
		/*$salesp = DB::table('tbl_sale_parts')->select(DB::raw("SUM(total_price) AS total_price,bill_no,quantity,date,product_id,price ,customer_id,id,salesmanname"))->where('bill_no','=',$sales->bill_no)->get();*/
		$salesp = SalePart::select(DB::raw("SUM(total_price) AS total_price,bill_no,quantity,date,product_id,price ,customer_id,id,salesmanname"))->where('bill_no','=',$sales->bill_no)->get();

		/*$salesps = DB::table('tbl_sale_parts')->select(DB::raw("SUM(total_price) AS total_price,bill_no,quantity,date,product_id,price ,customer_id,id,salesmanname"))->where('bill_no','=',$sales->bill_no)->first();*/
		$salesps = SalePart::select(DB::raw("SUM(total_price) AS total_price,bill_no,quantity,date,product_id,price ,customer_id,id,salesmanname"))->where('bill_no','=',$sales->bill_no)->first();
		
		$v_id = $sales->product_id;
		//$vehicale =  DB::table('tbl_products')->where('id','=',$v_id)->first();
		$vehicale = Product::where('id','=',$v_id)->first();
		if($request->saleid)
		{
			/*$invioce = DB::table('tbl_invoices')->where([['sales_service_id',$id],['invoice_number',$invoice_number]])->first();*/
			$invioce = Invoice::where([['sales_service_id',$id],['invoice_number',$invoice_number]])->first();
		}
		else
		{
			//$invioce = DB::table('tbl_invoices')->where('id',$auto_id)->first();
			$invioce = Invoice::where('id',$auto_id)->first();
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

		//$logo = DB::table('tbl_settings')->first();
		$logo = Setting::first();
		
		//$updatekey = DB::table('updatekey')->first();
		$updatekey = Updatekey::first();
		$s_key = $updatekey->secret_key;
		$p_key = $updatekey->publish_key;

		//For Custom Field Data
		$tbl_custom_fields_salepart = DB::table('tbl_custom_fields')->where([['form_name','=','salepart'],['always_visable','=','yes']])->get()->toArray();

		//Custom Field Data of User Table (For Customer Module)
		$tbl_custom_fields_customers = DB::table('tbl_custom_fields')->where([['form_name','=','customer'],['always_visable','=','yes']])->get()->toArray();

		$html = view('invoice.sales_partinvoicemodel')->with(compact('viewid','vehicale','sales','logo','invioce','taxes','p_key','saless','salesp','salesps','tbl_custom_fields_salepart','tbl_custom_fields_customers'))->render();

		return response()->json(['success' => true, 'html' => $html]);
	}

	// sale part delete
	public function destroy($id)
	{	
		$salesp = DB::table('tbl_sale_parts')->find($id);
		//$sales = DB::table('tbl_sale_parts')->where('bill_no','=',$salesp->bill_no)->delete();
		$sales = DB::table('tbl_sale_parts')->where('bill_no','=',$salesp->bill_no)->update(['soft_delete' => 1]);

		return redirect('sales_part/list')->with('message','Successfully Deleted');		
	}
	
	// sale part delete
	public function sale_part_destroy(Request $request)
	{	
		$id = $request->procuctid;
		//$sales = DB::table('tbl_sale_parts')->where('id','=',$id)->delete();
		$sales = DB::table('tbl_sale_parts')->where('id','=',$id)->update(['soft_delete' => 1]);

		//return redirect('sales_part/list')->with('message','Successfully Deleted');		
	}

	//sales edit form
	public function edit($id)
	{
		$editid = $id;	
		$color = Color::where('soft_delete','=',0)->get();
		$employee = User::where([['role','=','Employee'],['soft_delete','=',0]])->get();
		$customer = User::where([['role','=','Customer'],['soft_delete','=',0]])->get();
		$vehicale = Vehicle::where('soft_delete','=',0)->get();
		$sales = SalePart::where('id','=',$id)->first();

		$payment = PaymentMethod::get();
		$sales_services = Service::where('sales_id','=',$id)->get();
		$brand = Product::where([['category',1],['soft_delete','=',0]])->get();
		$stock = SalePart::where('bill_no','=',$sales->bill_no)->get();

		$manufacture_name = DB::table('tbl_product_types')->where('soft_delete','=',0)->get()->toArray();

		//Custom Field Data
		$tbl_custom_fields = DB::table('tbl_custom_fields')->where([['form_name','=','salepart'],['always_visable','=','yes'],['soft_delete','=',0]])->get()->toArray();

		return view('sales_part.edit',compact('sales','editid','vehicale','customer','payment','color','employee','sales_services','brand','stock','tbl_custom_fields', 'manufacture_name'));
	}

	//sales update
	public function update(Request $request,$id)
	{ 
		//dd($request->all());

		/*$this->validate($request, [  
			'qty' => 'numeric',
			//'price' => 'numeric',
	    ]);*/
		
		if(getDateFormat()== 'm-d-Y')
		{
			$s_date=date('Y-m-d',strtotime(str_replace('-','/',$request->date)));
		}
		else
		{
			$s_date=date('Y-m-d',strtotime($request->date));
		}
		$products = $request->product;
		if(!empty($products)){
			foreach($products['product_id'] as $key => $value)
			{		
			    $Product_id = $products['product_id'][$key];
				$qty = $products['qty'][$key];
				$price = $products['price'][$key];
				$total_price = $products['total_price'][$key];
				$purchase_hiatory_id = $products['tr_id'][$key];
				$p_id = DB::table('tbl_sale_parts')->find($id);
				$manufacturer_id = $products['Manufacturer_id'][$key];

				if($purchase_hiatory_id != '')
				{
					if(!empty($p_id))
					{
						$sales = SalePart::find($id);
						$sales->customer_id = $request->cus_name;
						$sales->bill_no = $request->bill_no;
						$sales->date =$s_date;
						$sales->quantity = $qty;
						$sales->price = $price;
						$sales->total_price = $total_price;
						$sales->salesmanname = $request->salesmanname;
						$sales->product_id = $Product_id;
						$sales->product_type_id = $manufacturer_id;

						//Custom Field Data
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
								$salesPartData = $val1;
							}	
							$sales->custom_field = $salesPartData;
						}
						$sales->save();
					}
				}
				else
				{
					$sales = new SalePart;
					$sales->customer_id = $request->cus_name;
					$sales->bill_no = $request->bill_no;
					$sales->date =$s_date;
					$sales->quantity = $qty;
					$sales->price = $price;
					$sales->total_price = $total_price;
					$sales->salesmanname = $request->salesmanname;
					$sales->product_id = $Product_id;
					$sales->product_type_id = $manufacturer_id;

					//Custom Field Data
						$custom = $request->custom;
						$custom_fileld_value = array();	
						$custom_fileld_value_jason_array = array();
						if(!empty($custom))
						{		
							foreach($custom as $key=>$value)
							{
								$custom_fileld_value[] = array("id" => "$key", "value" => "$value");	
							}	
						   
							$custom_fileld_value_jason_array['custom_fileld_value'] = json_encode($custom_fileld_value); 

							foreach($custom_fileld_value_jason_array as $key1=>$val1)
							{
								$salesPartData = $val1;
							}	
							$sales->custom_field = $salesPartData;
						}
						
					$sales->save();
				}
			}
		}
		return redirect('sales_part/list')->with('message','Successfully Updated');
	}

	// get product name
	public function getproductname(Request $request)
	{
		$id = $request->row_id;	
		$ids = $id+1;	    
		$rowid = 'row_id_'.$ids;      
		//$product = DB::table('tbl_products')->where('category',1)->get()->toArray();
		$product = DB::table('tbl_products')->where([['category','=',1],['soft_delete','=',0]])->get()->toArray();

		//$manufacture_name = DB::table('tbl_product_types')->get()->toArray();
		$manufacture_name = DB::table('tbl_product_types')->where('soft_delete','=',0)->get()->toArray();

		$html = view('sales_part.newproduct')->with(compact('id','ids','rowid','product','manufacture_name'))->render();
		return response()->json(['success' => true, 'html' => $html]);
	}

	//productitem
	public function productitem(Request $request)
	{
		$id = $request->m_id;
		
		//$tbl_products = DB::table('tbl_products')->where('product_type_id','=',$id)->get()->toArray();
		$tbl_products = DB::table('tbl_products')->where([['product_type_id','=',$id],['soft_delete','=',0]])->get()->toArray();
		
		if(!empty($tbl_products))
		{   ?>
			<option value="">--Select Product--</option>
			<?php
			foreach($tbl_products as $tbl_productss)
			{ ?>
				<option value="<?php echo  $tbl_productss->id; ?>"><?php echo $tbl_productss->name; ?></option>
			<?php 
			} 
		}
		else
		{
			?>
			<option value="">--Select Product--</option>
			<?php
		}
	}

	// get total price for product
	public function getAvailableProduct(Request $request)
	{
		
		$productid = $request->productid;
		$cellstock = DB::table('tbl_service_pros')->where('product_id','=',$productid)->get()->toArray();
		$celltotal=0;
		foreach($cellstock as $cellstocks)
		{
			$cell_stock=$cellstocks->quantity;
			$celltotal += $cell_stock;		
		}

		$salepart_stocks = DB::table('tbl_sale_parts')->where('product_id','=',$productid)->get()->toArray();
		$salepart_total = 0;
		foreach($salepart_stocks as $salepart_stock)
		{
			$salepart_stock = $salepart_stock->quantity;
			$salepart_total += $salepart_stock;		
		}
		
		$stockdata=DB::table('tbl_stock_records')
						->join('tbl_products','tbl_stock_records.product_id','=','tbl_products.id')
						->join('tbl_purchase_history_records','tbl_products.id','=','tbl_purchase_history_records.product_id')
						->join('tbl_purchases','tbl_purchase_history_records.purchase_id','=','tbl_purchases.id')
						->where('tbl_products.id','=',$productid)
						->get()->toArray();
				
		$fullstock=0;
		if(!empty($stockdata))
		{
			foreach($stockdata as $stockdatas)
			{
				$fullstock += $stockdatas->qty;
			}
		}

		$total_salepart_service_stock = $celltotal + $salepart_total;
		$Currentstock = $fullstock - $total_salepart_service_stock;
			
		$qty = $request->qty;
		if($qty > $Currentstock)
		{
			//echo 1;
			return response()->json(['success' => 1, 'currentStock' => $Currentstock]);
		}
						
	}
}