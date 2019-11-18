<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;
use Illuminate\Support\Facades\DB;
class SettingsController extends Controller
{
        public function __construct()
    {
    $this->middleware('auth');
    }
    public function index()
    {
		$settings= Setting::all();
		$data = array(
		'settings'=>$settings
		);
        return view('settings.settings')->with($data);

    }
	public function editsetting(Request $request){

			if(!empty($request->id)){
				 try{
					 $Setting= Setting::find($request->id);
				     return response(['status'=>'success', 'details'=>$Setting]);
				    }catch(Exception $e){
					 return response(['status'=>'error']);
					}

			}
	}
		public function updatesetting(Request $request){

        try{

		    if($request->input('txtArea')==''){
				return response(['status'=>'error', 'details'=>"Please enter the setting value"]);
			}
			else{
			DB::table('settings')
            ->where('id', $request->input('id'))
            ->update(['config_value' =>  $request->input('txtArea')]);
			$settings= Setting::all();
            return response(['status'=>'success', 'details'=>$settings]);
			}
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
}
