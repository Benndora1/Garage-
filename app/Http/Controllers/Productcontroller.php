<?php

namespace App\Http\Controllers;

use DB;
use Auth;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Gate;

use App\User;
use App\tbl_colors;
use App\tbl_products;
use App\tbl_product_units;
use App\tbl_product_types;
use App\Product;
use App\Color;
use App\CustomField;
use App\Http\Requests\ProductAddEditFormRequest;

class Productcontroller extends Controller
{	
	public function __construct()
    {
        $this->middleware('auth');
    }
	
	//product list
    public function index()
	{
		//$product = Product::orderBy('id','DESC')->get();
		$product = Product::where('soft_delete','=',0)->orderBy('id','DESC')->get();
		
		$tbl_custom_fields = CustomField::where([['form_name','=','product'],['always_visable','=','yes']])->get();

		return view('product.list',compact('product','tbl_custom_fields')); 
	}

	//product list
    public function indexid($id)
	{	
		$product = Product::where([['id','=',$id],['soft_delete','=',0]])->get();

		return view('product.list',compact('product'));
	}
	
	//product add form
	public function addproduct()
	{
		$characters = '0123456789';
		$code =  'PR'.''.substr(str_shuffle($characters),0,6);

		$color = Color::where('soft_delete','=',0)->get();

		$product = DB::table('tbl_product_types')->where('soft_delete','=',0)->get()->toArray();
		$supplier = User::where([['role','=','Supplier'],['soft_delete','=',0]])->get();
		$unitproduct = DB::table('tbl_product_units')->get()->toArray();

		$tbl_custom_fields = CustomField::where([['form_name','=','product'],['always_visable','=','yes'],['soft_delete','=',0]])->get();

		return view('product.add',compact('supplier','product','color','code','unitproduct','tbl_custom_fields'));
	}
	
	//product type
	public function addproducttype(Request $request)
	{		
		//$product = Input::get('product_type');
		$product = $request->product_type;
		$product_get = DB::table('tbl_product_types')->where('type','=',$product)->count();
		
		if($product_get == 0)
		{
			$product_type = new tbl_product_types;
			$product_type->type = $product;
			$product_type->save();
			 return $product_type->id;
		}else
		{
			$productName = DB::table('tbl_product_types')->where('soft_delete','=',1)->first();

			$typeName = $productName->type;

			if (!empty($typeName)) 
			{
				if ($typeName == $product) {
					DB::table('tbl_product_types')->where('id','=',$productName->id)->update(['soft_delete' => 0]);
					return $productName->id;
				}
				else{
					return '01';
				}				
			}

			return '01';
		}		        
	}
	
	//add color
	public function coloradd(Request $request)
	{   
		//$color_name = Input::get('c_name');
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

		$color = DB::table('tbl_colors')->where('id','=',$id)->update(['soft_delete' => 1]);
	}
	
	//add unit
	public function unitadd(Request $request)
	{		
		$unitname = $request->unit_measurement;

		$uintcount = DB::table('tbl_product_units')->where('name','=',$unitname)->count();
		if($uintcount == 0)
		{
		$product_unit = new tbl_product_units;
		$product_unit->name = $unitname;
		$product_unit->save();
		  echo $product_unit->id;
		}
		else
		{
			return '01';
		}	
	}
	
	//unit delete
	public function unitdelete(Request $request)
	{
		$unitid = $request->unitid;
		
		$productunit = DB::table('tbl_product_units')->where('id','=',$unitid)->delete();
	}
	
