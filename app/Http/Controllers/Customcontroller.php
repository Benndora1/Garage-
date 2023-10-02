<?php

namespace App\Http\Controllers;

use DB;
use Auth;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

use App\tbl_custom_fields;

use App\User;
use App\CustomField;
use App\Http\Requests\StoreCustomFieldAddEditFormRequest;

class Customcontroller extends Controller
{
	
	public function __construct()
    {
        $this->middleware('auth');
    }
	
	//customfields list
	public function index()
	{	

		$tbl_custom_fields = CustomField::where('soft_delete','=',0)->orderBy('id','DESC')->get();

		return view('Customfields.list',compact('tbl_custom_fields')); 
	}
	
    //customfields addform
	public function add()
	{	
		return view('Customfields.addcustom'); 
	}
	 
	//customfields store
	public function store(Request $request)
	{
		//dd($request->all());
		$colomfield = $request->colomfield;
		$lable = $request->labelname;
			
		$radio_labels = $request->r_label;	
		$radio_label_json_data = null;
		if ($request->typename == "radio") {
			if($radio_labels != "")
			{
				$radio_label_json_data = json_encode($radio_labels);
			}
		}

		$checkbox_labels = $request->c_label;	
		$checkbox_label_json_data = null;
		if ($request->typename == "checkbox") {
			if($checkbox_labels != "")
			{
				$checkbox_label_json_data = json_encode($checkbox_labels);
			}
		}		
		
		//print_r($radio_label_json_data);
		//print_r($checkbox_label_json_data);
		//dd($radio_label_json_data, $checkbox_label_json_data, $request->all());

		$tbl_custom_fields = new CustomField;
		$tbl_custom_fields->form_name = $request->formname;
		$tbl_custom_fields->label = $lable;
		$tbl_custom_fields->type = $request->typename;
		$tbl_custom_fields->required = $request->required;
		$tbl_custom_fields->always_visable = $request->visable;
		$tbl_custom_fields->radio_labels = $radio_label_json_data;
		$tbl_custom_fields->checkbox_labels = $checkbox_label_json_data;

		$tbl_custom_fields->save();
		
		return redirect('/setting/custom/list')->with('message','Successfully Submitted');
	}
	
	//customfields delete
	public function delete($id)
	{
		//$tbl_custom_fields=DB::table('tbl_custom_fields')->where('id','=',$id)->delete();
		$tbl_custom_fields = DB::table('tbl_custom_fields')->where('id','=',$id)->update(['soft_delete' => 1]);

		return redirect('/setting/custom/list')->with('message','Successfully Deleted');
	}
	
	//customfields edit
	public function edit($id)
	{
		//$tbl_custom_fields=DB::table('tbl_custom_fields')->where('id','=',$id)->first();
		//$tbl_custom_fields = CustomField::where('id','=',$id)->first();
		$tbl_custom_fields = CustomField::where([['id','=',$id],['soft_delete','=',0]])->first();

		$radio_labels_data = "";
		if ($tbl_custom_fields->radio_labels != "") {
			$radio_labels_data = json_decode($tbl_custom_fields->radio_labels);
		}

		$checkbox_labels_data = "";
		if ($tbl_custom_fields->checkbox_labels != "") {
			$checkbox_labels_data = json_decode($tbl_custom_fields->checkbox_labels);
		}

		return view('Customfields.editcustom',compact('id', 'tbl_custom_fields', 'radio_labels_data', 'checkbox_labels_data')); 
	}
	
	//customfields update
	public function update($id, Request $request)
	{
		//dd($request->all());
		$radio_labels = $request->r_label;		
		$radio_label_json_data = null;		
		if($radio_labels != "")
		{
			$radio_label_json_data = json_encode($radio_labels);
		}

		$checkbox_labels = $request->c_label;
		$checkbox_label_json_data = null;
		if($checkbox_labels != "")
		{
			$checkbox_label_json_data = json_encode($checkbox_labels);
		}

		$tbl_custom_fields = CustomField::find($id);
		//$tbl_custom_fields->form_name = $request->formname;
		$tbl_custom_fields->label = $request->labelname;
		//$tbl_custom_fields->type = $request->typename;
		$tbl_custom_fields->required = $request->required;
		$tbl_custom_fields->always_visable = $request->visable;
		$tbl_custom_fields->radio_labels = $radio_label_json_data;
		$tbl_custom_fields->checkbox_labels = $checkbox_label_json_data;
		
		$tbl_custom_fields->save();
		return redirect('/setting/custom/list')->with('message','Successfully Updated');
	}

