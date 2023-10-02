<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\User;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\tbl_observation_points;
use Illuminate\Support\Facades\Input;

class ObservationPointcontroller extends Controller
{	
	public function __construct()
    {
        $this->middleware('auth');
    }
	
	////observation points list
    public function index()
	{	
		$tbl_observation_points = DB::table('tbl_observation_points')->get()->toArray();
		return view('observation_point.list',compact('tbl_observation_points')); 
	}
	
	////observation points form
	public function addobservation()
	{	
		$tbl_observation_types = DB::table('tbl_observation_types')->get()->toArray();
		return view('observation_point.add',compact('tbl_observation_types')); 
	}
	
	////observation points store
	public function store(Request $request)
	{	
		$tbl_observation_points = new tbl_observation_points;
		$tbl_observation_points->observation_type_id = $request->o_type_id;
		$tbl_observation_points->observation_point = $request->o_point;
		$tbl_observation_points->save();
		return redirect('/observation_point/list')->with('message','Successfully Submitted');
	}
	
	////observation points delete
	public function destroy($id)
	{	
		$delete = DB::table('tbl_observation_points')->where('id','=',$id)->delete();
		return redirect('/observation_point/list')->with('message','Successfully Deleted');
	}
	
	////observation points edit
	public function edit($id)
	{	
		$editid = $id;
		$tbl_observation_types = DB::table('tbl_observation_types')->get()->toArray();
		$tbl_observation_points = DB::table('tbl_observation_points')->where('id','=',$id)->first();
		return view('observation_point.edit',compact('editid','tbl_observation_types','tbl_observation_points')); 
	}
	
	////observation points update
	public function update($id, Request $request)
	{
		$tbl_observation_points = tbl_observation_points::find($id);
		$tbl_observation_points->observation_type_id = $request->o_type_id;
		$tbl_observation_points->observation_point = $request->o_point;
		$tbl_observation_points->save();
		return redirect('/observation_point/list')->with('message','Successfully Updated');
	}
}	