	// product store
	public function store(ProductAddEditFormRequest $request)
	{
		//dd($request->all());
		/*$this->validate($request, [ 
			'price'=>'required|numeric',
			'category'=>'required',
		  ]);*/
		 
		$p_date = $request->p_date;
		$p_no = $request->p_no;
		$name = $request->name;
		$p_type = $request->p_type;
		$color = $request->color;
		$price = $request->price;
		$sup_id = $request->sup_id;
		$warranty = $request->warranty;
		$category = $request->category;
		$unit = $request->unit;
		$category = $request->category;

		if(getDateFormat() == 'm-d-Y')
		{
			$dates = date('Y-m-d',strtotime(str_replace('-','/',$p_date)));
		}
		else
		{
			$dates = date('Y-m-d',strtotime($p_date));	
		}

		$product = new Product;
		$product->product_no = $p_no;
		$product->product_date = $dates;
		if(!empty($request->image))
		{
			$file = $request->image;
			$filename = $file->getClientOriginalName();
			$file->move(public_path().'/product/', $file->getClientOriginalName());
			$product->product_image = $filename ;
		}
		else
		{
			$product->product_image='avtar.png';
		}

		/*$product->name = Input::get('name');
		$product->product_type_id = Input::get('p_type');
		$product->color_id = Input::get('color');
		$product->price = Input::get('price');
		$product->supplier_id = Input::get('sup_id');
		$product->warranty = Input::get('warranty');
		$product->category = Input::get('category');
		$product->unit = Input::get('unit');*/

		$product->name = $name;
		$product->product_type_id = $p_type;
		$product->color_id = $color;
		$product->price = $price;
		$product->supplier_id = $sup_id;
		$product->warranty = $warranty;
		$product->category = $category;
		$product->unit = $unit;

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
				$productData = $val1;
			}	
			$product->custom_field = $productData;
		}

		/*if(!empty($custom))
		{
			foreach($custom as $key=>$value)
			{
			$custom_fileld_value[] = array("id" => "$key", "value" => "$value");	
			}	
		   
			$custom_fileld_value_jason_array['custom_fileld_value'] = json_encode($custom_fileld_value); 

			foreach($custom_fileld_value_jason_array as $key1=>$val1)
			{
				$productData = $val1;
			}	
			$product->custom_field = $productData;
		}*/

		$product->save();
		
		return redirect('/product/list')->with('message','Successfully Submitted');
	}
	
	//product delete
	public function destroy($id)
	{	
		//$product = DB::table('tbl_products')->where('id','=',$id)->delete();
		$product = Product::where('id','=',$id)->update(['soft_delete' => 1]);

		return redirect('/product/list')->with('message','Successfully Deleted');
	}
	
	//product edit
	public function edit($id)
	{	
		$editid = $id;
		/*$color = DB::table('tbl_colors')->get()->toArray();*/
		//$color = Color::get();
		$color = Color::where('soft_delete','=',0)->get();
		//$product_type = DB::table('tbl_product_types')->get()->toArray();
		$product_type = DB::table('tbl_product_types')->where('soft_delete','=',0)->get()->toArray();
		//$supplier = User::where('role','=','Supplier')->get();
		$supplier = User::where('role','=','Supplier')->where('soft_delete','=',0)->get();
		//$product = Product::where('id','=',$id)->first();
		$product = Product::where('id','=',$id)->first();
		$unitproduct = DB::table('tbl_product_units')->get()->toArray();

		//Custom Field Data
		/*$tbl_custom_fields=DB::table('tbl_custom_fields')->where([['form_name','=','product'],['always_visable','=','yes']])->get()->toArray();*/
		//$tbl_custom_fields = CustomField::where([['form_name','=','product'],['always_visable','=','yes']])->get();
		$tbl_custom_fields = CustomField::where([['form_name','=','product'],['always_visable','=','yes'],['soft_delete','=',0]])->get();

		return view('product.edit',compact('editid','color','product_type','supplier','product','unitproduct','tbl_custom_fields'));
	}
	
	//product update
	public function update(Request $request ,$id)
	{
		$this->validate($request, [ 
			'price'=>'required|numeric',
			'category'=>'required',
		]);

		

		$p_date = $request->p_date;
		$p_no = $request->p_no;
		$name = $request->name;
		$p_type = $request->p_type;
		$color = $request->color;
		$price = $request->price;
		$sup_id = $request->sup_id;
		$warranty = $request->warranty;
		$category = $request->category;
		$unit = $request->unit;
		$category = $request->category;

		if(getDateFormat() == 'm-d-Y')
		{
			$dates = date('Y-m-d',strtotime(str_replace('-','/',$p_date)));
		}
		else
		{
			$dates = date('Y-m-d',strtotime($p_date));	
		}

		$product = Product::find($id);
		$product->product_no = $p_no;
		$product->product_date = $dates;
		
		
		if(!empty($request->image))
			{
				$file = $request->image;
				$filename = $file->getClientOriginalName();
				$file->move(public_path().'/product/', $file->getClientOriginalName());
				$product->product_image = $filename;
			}
		
			
		$product->name = $name;
		$product->product_type_id = $p_type;
		$product->color_id = $color;
		$product->price = $price;
		$product->supplier_id = $sup_id;
		$product->warranty = $warranty;
		$product->category = $category;
		$product->unit = $unit;

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
				$productData = $val1;
			}	
			$product->custom_field = $productData;
		}

		/*if(!empty($custom))
		{
			foreach($custom as $key=>$value)
			{
			$custom_fileld_value[] = array("id" => "$key", "value" => "$value");	
			}	
		   
			$custom_fileld_value_jason_array['custom_fileld_value'] = json_encode($custom_fileld_value); 

			foreach($custom_fileld_value_jason_array as $key1=>$val1)
			{
			$productData = $val1;
			}	
			$product->custom_field = $productData;
		}*/
		
		$product->save();
		
		return redirect('/product/list')->with('message','Successfully Updated');
	}
	
	//product delete
	public function deleteproducttype(Request $request)
	{
		//$id = Input::get('ptypeid');
		$id = $request->ptypeid;

		//$p_type = DB::table('tbl_product_types')->where('id','=',$id)->delete();
		//$p_type = DB::table('tbl_products')->where('product_type_id','=',$id)->delete();

		DB::table('tbl_product_types')->where('id','=',$id)->update(['soft_delete' => 1]);
		Product::where('product_type_id','=',$id)->update(['soft_delete' => 1]);
			
	}


	/*For get companyname of supplier by auto searchable select box*/
   	/*public function get_supplier_company_name(Request $request)
   	{
   		$company_name = [];

        if($request->has('q'))
        {
            $search = $request->q;
            $company_name = User::select("id", "company_name")
            		->where('role', '=', 'Supplier')
            		->where('company_name', 'LIKE', "%$search%")
            		->get();
        }

        return response()->json($company_name);
   	}*/
}	
