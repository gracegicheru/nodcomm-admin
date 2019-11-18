<?php

namespace App\Http\Controllers;
use App\Pagination;
use App\Message;
use App\SMSGateway;
use App\SMSPayment;
use App\Company;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\TestMessage;
class MessageController extends Controller
{
	public function __construct(){
		$this->middleware('auth');
	}

	public function index(){


        $userId = Auth::id();
//        dd($userId);

        $messages= TestMessage::where('sent_by', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

//        dd($messages);



	    $date=date("Y-m-d");
		return view('messages/company_history')->with('messages', $messages)->with('date', $date);

//        return view('messages/sms_history')->with('messages', $messages)->with('date', $date);
		}

    public function showDetails($id){

       $detailId= TestMessage::find($id);


        return view('details')->with('details', $detailId);
    }



//    }
	 	 public function load_more(){
		if(Session::has('skip')){
		$skip = Session::get('skip');
		session(['skip' => (10 + $skip)]);
		}else{
		$skip =10;
		session(['skip' => 10]);
		}
		if (Auth::user()->admin && Auth::user()->company_id==0){
		$messages = Message::with('smsgateway')
    						->with('site')
							->skip($skip)
							->take(10)
    						->orderBy('created_at', 'desc')
    						->get();
		 }else{
		$messages = Message::with('smsgateway')
    						->with('site')
							->where('initiator', Auth::user()->company_id)
							->skip(0)
							->take(10)
    						->orderBy('created_at', 'desc')
    						->get();	 
		 }
    	if($messages->isEmpty()){
    		return response(['status'=>'no_data']);
    	}else{
    		return response(['status'=>'success', 'messages'=>$messages]);
    	}
	 }
	 public function search_sms(Request $request){

         $phone = $request->input('search');

         $userId = Auth::id();
         if(!empty($phone)&&!empty($userId)) {
             $messages = TestMessage::where('sent_by', $userId)
                 ->where('phone', $phone)
                 ->orderBy('created_at', 'desc')
                 ->get();
//                dd($messages);

             return response()->json([
                 'status'=>'ok',
                 'collection'=>$messages

             ]);
         }else{
             return response()->json([
                 'status'=> 'no_data',
                 'response'=>'Messages not found'
             ]);
         }

	 }
	 	public function load_search_more(Request $request){
		if(Session::has('skip1')){
		$skip = Session::get('skip1');
		session(['skip1' => (10 + $skip)]);
		}else{
		$skip =10;
		session(['skip1' => 10]);
		}
		if (Auth::user()->admin && Auth::user()->company_id==0){
		$messages = Message::with('smsgateway')
    						->with('site')
							->skip($skip)
							->take(10)
    						->orderBy('created_at', 'desc')
							->Where('msisdn', 'like', '%' .Session::get('search') . '%')
    						->get();
		 }else{
		$messages = Message::with('smsgateway')
    						->with('site')
							->where('initiator', Auth::user()->company_id)
							->skip($skip)
							->take(10)
    						->orderBy('created_at', 'desc')
							->Where('msisdn', 'like', '%' .Session::get('search') . '%')
    						->get();	 
		 }
    	if($messages->isEmpty()){
    		return response(['status'=>'no_data']);
    	}else{
    		return response(['status'=>'success', 'messages'=>$messages]);
    	}
	 }
    public function companymessages($id){

		$messages = Message::with('smsgateway')
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
		return view('messages/company_history')->with($data);	
    }
    public function get_filters(){

    	$sites = Company::all();
    	$gateways = SMSGateway::all();
		return response(['sites'=>$sites, 'gateways'=>$gateways]);

    	
    }
    public function load_more_apply_filters(){
		if(Session::has('skip2')){
		$skip = Session::get('skip2');
		session(['skip2' => (10 + $skip)]);
		}else{
		$skip =10;
		session(['skip2' => 10]);
		}
		$gateways_filter = Session::get('gateways_filter');
    	$sites_filter = Session::get('sites_filter');
    	$status_filter = Session::get('status_filter');
		$query = Message::with('smsgateway')->with('site');

    	if($gateways_filter != "all"){
    		$query->where('sms_gateway', $gateways_filter);
    	}
    	if($sites_filter != "all"){
    		$query->where('initiator', $sites_filter);
    	}
    	if($status_filter != "all"){
    		$query->where('status', $status_filter);
    	}

    	$query->orderBy('created_at', 'desc');
		$query->skip($skip);
		$query->take(10);
    	$messages = $query->get();

    	if($messages->isEmpty()){
    		return response(['status'=>'no_data']);
    	}else{
    		return response(['status'=>'success', 'messages'=>$messages]);
    	}
    }
    public function apply_filters(Request $request){
		session(['skip2' => 10]);
		session(['gateways_filter' => $request->input('gateways_filter')]);
		session(['sites_filter' => $request->input('sites_filter')]);
		session(['status_filter' => $request->input('status_filter')]);
    	$gateways_filter = $request->input('gateways_filter');
    	$sites_filter = $request->input('sites_filter');
    	$status_filter = $request->input('status_filter');
		$query = Message::with('smsgateway')->with('site');

    	if($gateways_filter != "all"){
    		$query->where('sms_gateway', $gateways_filter);
    	}
    	if($sites_filter != "all"){
    		$query->where('initiator', $sites_filter);
    	}
    	if($status_filter != "all"){
    		$query->where('status', $status_filter);
    	}

    	$query->orderBy('created_at', 'desc');
		$query->skip(0);
		$query->take(10);
    	$messages = $query->get();

    	if($messages->isEmpty()){
    		return response(['status'=>'no_data']);
    	}else{
    		return response(['status'=>'success', 'data'=>$messages]);
    	}
    }
	
	    public function apply_company_filters(Request $request){

            $from = $request->input('datepicker');
            $to = $request->input('datepicker1');
            $status = $request->input('statusfilter');

            $userId = Auth::id();
            if(!empty($status)&&!empty($userId)) {
                $messages = TestMessage::where('sent_by', $userId)
                    ->whereDate('created_at', '>=', $from)
                    ->whereDate('created_at', '<=', $to)
                    ->where('status', $status)
                    ->orderBy('created_at', 'desc')
                    ->get();
//                dd($messages);

                return response()->json([
                    'status'=>'ok',
                    'collection'=>$messages

                ]);
            }else{
                return response()->json([
                    'status'=> 'no_data',
                    'response'=>'Messages not found'
                ]);
            }
//            if($messages->isEmpty()){
//    		return response(['status'=>'no_data']);
//    	}else{
//    		return response(['status'=>'success', 'data'=>$messages]);
//    	}


    }
		public function load_more_apply_company_filters(Request $request){
		if(Session::has('skip2')){
		$skip = Session::get('skip2');
		session(['skip2' => (10 + $skip)]);
		}else{
		$skip =10;
		session(['skip2' => 10]);
		}
		$startdate = Session::get('startdate');
    	$enddate = Session::get('enddate');
    	$status_filter = Session::get('status_filter');
		$companyid = Session::get('companyid');
    	if($status_filter != "all"){
			$messages = DB::table('messages')
			->select('*')
			->where('initiator', $companyid)
			->where('status', $status_filter)
			->where(DB::raw("(STR_TO_DATE(messages.created_at,'%Y-%m-%d'))"), ">=", $startdate)
			->where(DB::raw("(STR_TO_DATE(messages.created_at,'%Y-%m-%d'))"), "<=", $enddate)
			->orderBy('created_at', 'desc')
			->skip($skip)
			->take(10)
			->get();
    	}else{
			$messages = Message::where('initiator', $companyid)
			->where(DB::raw("(STR_TO_DATE(messages.created_at,'%Y-%m-%d'))"), ">=", $startdate)
			->where(DB::raw("(STR_TO_DATE(messages.created_at,'%Y-%m-%d'))"), "<=", $enddate)
			->orderBy('created_at', 'desc')
			->skip($skip)
			->take(10)
			->get();
		}

    	if($messages->isEmpty()){
    		return response(['status'=>'no_data']);
    	}else{
    		return response(['status'=>'success', 'messages'=>$messages]);
    	}
    }
}
