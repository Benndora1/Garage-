<?php

namespace App\Http\Controllers;

use DB;
use Auth;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use App\User;
use App\tbl_expenses;
use App\tbl_expenses_history_records;

use App\ExpenseHistoryRecord;
use App\Expense;
use App\CustomField;
use App\Http\Requests\StoreExpenseAddEditFormRequest;

class ExpenseController extends Controller
{
   
	 public function __construct()
    {
        $this->middleware('auth');
    }
	
	// expense addform
    public function index()
    {
    	$tbl_custom_fields = DB::table('tbl_custom_fields')->where([['form_name','=','expense'],['always_visable','=','yes']])->get()->toArray();

		return view('expense.add', compact('tbl_custom_fields'));
    }
	
	// expense store
	public function store(Request $request)
    {	
		if(getDateFormat() == 'm-d-Y')
	    {
			$dates = date('Y-m-d',strtotime(str_replace('-','/',$request->date)));
		}
		else
		{
			$dates = date('Y-m-d',strtotime($request->date));
		}
		$tbl_expenses = new Expense;
		$tbl_expenses->main_label = $request->main_label;
		$tbl_expenses->status = $request->status;
		$tbl_expenses->date =$dates;

		//custom field	
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
				$expenseData = $val1;
			}	
			$tbl_expenses->custom_field = $expenseData;
		}

		$tbl_expenses->save();
		
		$expense_entry = $request->expense_entry;
		$expense_label = $request->expense_label;
		
		foreach($expense_entry as $key => $value)
		{
			$expense_entr = $expense_entry[$key];
			
			$expense_lbls = $expense_label[$key];
			
			$tbl_expense_id = DB::table('tbl_expenses')->orderBy('id','DESC')->first();
			
			$tbl_expenses_history_records = new ExpenseHistoryRecord;
			$tbl_expenses_history_records->tbl_expenses_id = $tbl_expense_id->id;
			$tbl_expenses_history_records->expense_amount = $expense_entr;
			$tbl_expenses_history_records->label_expense = $expense_lbls;
			$tbl_expenses_history_records->save();
		}
		return redirect('expense/list')->with('message','Successfully Submitted');		
	}

	// expense list
    public function showall()
    {
		/*$expense = DB::table('tbl_expenses')
						->join('tbl_expenses_history_records', 'tbl_expenses.id', '=', 'tbl_expenses_history_records.tbl_expenses_id')
						->groupBy('tbl_expenses_history_records.tbl_expenses_id')
						->orderBy('tbl_expenses.id','DESC')
						->get()->toArray();*/

		$expense = Expense::join('tbl_expenses_history_records', 'tbl_expenses.id', '=', 'tbl_expenses_history_records.tbl_expenses_id')
						->groupBy('tbl_expenses_history_records.tbl_expenses_id')
						->orderBy('tbl_expenses.id','DESC')
						->get();

		//Custom Field Data
		$tbl_custom_fields = CustomField::where([['form_name','=','expense'],['always_visable','=','yes']])->get();
		
        return view('expense.list',compact('expense','tbl_custom_fields'));
    }
	
	// expense edit
    public function edit($id)
    {	
        //$first_data = DB::table("tbl_expenses")->where('id', $id )->first();
        $first_data = Expense::where('id', $id)->first();

        //$sec_data = DB::table("tbl_expenses_history_records")->where('tbl_expenses_id', $id )->get()->toArray();
        $sec_data = ExpenseHistoryRecord::where('tbl_expenses_id', $id )->get();

        //Custom Field Data
		$tbl_custom_fields = CustomField::where([['form_name','=','expense'],['always_visable','=','yes']])->get();
		
        return view("expense/edit",compact('first_data','sec_data','tbl_custom_fields'));
    }

	// expense update
    public function update(Request $request, $id)
    {
		if(getDateFormat()== 'm-d-Y')
	    {
			$dates=date('Y-m-d',strtotime(str_replace('-','/',$request->date)));
		}
		else
		{
			$dates=date('Y-m-d',strtotime($request->date));
		}
		$tbl_expenses = Expense::find($id);	
		$tbl_expenses->main_label = $request->main_label;
		$tbl_expenses->status = $request->status;
		$tbl_expenses->date = $dates;

		//custom field	
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
				$expenseData = $val1;
			}	
			$tbl_expenses->custom_field = $expenseData;
		}

		$tbl_expenses->save();
			
		$expense_entry = $request->expense_entry;
		$expense_label = $request->expense_label;
		$id = $request->autoid;
		DB::table('tbl_expenses_history_records')->where('tbl_expenses_id',$request->id)->delete();
		foreach($expense_entry as $key => $value)
		{
			$expense_entr = $expense_entry[$key];
			$expense_lbls = $expense_label[$key];
			
			DB::insert("insert into tbl_expenses_history_records set tbl_expenses_id = $request->id, expense_amount = $expense_entr, label_expense = '$expense_lbls' ");
			
		}
		return redirect('expense/list')->with('message','Successfully Updated');
    }

	// expense delete
    public function destroy($id)
    {
		//DB::table('tbl_expenses')->where('id', $id)->delete();
		Expense::where('id', $id)->delete();
		
		//DB::table('tbl_expenses_history_records')->where('tbl_expenses_id', '=', $id)->delete(); 
		ExpenseHistoryRecord::where('tbl_expenses_id', '=', $id)->delete(); 
        
        return redirect("expense/list")->with('message','Successfully Deleted');
    }

	// monthly expense form
	public function monthly_expense()
    {
        return view("expense/month_expense");
    }
	
	// monthly expense
	public function get_month_expense(Request $request)
    {	
		  $this->validate($request,[  
			// 'start_date'  => 'required|date',
			// 'end_date'  => 'date|after:start_date',
	      ]);
		
		 if(getDateFormat()== 'm-d-Y')
		{
			$start_date=date('Y-m-d',strtotime(str_replace('-','/',$request->start_date)));
			$end_date=date('Y-m-d',strtotime(str_replace('-','/',$request->end_date)));
		}
		else
		{
			$start_date=date('Y-m-d',strtotime($request->start_date));
			$end_date=date('Y-m-d',strtotime($request->end_date));
		}
		/*$month_expense = DB::table('tbl_expenses')
							->join('tbl_expenses_history_records','tbl_expenses.id','=','tbl_expenses_history_records.tbl_expenses_id')
							->whereBetween('date',[$start_date,$end_date])
							->select('tbl_expenses.*', 'tbl_expenses_history_records.*')
							->orderBy('tbl_expenses_history_records.id','DESC')
							->get()->toArray();*/

		$month_expense = Expense::join('tbl_expenses_history_records','tbl_expenses.id','=','tbl_expenses_history_records.tbl_expenses_id')
							->whereBetween('date',[$start_date,$end_date])
							->select('tbl_expenses.*', 'tbl_expenses_history_records.*')
							->orderBy('tbl_expenses_history_records.id','DESC')
							->get();

		if(empty($month_expense))
		{
			Session::flash('message', 'Data Not Found !'); 
		}
		return view('expense.expense_report',compact('month_expense','start_date','end_date'));
    }	
}
