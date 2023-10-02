<?php
namespace App\Http\Controllers;

use DB;
use Auth;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Gate;

use App\tbl_stock_records;
use App\Stock;
use App\Setting;
use App\Product;
use App\SalePart;

class Stockcontroller extends Controller
{	
	public function __construct()
    {
        $this->middleware('auth');
    }
	
	//stock list
    public function index()
	{
		  /*$stock=DB::table('tbl_products')
						->join('tbl_stock_records','tbl_products.id','=','tbl_stock_records.product_id')
						 ->orderBy('tbl_stock_records.id','DESC')->get()->toArray();*/

			$stock = Product::
						join('tbl_stock_records','tbl_products.id','=','tbl_stock_records.product_id')
						 ->orderBy('tbl_stock_records.id','DESC')->get();
			
		return view('stoke.list',compact('stock'));
	}
   
   //stock edit
   public function edit($id)
   {
	 $product = DB::table('tbl_products')->get()->toArray();
	 $stock = DB::table('tbl_stock_records')->where('id','=',$id)->first();
    return view('stoke.edit',compact('product','stock'));
   }
   
   //stock update
   public function update($id, Request $request)
   {
	   $stocks = DB::table('tbl_stock_records')->where('id','=',$id)->first();
	   $oldstock = $stocks->no_of_stoke;
	   $newstock = $request->qty;
	  
	   $stock = Stock::find($id);
	   $stock->product_id = $request->product;
	   $stock->no_of_stoke = $newstock;
	   $stock->save();
	   return redirect('stoke/list')->with('message','Successfully Updated');
   }
   
   //stock modal view
   public function stockview(Request $request)
   {
		//$stockid = Input::get('stockid');
   		$stockid = $request->stockid;
		
		//$logo = DB::table('tbl_settings')->first();
		$logo = Setting::first();
		
		/*$stockdata=DB::table('tbl_stock_records')
						->join('tbl_products','tbl_stock_records.product_id','=','tbl_products.id')
						->join('tbl_purchase_history_records','tbl_products.id','=','tbl_purchase_history_records.product_id')
						->join('tbl_purchases','tbl_purchase_history_records.purchase_id','=','tbl_purchases.id')
						->where('tbl_stock_records.id','=',$stockid)
						->orderBy('tbl_purchases.date','DESC')
						->get()->toArray();*/
		
		$stockdata = Stock::
						join('tbl_products','tbl_stock_records.product_id','=','tbl_products.id')
						->join('tbl_purchase_history_records','tbl_products.id','=','tbl_purchase_history_records.product_id')
						->join('tbl_purchases','tbl_purchase_history_records.purchase_id','=','tbl_purchases.id')
						->where('tbl_stock_records.id','=',$stockid)
						->orderBy('tbl_purchases.date','DESC')
						->get();

		//$currentstock = DB::table('tbl_stock_records')->where('id','=',$stockid)->first();
		$currentstock = Stock::where('id','=',$stockid)->first();

		$cell_stock = "";
		$p_id = $currentstock->product_id;

		//$product = DB::table('tbl_products')->find($p_id);
		$product = Product::find($p_id);
		if($product->category == 1)
		{
			//$cellstock=DB::table('tbl_sale_parts')->where('product_id','=',$p_id)->get()->toArray();
			$cellstock = SalePart::where('product_id','=',$p_id)->get();
			$celltotal = 0;			

			foreach($cellstock as $cellstocks)
			{
				$cell_stock = $cellstocks->quantity;
				$celltotal += $cell_stock;		
			}

			$product_service_stocks = DB::table('tbl_service_pros')->where('product_id','=',$p_id)->get()->toArray();
			$product_service_stocks_total = 0;

			foreach($product_service_stocks as $product_service_stock)
			{
				$service_stock = $product_service_stock->quantity;
				$product_service_stocks_total += $service_stock;		
			}

		}
		else
		{
			$cellstock=DB::table('tbl_service_pros')->where('product_id','=',$p_id)->get()->toArray();
			$celltotal=0;
			foreach($cellstock as $cellstocks)
			{
				$cell_stock=$cellstocks->quantity;
				$celltotal += $cell_stock;	
			}

			$product_service_stocks = DB::table('tbl_service_pros')->where('product_id','=',$p_id)->get()->toArray();
			$product_service_stocks_total = 0;

			foreach($product_service_stocks as $product_service_stock)
			{
				$service_stock = $product_service_stock->quantity;
				$product_service_stocks_total += $service_stock;		
			}
		}

		$sale_service_stock = $product_service_stocks_total + $celltotal;

		$html = view('stoke.stokemodel')->with(compact('stockid','stockdata','logo','currentstock','p_id','cellstock','cell_stock','celltotal', 'product_service_stocks_total', 'sale_service_stock'))->render();
		
		return response()->json(['success' => true, 'html' => $html]);   
   }
}