<?php

namespace App\Http\Controllers;

use DB;
use Auth;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\users;
use App\tbl_purchases;
use App\tbl_stock_records;
use App\tbl_purchase_history_records;

use App\Purchase;
use App\Stock;
use App\Setting;
use App\CustomField;
use App\Product;
use App\Http\Requests\PurchaseAddEditFormRequest;


class Purchasecontroller extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
	
	//purchase list
	public function listview()
	{	       
		//$purchase=DB::table('tbl_purchases')->orderBy('id','DESC')->get()->toArray();
		$purchase = Purchase::orderBy('id','DESC')->get();
		//$purchase = Purchase::where('soft_delete','=',0)->orderBy('id','DESC')->get();
				
		return view('purchase.list',compact('purchase')); 
	}
	//purchase list
	public function listview1($id)
	{	    
		//$purchase=DB::table('tbl_purchases')->where('id','=',$id)->get()->toArray();
		$purchase = Purchase::where('id','=',$id)->get();
		//$purchase = Purchase::where([['id','=',$id],['soft_delete','=',0]])->get();
				
		return view('purchase.list',compact('purchase')); 
	}

	//purchase addform
    public function index()
	{		
		//dd($prd_type_id_array, $Select_product);
		$characters = '0123456789';
		$code =  'P'.''.substr(str_shuffle($characters),0,6);

		//$supplier = DB::table('users')->where('role','=','supplier')->get()->toArray();
		$supplier = DB::table('users')->where([['role','=','supplier'],['soft_delete','=',0]])->get()->toArray();

		//$product = DB::table('tbl_products')->get()->toArray();
		$product = Product::where('soft_delete','=',0)->get();


		//$tbl_custom_fields = DB::table('tbl_custom_fields')->where([['form_name','=','purchase'],['always_visable','=','yes']])->get()->toArray();
		$tbl_custom_fields = DB::table('tbl_custom_fields')->where([['form_name','=','purchase'],['always_visable','=','yes'],['soft_delete','=',0]])->get()->toArray();
		
		//$first_product = DB::table('tbl_products')->first();		
		$first_product = DB::table('tbl_products')->where('soft_delete','=',0)->first();

		$prd_type_id_array = [];
		foreach ($product as $value) {
			$prd_type_id_array[] = $value->product_type_id;
		}

		//$Select_product = DB::table('tbl_product_types')->get()->toArray();
		//$Select_product = DB::table('tbl_product_types')->whereIn('id',$prd_type_id_array) ->get()->toArray();
		$Select_product = DB::table('tbl_product_types')->where('soft_delete','=',0)->whereIn('id',$prd_type_id_array) ->get()->toArray();
		
		return view('purchase.add',compact('supplier','product','code','Select_product','tbl_custom_fields', 'first_product'));
	}
	
	//get supplier record
	public function getrecord(Request $request)
	{
		//$s_id = Input::get('supplier_id');
		$s_id = $request->supplier_id;
		
		//$supplier_record=DB::table('users')->where([['id','=',$s_id],['role','=','supplier']])->first();
		$supplier_record = DB::table('users')->where([['id','=',$s_id],['role','=','supplier'],['soft_delete','=',0]])->first();

		$record = json_encode($supplier_record);
		
		echo $record;
	}
	
	//productitem (purchase product time)
	public function productitem(Request $request)
	{
		//$id = Input::get('m_id');
		$id = $request->m_id;

		//$tbl_products = DB::table('tbl_products')->where('product_type_id','=',$id)->get()->toArray();
		$tbl_products = DB::table('tbl_products')->where([['product_type_id','=',$id],['soft_delete','=',0]])->get()->toArray();

		if(!empty($tbl_products))
		{   ?>
			<!-- <option value="">--Select Product--</option> -->
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

	//productitems (add salespart time)
	public function productitems(Request $request)
	{
		//$id = Input::get('m_id');
		$id = $request->m_id;

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
	
	//product data
	public function getproduct(Request $request)
	{
		//$p_id = Input::get('p_id');
		$p_id = $request->p_id;

		if(!empty($p_id))
		{
		$t_record = DB::table('tbl_products')->where([['id','=',$p_id],['soft_delete','=',0]])->first();
			echo json_encode($t_record);
		}
		else
		{
			echo 0;
		}
	}
	
	//delete product
	public function deleteproduct(Request $request)
	{

		//$productid = Input::get('procuctid');
		$productid = $request->procuctid;
		
		$product1 = DB::table('tbl_purchase_history_records')->where('id','=',$productid)->first();	
		$pid = $product1->product_id;
		$qty = $product1->qty;
		$stock = DB::table('tbl_stock_records')->where('product_id','=',$pid)->first();
		$sid = $stock->no_of_stoke;
		$total = $sid - $qty;
		DB::update("update tbl_stock_records set no_of_stoke='$total' where product_id='$pid'");
		$product = DB::table('tbl_purchase_history_records')->where('id','=',$productid)->delete();	
	}
	
	//product total
	public function getqty(Request $request)
	{	
		//$qty = Input::get('qty');
		$qty = $request->qty;

		//$price = Input::get('price');
		$price = $request->price;

		$total_price = $qty * $price;  
		echo $total_price;
	}
	
	//product store
	public function store(PurchaseAddEditFormRequest $request)
	{
		//dd($request->all());
		$p_date = $request->p_date;
		$p_no = $request->p_no;
		$s_name = $request->s_name;
		$mobile = $request->mobile;
		$email = $request->email;
		$address = $request->address;

		if(getDateFormat()== 'm-d-Y')
		{
			$dates = date('Y-m-d',strtotime(str_replace('-','/', $p_date)));
		}
		else
		{
			$dates = date('Y-m-d',strtotime($p_date));
		}
		/*$purchase = new Purchase;
		$purchase->purchase_no = Input::get('p_no');
		$purchase->date = $dates;		
		$purchase->supplier_id = Input::get('s_name');
		$purchase->mobile = Input::get('mobile');
		$purchase->email = Input::get('email');
		$purchase->address = Input::get('address');*/

		$purchase = new Purchase;
		$purchase->purchase_no = $p_no;
		$purchase->date = $dates;		
		$purchase->supplier_id = $s_name;
		$purchase->mobile = $mobile;
		$purchase->email = $email;
		$purchase->address = $address;

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
				$purchaseData = $val1;
			}	
			$purchase->custom_field = $purchaseData;
		}

		$purchase->save();
		
		$lat_record = DB::table('tbl_purchases')->orderBy('id','desc')->first();
		$purchase_id = $lat_record->id;
		
	    //$products = Input::get('product');
	    //$products = Input::get('product');
	    $products = $request->product;
	    
		if(!empty($products)){
			foreach($products['product_id'] as $key => $value)
			{		
			    // $Manufacturer_id = $products['Manufacturer_id'][$key];
			    $Product_id = $products['product_id'][$key];
				$qty = $products['qty'][$key];
				$price = $products['price'][$key];
				$total_price = $products['total_price'][$key];
				$category = $products['category_id'][$key];
				
				$purchas=new tbl_purchase_history_records;
				// $purchas->purchase_id=$Manufacturer_id;
				$purchas->purchase_id = $purchase_id;
				$purchas->product_id = $Product_id;
				$purchas->qty = $qty;
				$purchas->price = $price;
				$purchas->category = $category;
				$purchas->total_amount = $total_price;
				$purchas->save();
				
				$stock = DB::table('tbl_stock_records')->where('product_id','=',$Product_id)->first();		
				if( !empty($stock))
				{			   
				   $old_stock = $stock->no_of_stoke;
				  
				  $qty = $products['qty'][$key] + $old_stock;
				  
				  DB::update("update tbl_stock_records set no_of_stoke='$qty' where product_id='$Product_id'");
				}
				else
				{	 
					$product = new Stock();				
					$product->product_id = $Product_id;				
					//$product->supplier_id = Input::get('s_name');
					$product->supplier_id = $request->s_name;
					$product->no_of_stoke = $qty;				
					$product->save();
				}
			}
		}			
		return redirect('purchase/list')->with('message','Successfully Submitted');
	}
    
	//product edit
	public function editview($id)
	{   
		$purchase = DB::table('tbl_purchases')->where('id','=',$id)->first();	   
		//$purchase = DB::table('tbl_purchases')->where([['id','=',$id],['soft_delete','=',0]])->first();
		//$supplier = DB::table('users')->where('role','=','supplier')->get()->toArray();
	    $supplier = DB::table('users')->where([['role','=','supplier'],['soft_delete','=',0]])->get()->toArray();

	    //$product = DB::table('tbl_products')->get()->toArray();	
		$product = Product::where('soft_delete','=',0)->get();

		$stock = DB::table('tbl_purchase_history_records')->where('purchase_id','=',$id)->get()->toArray();		

		$prd_type_id_array = [];
		foreach ($product as $value) {
			$prd_type_id_array[] = $value->product_type_id;
		}

		//$Select_product=DB::table('tbl_product_types')->get()->toArray();
		$Select_product = DB::table('tbl_product_types')->whereIn('id',$prd_type_id_array) ->get()->toArray();
		
		//Custom Field Data
		//$tbl_custom_fields=DB::table('tbl_custom_fields')->where([['form_name','=','purchase'],['always_visable','=','yes']])->get()->toArray();
		$tbl_custom_fields = DB::table('tbl_custom_fields')->where([['form_name','=','purchase'],['always_visable','=','yes'],['soft_delete','=',0]])->get()->toArray();

		return view('purchase.edit',compact('supplier','product','purchase','stock','Select_product','tbl_custom_fields'));

	}
	
	//product delete
	public function destory($id)
	{ 
		$stock = DB::table('tbl_purchase_history_records')->where('purchase_id','=',$id)->get()->toArray();
		foreach($stock as $stock)
		{
			$product_id = $stock->product_id;
			
	
			$getqty = DB::table('tbl_purchase_history_records')->where([['product_id','=',$product_id],['purchase_id','=',$id]])->first();
			$total = $getqty->qty;
			
			$stock1 = DB::table('tbl_stock_records')->where('product_id','=',$product_id)->first();
			
				if( !empty($stock1))
				{			   
				   $old_stock = $stock1->no_of_stoke;
				 
				  $qty = $old_stock - $total;
				  
				  DB::update("update tbl_stock_records set no_of_stoke='$qty' where product_id='$product_id'");
				}

		}
			
		$purchase=DB::table('tbl_purchases')->where('id','=',$id)->delete();
		//DB::table('tbl_purchases')->where('id','=',$id)->update(['soft_delete' => 1]);

		$purchase=DB::table('tbl_purchase_history_records')->where('purchase_id','=',$id)->delete();
		//DB::table('tbl_purchase_history_records')->where('purchase_id','=',$id)->update(['soft_delete' => 1]);
				
		return redirect('purchase/list')->with('message','Successfully Deleted');
	}
	
	//product update
	public function update($id, PurchaseAddEditFormRequest $request)
	{   
		//dd($request->all());
		$p_date = $request->p_date;
		$p_no = $request->p_no;
		$s_name = $request->s_name;
		$mobile = $request->mobile;
		$email = $request->email;
		$address = $request->address;

	    if(getDateFormat() == 'm-d-Y')
		{
			$dates = date('Y-m-d',strtotime(str_replace('-','/',$p_date)));
		}
		else
		{
			$dates = date('Y-m-d',strtotime($p_date));
		}

		/*$purchase = Purchase::find($id);
		$purchase->purchase_no = Input::get('p_no');
		$purchase->date = $dates;
		$purchase->supplier_id = Input::get('s_name');
		$purchase->mobile = Input::get('mobile');
		$purchase->email = Input::get('email');
		$purchase->address = Input::get('address');*/

		$purchase = Purchase::find($id);
		$purchase->purchase_no = $p_no;
		$purchase->date = $dates;
		$purchase->supplier_id = $s_name;
		$purchase->mobile = $mobile;
		$purchase->email = $email;
		$purchase->address = $address;

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
				$purchaseData = $val1;
			}	
			$purchase->custom_field = $purchaseData;
		}
		
		$purchase->save();		
	    
	    $products = $request->product;
	   
	   	$stock_no = DB::table('tbl_purchase_history_records')->where('purchase_id','=',$id)->get()->toArray();
				
		if(!empty($stock_no))
		{					
			foreach($stock_no as $stock_nos)
			{				
				$productids = $stock_nos->product_id;
				
				if(!empty($productids))
				{
					$stocknos = DB::table('tbl_purchase_history_records')->where([['purchase_id','=',$id],['product_id','=',$productids]])->first();
					
					$pr_id = $stocknos->product_id;
					$qtyold = $stocknos->qty;
					$stock = DB::table('tbl_stock_records')->where('product_id','=',$pr_id)->first();
			
					$stock_id = $stock->id;
					$qtyolds = $stock->no_of_stoke;						
					$newqty = $qtyolds - $qtyold;				
					$stcoksnew = Stock::find($stock_id);
					$stcoksnew->product_id = $productids;
					$stcoksnew->no_of_stoke = $newqty;
					$stcoksnew->save();
				}
			}				
		}
	
		if(!empty($products))
		{
			foreach($products['product_id'] as $key => $value)
			{				    
				$purchase_hiatory_id = $products['tr_id'][$key];				
				$Product_id = $products['product_id'][$key];				
				$qty = $products['qty'][$key];
				$price = $products['price'][$key];
				$total_price = $products['total_price'][$key];
				$category = $products['category_id'][$key];				
				
				$stockno = DB::table('tbl_purchase_history_records')->where('purchase_id','=',$id)->get()->toArray();
													
				if($purchase_hiatory_id != '')
				{	
					  $history = tbl_purchase_history_records::find($purchase_hiatory_id);
					  $history->product_id = $Product_id;
					  $history->qty = $qty;
					  $history->price = $price; 
					  $history->total_amount = $total_price;
					  $history->category = $category;
					  $history->save();
				}
				else
				{
					$history = new tbl_purchase_history_records;
					$history->product_id = $Product_id;
					$history->purchase_id = $id;
					$history->qty = $qty;
					$history->price = $price; 
					$history->total_amount = $total_price;
					$history->category = $category;
					$history->save();
				}

				
	            $stocks = DB::table('tbl_purchase_history_records')->where('product_id','=',$Product_id)->get()->toArray();
				
			    $qtytotal = 0;
				foreach($stocks as $stockss)
				{
					$pur_stock = $stockss->qty;
					$qtytotal += $pur_stock;							
				}
					
				$stock = DB::table('tbl_stock_records')->where('product_id','=',$Product_id)->first();
				//$pid = $stock->product_id;
				if(!empty($stock))
				{
					$sid = $stock->id;
					$stockes = Stock::find($sid);
					$stockes->product_id = $Product_id;
					$stockes->supplier_id = $request->s_name;
					$stockes->no_of_stoke = $qtytotal;
					$stockes->save();
				}
				else
				{
					$stocks = new Stock;
					$stocks->product_id = $Product_id;
			   		$stocks->supplier_id = $request->s_name;
			   		$stocks->no_of_stoke = $qty;
			   		$stocks->save();
				}
			}
		}

		return redirect('purchase/list')->with('message','Successfully Updated');
	}
	
	//modal view for product
	public function purchaseview(Request $request)
	{	
		//$purchaseid = Input::get('purchaseid');
		$purchaseid = $request->purchaseid;

		//$logo = DB::table('tbl_settings')->first();
		$logo = Setting::first();
		//$purchas=DB::table('tbl_purchases')->where('id','=',$purchaseid)->first();
		$purchas = Purchase::where('id','=',$purchaseid)->first();
		$purchasdetails = DB::table('tbl_purchase_history_records')->where('purchase_id','=',$purchaseid)->get()->toArray();	

		//Custom Field Data
		/*$tbl_custom_fields = DB::table('tbl_custom_fields')->where([['form_name','=','purchase'],['always_visable','=','yes']])->get()->toArray();*/
		$tbl_custom_fields = CustomField::where([['form_name','=','purchase'],['always_visable','=','yes']])->get();

        $html = view('purchase.modal')->with(compact('purchasdetails','purchas','logo','purchaseid','tbl_custom_fields'))->render();

		return response()->json(['success' => true, 'html' => $html]);
		
		
	}
	
	// get product name
	public function getproductname(Request $request)
	{
		//$id = Input::get('row_id');
		$id = $request->row_id;

		$ids = $id+1;	    
		$rowid = 'row_id_'.$ids;

		//$product = DB::table('tbl_products')->get()->toArray();
		$product = Product::where('soft_delete','=',0)->get();

		//$Select_product=DB::table('tbl_product_types')->get()->toArray();
		$Select_product = DB::table('tbl_product_types')->where('soft_delete','=',0)->get()->toArray();

		//$first_product = DB::table('tbl_products')->first();
		$first_product = DB::table('tbl_products')->where('soft_delete','=',0)->first();

		$prd_type_id_array = [];
		foreach ($product as $value) {
			$prd_type_id_array[] = $value->product_type_id;
		}

		$Select_product = DB::table('tbl_product_types')->whereIn('id',$prd_type_id_array) ->get()->toArray();

		$html = view('purchase.newproduct')->with(compact('id','ids','rowid','product','Select_product', 'first_product'))->render();
		return response()->json(['success' => true, 'html' => $html]);
	}
	
	// get category Item
	public function Categoryitem(Request $request)
	{
		//$id = Input::get('m_id');
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


	public function getFirstProductData(Request $request)
	{
		//$productTypeId = Input::get('productTypeId');
		$productTypeId = $request->productTypeId;

		if (!empty($productTypeId))
		{
			//$first_product = DB::table('tbl_products')->where('product_type_id','=',$productTypeId)->orderBy('id','ASC')->first();
			$first_product = DB::table('tbl_products')->where([['product_type_id','=',$productTypeId],['soft_delete','=',0]])->orderBy('id','ASC')->first();

			if (!empty($first_product)) {
				$prices = $first_product->price;
				$productNumber = $first_product->product_no;

				return response()->json(['success' => 'yes', 'data' => $prices, 'product_number' => $productNumber]);
			}
			/*else{
				$first_product_data = DB::table('tbl_products')->orderBy('id','ASC')->first();
				$product_type_id = $first_product_data->product_type_id;
				$prices = $first_product_data->price;
				$productNumber = $first_product_data->product_no;

				return response()->json(['success' => $product_type_id, 'data' => $prices, 'product_number' => $productNumber]);
			}*/					
		}
	}
	
}	