	/*Add radio lable in custom field radio type*/
	public function add_radio_label_data(Request $request)
	{
		$radio_labelname = $request->radio_label_name;
		$custom_field_id = $request->custom_field_id;

		$tbl_custom_fields = DB::table('tbl_custom_fields')->where('id','=',$custom_field_id)->first();

		//dd($tbl_custom_fields);
		if (!empty($tbl_custom_fields))
		{
			$radio_label_array = json_decode($tbl_custom_fields->radio_labels);

			if (!empty($radio_label_array)) 
			{				
				if (in_array($radio_labelname, $radio_label_array))
			  	{
			  		return 2; //Duplicate data not allowed
			  	}
			  	else
			  	{
			  		array_push($radio_label_array, $radio_labelname);

			  		$radio_label_json_data = json_encode($radio_label_array);

			  		$updateRow = DB::table('tbl_custom_fields')->where('id','=',$custom_field_id)->update(['radio_labels' => $radio_label_json_data]);

					if ($updateRow) {
						return 1;
					}
					else{
						return 0;
					}
			  	}
			}
			else 
			{
				$radio_label_array = array($radio_labelname);
		  		$radio_label_json_data = json_encode($radio_label_array);

		  		$updateRow = DB::table('tbl_custom_fields')->where('id','=',$custom_field_id)->update(['radio_labels' => $radio_label_json_data]);

				if ($updateRow) {
					return 1;
				}
				else{
					return 0;
				}
			}
		}
		else
		{
			return 0;
		}
	}
	
	/*Delete radio lable from custom field radio type*/
	public function radio_label_delete(Request $request)
	{
		//dd($request->all());
		$radio_labelname = $request->radio_label_name;
		$custom_field_id = $request->custom_field_id;

		$tbl_custom_fields = DB::table('tbl_custom_fields')->where('id','=',$custom_field_id)->first();

		if (!empty($tbl_custom_fields))
		{
			$radio_label_array = json_decode($tbl_custom_fields->radio_labels);

			if (in_array($radio_labelname, $radio_label_array))
		  	{
		  		unset($radio_label_array[array_search($radio_labelname, $radio_label_array)] );

				$radio_label_json_data = json_encode($radio_label_array);

				$updateRow = DB::table('tbl_custom_fields')->where('id','=',$custom_field_id)->update(['radio_labels' => $radio_label_json_data]);

				if ($updateRow) {
					return 1;
				}
				else{
					return 0;
				}
		  	}
			else
		  	{
		  		return 0;
		  	}
		}
		else
		{
			return 0;
		}		
	}


	/*Add checkbox lable in custom field checkbox type*/
	public function add_checkbox_label_data(Request $request)
	{
		$checkbox_labelname = $request->checkbox_label_name;
		$custom_field_id = $request->custom_field_id;

		$tbl_custom_fields = DB::table('tbl_custom_fields')->where('id','=',$custom_field_id)->first();

		if (!empty($tbl_custom_fields))
		{
			$checkbox_label_array = json_decode($tbl_custom_fields->checkbox_labels);

			if (!empty($checkbox_label_array)) 
			{
				if (in_array($checkbox_labelname, $checkbox_label_array))
		  		{
		  			return 2; //Duplicate data not allowed
		  		}
			  	else
			  	{
			  		array_push($checkbox_label_array, $checkbox_labelname);

			  		$checkbox_label_json_data = json_encode($checkbox_label_array);

			  		$updateRow = DB::table('tbl_custom_fields')->where('id','=',$custom_field_id)->update(['checkbox_labels' => $checkbox_label_json_data]);

					if ($updateRow) {
						return 1;
					}
					else{
						return 0;
					}
			  	}
			}
			else {
				$checkbox_label_array = array($checkbox_labelname);
		  		$checkbox_label_json_data = json_encode($checkbox_label_array);

		  		$updateRow = DB::table('tbl_custom_fields')->where('id','=',$custom_field_id)->update(['checkbox_labels' => $checkbox_label_json_data]);

				if ($updateRow) {
					return 1;
				}
				else{
					return 0;
				}
			}
		}
		else
		{
			return 0;
		}
	}
	
	/*Delete checkbox lable from custom field checkbox type*/
	public function checkbox_label_delete(Request $request)
	{
		//dd($request->all());
		$checkbox_labelname = $request->checkbox_label_name;
		$custom_field_id = $request->custom_field_id;

		$tbl_custom_fields = DB::table('tbl_custom_fields')->where('id','=',$custom_field_id)->first();

		if (!empty($tbl_custom_fields))
		{
			$checkbox_label_array = json_decode($tbl_custom_fields->checkbox_labels);

			if (in_array($checkbox_labelname, $checkbox_label_array))
		  	{
		  		unset($checkbox_label_array[array_search($checkbox_labelname, $checkbox_label_array)] );

				$checkbox_label_json_data = json_encode($checkbox_label_array);

				$updateRow = DB::table('tbl_custom_fields')->where('id','=',$custom_field_id)->update(['checkbox_labels' => $checkbox_label_json_data]);

				if ($updateRow) {
					return 1;
				}
				else{
					return 0;
				}
		  	}
			else
		  	{
		  		return 0;
		  	}
		}
		else
		{
			return 0;
		}		
	}
	
}	
