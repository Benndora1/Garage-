<?php

namespace App\Http\Controllers;

use DB;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\tbl_account_tax_rates;
use App\AccountTaxRate;
use App\Http\Requests\StoreAccountTaxRatesRequest;

class AccounttaxControler extends Controller
{
	public function __construct()
    {
		$this->middleware('auth');
    }

	//taxrates addform
	public function index()
	{
		return view('taxrates.add');    
	}

	//taxrates store
	public function store(StoreAccountTaxRatesRequest $request)
	{
		// $this->validate($request, [
		// 	'tax'=>'numeric',
		// ]);
		$taxrate = $request->taxrate;
		$tax = $request->tax;
		//$count = DB::table('tbl_account_tax_rates')->where('taxname','=',$taxrate)->count();
		$count = AccountTaxRate::where('taxname','=',$taxrate)->count();
		if($count == 0)
		{
			$account = new AccountTaxRate;
			$account->taxname = $taxrate;
			$account->tax = $tax;
			$account->save();
			return redirect('/taxrates/list')->with('message','Successfully Submitted');
		}
		else
		{
			return redirect('/taxrates/add')->with('message','Duplicate Data');
		}
	}

	//taxrates list
	public function taxlist()
	{
		//$account1 = DB::table('tbl_account_tax_rates')->orderBy('id','DESC')->get()->toArray();
		//$account = AccountTaxRate::orderBy('id','DESC')->get();
		$account = AccountTaxRate::where('soft_delete','=',0)->orderBy('id','DESC')->get();

		return view('/taxrates/list',compact('account'));
	}

	//taxrates delete
	public function destory($id)
	{
		//$account = DB::table('tbl_account_tax_rates')->where('id','=',$id)->delete();
		//$account = AccountTaxRate::where('id','=',$id)->delete();
		$account = AccountTaxRate::where('id','=',$id)->update(['soft_delete' => 1]);
		
		return redirect('/taxrates/list')->with('message','Successfully Deleted');
	}

	//taxrates edit
	public function accountedit($id)
	{
		$editid = $id;
		//$account = DB::table('tbl_account_tax_rates')->where('id','=',$id)->first();
		$account = AccountTaxRate::where('id','=',$id)->first();

		return view('/taxrates/edit',compact('account','editid'));
	}

	//taxrates update
	public function updateaccount(StoreAccountTaxRatesRequest $request,$id)
	{
		// $this->validate($request, [
		// 	'tax' => 'numeric',
		// ]);
		$taxrate = $request->taxrate;
		$tax = $request->tax;
		//$count = DB::table('tbl_account_tax_rates')->where([['taxname','=',$taxrate],['id','!=',$id]])->count();
		$count = AccountTaxRate::where([['taxname','=',$taxrate],['id','!=',$id]])->count();
		if($count == 0)
		{
			$account = AccountTaxRate::find($id);
			$account->taxname = $taxrate;
			$account->tax = $tax;
			$account->save();
			return redirect('/taxrates/list')->with('message','Successfully Updated');
		}
		else
		{
			return redirect('/taxrates/list/edit/'.$id)->with('message','Duplicate Data');
		}
	}
}