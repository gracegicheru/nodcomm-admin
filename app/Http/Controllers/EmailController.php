<?php

namespace App\Http\Controllers;

use App\Email;
use App\EmailGateway;
use App\Company;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class EmailController extends Controller
{
	public function __construct(){
		$this->middleware('auth');
	}

    public function index(){
		if (Auth::user()->admin && Auth::user()->company_id==0){
    	$messages = Email::with('emailgateway')
    						->with('site')
    						->orderBy('created_at', 'desc')
    						->get();
	    
		return view('emails/email_history')->with('messages', $messages);
		}else{
		$messages = Email::with('emailgateway')
    						->with('site')
							->where('initiator', Auth::user()->company_id)
    						->orderBy('created_at', 'desc')
    						->get();
	    $date=date("Y-m-d");
		return view('emails/company_email_history')->with('messages', $messages)->with('date', $date);
		}
    	
		
    }
    public function companyemails($id){

		$messages = Email::with('emailgateway')
    						->with('site')
							->where('initiator', $id)
    						->orderBy('created_at', 'desc')
    						->get();
	    $date=date("Y-m-d");
		$data = array(
		'date'=>$date,
		'messages'=>$messages,
		'companyid'=>$id
		);
		return view('emails/company_email_history')->with($data);	
    }
    public function get_filters(){

    	$sites = Company::all();
    	$gateways = EmailGateway::all();
		return response(['sites'=>$sites, 'gateways'=>$gateways]);

    	
    }

    public function apply_filters(Request $request){
		
    	$gateways_filter = $request->input('gateways_filter');
    	$sites_filter = $request->input('sites_filter');
    	$status_filter = $request->input('status_filter');

    	$query = Email::with('emailgateway')->with('site');

    	if($gateways_filter != "all"){
    		$query->where('email_gateway', $gateways_filter);
    	}
    	if($sites_filter != "all"){
    		$query->where('initiator', $sites_filter);
    	}
    	if($status_filter != "all"){
    		$query->where('status', $status_filter);
    	}

    	$query->orderBy('created_at', 'desc');
    	$messages = $query->get();

    	if($messages->isEmpty()){
    		return response(['status'=>'no_data']);
    	}else{
    		return response(['status'=>'success', 'data'=>$messages]);
    	}
    }
	
	    public function apply_company_filters(Request $request){
		if(isset($request->companyid)){
			$companyid=$request->companyid;
		}else{
			$companyid=Auth::user()->company_id;
		}
    	$startdate = $request->input('startdate');
    	$enddate = $request->input('enddate');
        $status_filter = $request->input('statusfilter');

		if(empty($startdate) && empty($enddate))
		{
		$startdate=date("Y-m-d");
		$enddate=date("Y-m-d");
		}
		
    	if($status_filter != "all"){
			$messages = DB::table('emails')
			->select('*')
			->where('initiator', $companyid)
			->where('status', $status_filter)
			->where(DB::raw("(STR_TO_DATE(emails.created_at,'%Y-%m-%d'))"), ">=", $startdate)
			->where(DB::raw("(STR_TO_DATE(emails.created_at,'%Y-%m-%d'))"), "<=", $enddate)
			->orderBy('created_at', 'desc')
			->get();
    	}else{
			$messages = Email::where('initiator', $companyid)
			->where(DB::raw("(STR_TO_DATE(emails.created_at,'%Y-%m-%d'))"), ">=", $startdate)
			->where(DB::raw("(STR_TO_DATE(emails.created_at,'%Y-%m-%d'))"), "<=", $enddate)
			->orderBy('created_at', 'desc')
			->get();
		}

    	if($messages->isEmpty()){
    		return response(['status'=>'no_data']);
    	}else{
    		return response(['status'=>'success', 'data'=>$messages]);
    	}
    }
}
