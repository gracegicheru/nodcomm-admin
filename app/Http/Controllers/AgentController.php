<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Visitor;
use Illuminate\Support\Facades\DB;
use Auth;

class AgentController extends Controller
{
	     public function __construct()
		{
		$this->middleware('auth');
		}
    	public function savelastactivity(){

        try{
			$agent = User::find(Auth::user()->id);
            $agent->last_activity = time();
            $agent->save();
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
	public function onlineagents()
    {

		$time = time() - 10; //now minus 10secs
		if (Auth::user()->admin && Auth::user()->company_id==0){
        $agents = User::where('last_activity', '>', $time)
	    ->where('id', '!=', Auth::user()->id)
		->get();
		}else{
		$agents = User::where('last_activity', '>', $time)
	    ->where('id', '!=', Auth::user()->id)
		->where('company_id', Auth::user()->company_id)
		->get();
		}
		$data = array(
		'agents'=>$agents,
		);
        return view('onlineagents')->with($data);
    }
		public function getonlineagents()
    {

		$time = time() - 10; //now minus 10secs
		if (Auth::user()->admin && Auth::user()->company_id==0){
        $agents = User::where('last_activity', '>', $time)
	    ->where('id', '!=', Auth::user()->id)
		->get();
		}else{
		$agents = User::where('last_activity', '>', $time)
	    ->where('id', '!=', Auth::user()->id)
		->where('company_id', Auth::user()->company_id)
		->get();
		}
		return response($agents);
    }

		public function view_agents_visitors()
    {

		$visitors = DB::table('visitors')
					->select('visitors.*')
					->join('users', 'users.id', '=', 'visitors.assigned_agent')
					->where('users.company_id','=', Auth::user()->company_id)
					->whereNotNull('visitors.assigned_agent')
					->get();
			foreach ($visitors as $visitor) {
			$visitor->{'agent'}=User::find($visitor->assigned_agent);
			
            $device = json_decode($visitor->device_info);


            $visitor->{'browser'} = $device->browser->name . " ver" .$device->browser->major;
            $visitor->{'os'} = $device->os->name . " " . $device->os->version;

            $visitor->{'data_json'} = json_encode($visitor);
        }
			
			$data = array(
			'visitors'=>$visitors
			);
			
			return view('agent_visitors')->with($data);
	}
		   	public function view_agent($id)
    {
			$visitors = User::find($id);
			foreach ($visitors->visitors as $visitor) {
			
            $device = json_decode($visitor->device_info);

            $visitor->{'browser'} = $device->browser->name . " ver" .$device->browser->major;
            $visitor->{'os'} = $device->os->name . " " . $device->os->version;

            $visitor->{'data_json'} = json_encode($visitor);
        }
			$data = array(
			'visitors'=>$visitors
			);

			return view('visitors_per_agent')->with($data);
	}
		public function login($id)
    {
			$user = User::find($id);
			Auth::login($user);
			
			return redirect('/dashboard');
	}
}
