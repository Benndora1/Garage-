<?php

namespace App\Http\Controllers;

use DB;
use Auth; 
use \Validator;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class CountryAjaxcontroller extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
	
	//get state
    public function getstate(Request $request)
	{ 
			//$id = Input::get('countryid');
			$id = $request->countryid;
			
			$states = DB::table('tbl_states')->where('country_id','=',$id)->get()->toArray();
			if(!empty($states))
			{
				foreach($states as $statess)
				{ ?>
				
				<option value="<?php echo  $statess->id; ?>"  class="states_of_countrys"><?php echo $statess->name; ?></option>
				
				<?php }
			}
	}
	
	//get city
	public function getcity(Request $request)
	{ 
			//$stateid = Input::get('stateid');
			$stateid = $request->stateid;

			$citie = DB::table('tbl_cities')->where('state_id','=',$stateid)->get()->toArray();
			if(!empty($citie))
			{
				foreach($citie as $cities)
				{ ?>
				
				<option value="<?php echo  $cities->id; ?>"  class="cities"><?php echo $cities->name; ?></option>
				
				<?php }
			}
	}
}
