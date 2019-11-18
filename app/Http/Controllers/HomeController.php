<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Message;
use App\DepartmentAgent;
use App\Department;
use App\Visitor;
use App\Site;
use App\Company;
use Auth;
use Session;
use App\Setting;
use App\Translator;
use Carbon\Carbon;
use App\SMSCredit;
use App\SMSPayment;
use App\Push_sites;
use App\Pushnotification;
use App\TestMessage;
use DateTime;
use DateInterval;
use DatePeriod;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
	
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
	public function deliveredandfailedmessages(){
		$total_messages= TestMessage::all();
		$sent_messages= TestMessage::where('status','sent')->get();
		$failed_messages= TestMessage::where('status','fail')->get();
			if((count($total_messages)==0)){
			 $sentpercentage=0; 
			 $failedpercentage=0;
			 }else{
			 $sentpercentage=(count($sent_messages)/count($total_messages))*100; 
			 $failedpercentage=(count($failed_messages)/count($total_messages))*100; 
			 }
		return response
		([
		'sentpercentage'=>$sentpercentage, 
		'failedpercentage'=>$failedpercentage 
		]);
	}
		 	 public function search_time_sms(Request $request){
			$months = [];
			$count = [];
			$date_range =  date_format(Carbon::today(),'l d/m/Y') .' to '. date_format(Carbon::today(),'l d/m/Y');;
			$monday = Carbon::now()->startOfWeek();
			$sunday = Carbon::now()->endOfWeek();
			$monday1=Carbon::now()->subWeeks(1)->startOfWeek();	
			$sunday1=Carbon::now()->subWeeks(1)->endOfWeek();	
			$currentMonth = date('m');	
			$now = new DateTime('now');
			// Create a date interval string to go back to the first day of the previous month
			$int = sprintf('P1M%dD', $now->format('j')-1);
			// Get the first day of the previous month as DateTime
			$fdopm = $now->sub(new DateInterval($int));
			if($request->time_search==''){
			 return response(['status'=>'error', 'details'=>"Please select time"]);
			}else{
			if($request->input('time_search')==1){
				$messages = TestMessage::whereDate('created_at', Carbon::today())->get();
				$sent_messages= TestMessage::whereDate('created_at', Carbon::today())->where('status','sent')->get();
				$failed_messages= TestMessage::whereDate('created_at', Carbon::today())->where('status','fail')->get();
			}else if($request->input('time_search')==2){
				$messages = TestMessage::whereBetween('created_at', [$monday, $sunday])->orderBy('created_at', 'desc')->get();
				$sent_messages= TestMessage::whereBetween('created_at', [$monday, $sunday])->where('status','sent')->get();
				$failed_messages= TestMessage::whereBetween('created_at', [$monday, $sunday])->where('status','fail')->get();
				$date_range =  date_format($monday,'l d/m/Y') .' to '. date_format($sunday,'l d/m/Y');;
				function thisweekdays() {
					return [
						Carbon::now()->startOfWeek(),
						$tuesday = Carbon::now()->startOfWeek()->copy()->addDay(),
						$wednesday = $tuesday->copy()->addDay(),
						$thursday = $wednesday->copy()->addDay(),
						$friday = $thursday->copy()->addDay(),
						$saturday = $friday->copy()->addDay(),
						Carbon::now()->endOfWeek()
					];
				}
				foreach(thisweekdays() as $day){
					//echo date("l",strtotime($monday));
					$messagestotal = TestMessage::whereDate('created_at', $day)->count('*');
					$count [] = $messagestotal;
					$months [] = date("l",strtotime($day));	
				}
			}else if($request->input('time_search')==3){
				$messages = TestMessage::whereBetween('created_at', [$monday1, $sunday1])->orderBy('created_at', 'desc')->get();
				$sent_messages= TestMessage::whereBetween('created_at', [$monday1, $sunday1])->where('status','sent')->get();
				$failed_messages= TestMessage::whereBetween('created_at', [$monday1, $sunday1])->where('status','fail')->get();
				$date_range =  date_format($monday1,'l d/m/Y') .' to '. date_format($sunday1,'l d/m/Y');;
				function lastweekdays() {
					return [
						$monday=Carbon::now()->subWeeks(1)->startOfWeek(),
						$tuesday = $monday->copy()->addDay(),
						$wednesday = $tuesday->copy()->addDay(),
						$thursday = $wednesday->copy()->addDay(),
						$friday = $thursday->copy()->addDay(),
						$saturday = $friday->copy()->addDay(),
						Carbon::now()->subWeeks(1)->endOfWeek()
					];
				}
				foreach(lastweekdays() as $day){
					//echo date("l",strtotime($monday));
					$messagestotal = TestMessage::whereDate('created_at', $day)->count('*');
					$count [] = $messagestotal;
					$months [] = date("l",strtotime($day));	
				}
			}else if($request->input('time_search')==4){
				$messages = TestMessage::whereRaw('MONTH(created_at) = ?',[$currentMonth])->get();
				$sent_messages= TestMessage::whereRaw('MONTH(created_at) = ?',[$currentMonth])->where('status','sent')->get();
				$failed_messages= TestMessage::whereRaw('MONTH(created_at) = ?',[$currentMonth])->where('status','fail')->get();
				 $date_range = date('01-m-Y') .' to '. date('t-m-Y');
				// this will default to a time of 00:00:00
				$begin = new DateTime(date('Y-m-01') ); //2016-07-04

				$end = clone $begin;

				// this will default to a time of 00:00:00    
				$end->modify(date('Y-m-t')); // 2016-07-08

				$end->setTime(0,0,1);     // new line

				$interval = new DateInterval('P1D');
				$period = new DatePeriod($begin, $interval, $end);
				foreach ($period as $key => $value) {
					//echo $value->format('Y-m-d').'<br>'  ;
					$messagestotal = TestMessage::whereDate('created_at', $value->format('Y-m-d'))->count('*');
					$count [] = $messagestotal;
					$months [] = date('j',strtotime($value->format('Y-m-d')));						
				}
			}else if($request->input('time_search')==5){
				$messages = TestMessage::whereRaw('MONTH(created_at) = ?',[$fdopm->format('m')])->get();
				$sent_messages= TestMessage::whereRaw('MONTH(created_at) = ?',[$fdopm->format('m')])->where('status','sent')->get();
				$failed_messages= TestMessage::whereRaw('MONTH(created_at) = ?',[$fdopm->format('m')])->where('status','fail')->get();
				$startLastMonth = mktime(0, 0, 0, date("m") - 1, 1, date("Y"));
				$endLastMonth = mktime(0, 0, 0, date("m"), 0, date("Y"));
				$startOutput = date("Y-m-d", $startLastMonth);
				$endOutput = date("Y-m-d", $endLastMonth);
				$date_range = date("d-m-Y", $startLastMonth) .' to '. date("d-m-Y", $endLastMonth);
				// this will default to a time of 00:00:00
				$begin = new DateTime($startOutput); //2016-07-04

				$end = clone $begin;

				// this will default to a time of 00:00:00    
				$end->modify($endOutput); // 2016-07-08

				$end->setTime(0,0,1);     // new line

				$interval = new DateInterval('P1D');
				$period = new DatePeriod($begin, $interval, $end);
				foreach ($period as $key => $value) {
					//echo $value->format('Y-m-d').'<br>'  ;
					$messagestotal = TestMessage::whereDate('created_at', $value->format('Y-m-d'))->count('*');
					$count [] = $messagestotal;
					$months [] = date('j',strtotime($value->format('Y-m-d')));						
				}
			}
			
			if($messages->isEmpty()){
				return response(['status'=>'no_data']);
			}else{
				if((count($messages)==0)){
				 $sentpercentage=0; 
				 $failedpercentage=0;
				 }else{
				 $sentpercentage=(count($sent_messages)/count($messages))*100; 
				 $failedpercentage=(count($failed_messages)/count($messages))*100; 
				 }
				return response(['status'=>'success', 'messages'=>count($messages),'sentpercentage'=>$sentpercentage,'failedpercentage'=>$failedpercentage, 'data'=>$count, 'labels'=>$months,'date_range'=>$date_range]);
			}
		 }
	 }
	public function super_admin_data(){
		$monday = Carbon::now()->startOfWeek();
		$sunday = Carbon::now()->endOfWeek();
		$monday3=Carbon::now()->subWeeks(1)->startOfWeek();
		$monday2=Carbon::now()->subWeeks(2)->startOfWeek();
		$monday1=Carbon::now()->subWeeks(3)->startOfWeek();
		$sunday3=Carbon::now()->subWeeks(1)->endOfWeek();
		$sunday2=Carbon::now()->subWeeks(2)->endOfWeek();
		$sunday1=Carbon::now()->subWeeks(3)->endOfWeek();
		$companies = Company::all();
		$messages = Message::all();
		$users = User::where('company_id','!=',0)->get();
		$visitors = Visitor::all();
		$currentMonth = date('m');
		$newcompanies = Company::whereRaw('MONTH(created_at) = ?',[$currentMonth])
					->get();
		$newmessages = Message::whereRaw('MONTH(created_at) = ?',[$currentMonth])
					->get();
		$total_traffic = TestMessage::all();
	    $newusers= User::whereRaw('MONTH(created_at) = ?',[$currentMonth])
					->get();
		$newvisitors = Visitor::whereRaw('MONTH(created_at) = ?',[$currentMonth])
					->get();
		$result = Company::whereBetween('payment_date', [$monday, $sunday])->count();
		$result1 = Company::whereBetween('payment_date', [$monday1, $sunday1])->count();
		$result2 = Company::whereBetween('payment_date', [$monday2, $sunday2])->count();
		$result3 = Company::whereBetween('payment_date', [$monday3, $sunday3])->count();
		$company_payable_amount = Setting::where('config_key','company_payable_amount')->first()->config_value;
		$earning = $result * $company_payable_amount ;
		$earning1 = $result1 * $company_payable_amount ;
		$earning2 = $result2 * $company_payable_amount ;
		$earning3 = $result3 * $company_payable_amount ;
		$earning_array = array(
		"monday"=>date('d',strtotime($monday)), 
		"sunday"=>date('d',strtotime($sunday)),
		"earning"=>$earning,
		"monday1"=>date('d',strtotime($monday1)), 
		"sunday1"=>date('d',strtotime($sunday1)),
		"earning1"=>$earning1,
		"monday2"=>date('d',strtotime($monday2)), 
		"sunday2"=>date('d',strtotime($sunday2)),
		"earning2"=>$earning2,
		"monday3"=>date('d',strtotime($monday3)), 
		"sunday3"=>date('d',strtotime($sunday3)),
		"earning3"=>$earning3,
		);
		return response
		([
		'messages'=>count($messages), 
		'users'=>count($users), 
		'visitors'=>count($visitors), 
		'companies'=>count($companies),
		'newcompanies'=>count($newcompanies), 
		'newmessages'=>count($newmessages), 
		'newusers'=>count($newusers), 
		'newvisitors'=>count($newvisitors), 
		'monday'=>date('d',strtotime($monday)), 
		'earning_array'=>$earning_array,
		'sunday'=>date('d',strtotime($sunday)),
		"total_traffic"=>count($total_traffic)
		]);
	}
		public function admin_data(){
		$push_sites = Push_sites::where('company_id',Auth::user()->company_id)->get();
		$chat_sites = Site::where('company_id',Auth::user()->company_id)->get();
		$Pushnotification = Pushnotification::where('company_id',Auth::user()->company_id)->get();
		$departments = Department::where('company_id', Auth::user()->company_id)->get();
		$messages = Message::where('initiator',Auth::user()->company_id)->get();
		$users = User::where('company_id',Auth::user()->company_id)->get();
		$visitors = Visitor::
					where('company', Auth::user()->company_id)
					->get();
		$currentMonth = date('m');
		$newcompanies = Company::whereRaw('MONTH(created_at) = ?',[$currentMonth])
					->get();
		$newmessages = Message::where('initiator',Auth::user()->company_id)
					->whereRaw('MONTH(created_at) = ?',[$currentMonth])
					->get();
	    $newusers= User::where('company_id',Auth::user()->company_id)
					->whereRaw('MONTH(created_at) = ?',[$currentMonth])
					->get();
		$newvisitors = Visitor::whereRaw('MONTH(created_at) = ?',[$currentMonth])
					->where('company', Auth::user()->company_id)
					->get();
		$SMSCredit = SMSCredit::where('user_id', Auth::user()->id)->first();
		return response
		([
		'messages'=>count($messages), 
		'users'=>count($users), 
		'visitors'=>count($visitors), 
		'newmessages'=>count($newmessages), 
		'newusers'=>count($newusers), 
		'newvisitors'=>count($newvisitors),
		'push_sites'=>count($push_sites),
		'chat_sites'=>count($chat_sites),
		'Pushnotification'=>count($Pushnotification),
		'departments'=>count($departments),
		'credit'=>$SMSCredit,		
		]);
	}
    public function visitors_graph()
    {
		$currentMonth = date('F');
		$months = [];
		$count = [];
	    $visitors = DB::select('SELECT distinct MONTHNAME(`created_at`) as month, count(*) as count FROM `visitors` where `created_at` >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH) and company = ? group by MONTHNAME(`created_at`) order by `created_at` ASC',[Auth::user()->company_id]);
		foreach($visitors as $visitor){
			$count [] = $visitor->count;
			$months [] = $visitor->month;
			
		}
		if(!empty($count) && !empty($months)){
		return response(array('data'=>$count, 'labels'=>$months));
		}else{
		$count [] = 0;
		$months [] = $currentMonth ;
		return response(array('data'=>$count, 'labels'=>$months));	
		}
	}
	    public function companies_graph()
    {
		$currentMonth = date('F');
		$months = [];
		$count = [];
	    $companies = DB::select('SELECT distinct MONTHNAME(`created_at`) as month, count(*) as count FROM `companies` where `created_at` >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)  group by MONTHNAME(`created_at`) order by `created_at` ASC');
		foreach($companies as $company){
			$count [] = $company->count;
			$months [] = $company->month;
			
		}
		if(!empty($count) && !empty($months)){
		return response(array('data'=>$count, 'labels'=>$months));
		}else{
		$count [] = 0;
		$months [] = $currentMonth ;
		return response(array('data'=>$count, 'labels'=>$months));	
		}
	}
	    public function sms_credit_buying()
    {
		$currentMonth = date('F');
		$months = [];
		$count = [];
	    $credits = DB::select('SELECT distinct MONTHNAME(`created_at`) as month, sum(credit) as sum, sum(amount) as amount_sum FROM `smspayment` where `created_at` >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH) and company_id = ? and user_id = ? group by MONTHNAME(`created_at`) order by `created_at` ASC',[Auth::user()->company_id,Auth::user()->id]);
		$sum = 0;
		foreach($credits as $credit){
			$count [] = $credit->sum;
			$months [] = $credit->month;
			$sum +=  floatval($credit->amount_sum);
		}
		if(!empty($count) && !empty($months)){
		return response(array('sum'=>$sum,'data'=>$count, 'labels'=>$months));
		}else{
		$count [] = 0;
		$months [] = $currentMonth ;
		return response(array('sum'=>$sum,'data'=>$count, 'labels'=>$months));
		}
		
	}
		    public function sms_sales()
    {
		$currentMonth = date('F');
		$months = [];
		$count = [];
	    $credits = DB::select('SELECT distinct MONTHNAME(`created_at`) as month, count(*) as count  FROM `smspayment` where `created_at` >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)  group by MONTHNAME(`created_at`) order by `created_at` ASC');
		foreach($credits as $credit){
			$count [] = $credit->count;
			$months [] = $credit->month;
		}
		if(!empty($count) && !empty($months)){
		return response(array('data'=>$count, 'labels'=>$months));
		}else{
		$count [] = 0;
		$months [] = $currentMonth ;
		return response(array('data'=>$count, 'labels'=>$months));	
		}
	}
	 public function sms_sales_amount()
    {
		$currentMonth = date('F');
	    $credits = DB::select('SELECT distinct MONTHNAME(`created_at`) as month, sum(amount) as sum FROM `smspayment` where `created_at` >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)  group by MONTHNAME(`created_at`) order by `created_at` ASC');
		$final = [];
		foreach($credits as $credit){
			$final[$credit->month] = $credit->sum;
		}
		
		if(!empty($final)){
		return response(array('final'=>$final ));
		}else{
		$final[$currentMonth] = 0;
		return response(array('final'=>$final ));	
		}
	}
		 public function sender_id_amount()
    {
		$currentMonth = date('F');
	    $credits = DB::select('SELECT distinct MONTHNAME(`created_at`) as month, sum(amount) as sum FROM `sender_id_payment` where `created_at` >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)  group by MONTHNAME(`created_at`) order by `created_at` ASC');
		$final = [];
		foreach($credits as $credit){
			$final[$credit->month] = $credit->sum;
		}
		if(!empty($final)){
		return response(array('final'=>$final ));
		}else{
		$final[$currentMonth] = 0;
		return response(array('final'=>$final ));	
		}
	}
		    public function sms_credit_amount()
    {
		$currentMonth = date('F');
	    $credits = DB::select('SELECT distinct MONTHNAME(`created_at`) as month, sum(amount) as sum FROM `smspayment` where `created_at` >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH) and company_id = ? and user_id = ? group by MONTHNAME(`created_at`) order by `created_at` ASC',[Auth::user()->company_id,Auth::user()->id]);
		$final = [];
		foreach($credits as $credit){
			$final[$credit->month] = $credit->sum;
		}
		if(!empty($final)){
		return response(array('final'=>$final ));
		}else{
		$final[$currentMonth] = 0;
		return response(array('final'=>$final ));	
		}
	}
	
	public function sent_sms()
    {
		$currentMonth = date('F');
	    $sms = DB::select('SELECT distinct MONTHNAME(`created_at`) as month, count(*) as count FROM `test_messages` where `created_at` >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH) and company_id = ? and sent_by = ? group by MONTHNAME(`created_at`) order by `created_at` ASC',[Auth::user()->company_id,Auth::user()->id]);
		$final = [];
		foreach($sms as $sm){
			$final[$sm->month] = $sm->count;
		}
		if(!empty($final)){
		return response(array('final'=>$final ));
		}else{
		$final[$currentMonth] = 0;
		return response(array('final'=>$final ));	
		}
	}
	    public function index()
    {
		$monday = Carbon::now()->startOfWeek();
		$sunday = Carbon::now()->endOfWeek();
		$result = Company::whereBetween('payment_date', [$monday, $sunday])->count();
		$company_payable_amount = Setting::where('config_key','company_payable_amount')->first()->config_value;
		$earning = $result * $company_payable_amount ;
		$translated_langs = Translator::all();
		$company = Company::where('id',Auth::user()->company_id);
		$trial_days = Setting::where('config_key','company_trial-days')->first()->config_value;
		$extended_trial_days = Setting::where('config_key','extended_trial_days')->first()->config_value;
		
		if($company->count()>0){
		$today = time();
		$interval = $today-strtotime($company->first()->created_at) ;
		$days = floor($interval / 86400); // 1 day

		$extendedinterval = strtotime($company->first()->extende_trial_date)-$today ;
		$extendeddays = floor($extendedinterval / 86400); // 1 day

		$startdate = date('Y-m-d H:i:s', strtotime('-'.$extended_trial_days.' days', strtotime($company->first()->extende_trial_date)));
		$difference = $today-strtotime($startdate);
		$differenceindays = floor($difference / 86400);
		}

		
		
		if(Session::has('verification')){
		if(Auth::user()->admin==1 && Auth::user()->company_id==0){
		$companies = Company::all();
		$messages = Message::all();
		$users = User::where('company_id','!=',0)->get();
		$visitors = Visitor::all();
		$currentMonth = date('m');
		$newcompanies = Company::whereRaw('MONTH(created_at) = ?',[$currentMonth])
					->get();
		$newmessages = Message::whereRaw('MONTH(created_at) = ?',[$currentMonth])
					->get();
	    $newusers= User::whereRaw('MONTH(created_at) = ?',[$currentMonth])
					->get();
		$newvisitors = Visitor::whereRaw('MONTH(created_at) = ?',[$currentMonth])
					->get();
		foreach($companies as $company){
			$totalvisitors=0;
			foreach($company->sites as $site){
			$site_visitors = Visitor::where('site',$site->id)->get();
			$totalvisitors +=count($site_visitors);
			}
			$company->{'totalvisitors'}=$totalvisitors;
		}

		$data = array(
		'companies'=>$companies,
		'earning'=>$earning,
		'translated_langs'=>$translated_langs
		);
		
        return view('dashboard')->with($data);
		}
		 else if(Auth::user()->admin==1 && Auth::user()->company_id!=0){
		$credit = SMSCredit::where('user_id', Auth::user()->id)->first();
		if(!empty($credit)){
		$c =	floatval($credit->credit);
		}else{
		$c = 0;
		}
		$data = array(
		'credit'=>$c,
		);

			return view('company_dashboard')->with($data);
		}
		 else if(Auth::user()->admin==0 && Auth::user()->company_id!=0){
		$credit = SMSCredit::where('user_id', Auth::user()->id)->first();
		if(!empty($credit)){
		$c =	floatval($credit->credit);
		}else{
		$c = 0;
		}
		$data = array(
		'credit'=>$c,
		);
			return view('agent_dashboard')->with($data);

		}
	    else if(Auth::user()->admin==0 && Auth::user()->company_id==0){
	   $agentids = DB::table('users')
					->join('visitors', 'visitors.assigned_agent', '=', 'users.id')
					->where('users.company_id','=', Auth::user()->company_id)
					->groupBy('assigned_agent')
					->get();
		
		foreach ($agentids  as $agentid){
		   $agentid->{'total_visitors'}  = DB::table('visitors')
				->where('assigned_agent','=',  $agentid->assigned_agent)
				->count();
			$agentid->{'agent'}  = User::find($agentid->assigned_agent);
		}
		$departments = Department::where('company_id', Auth::user()->company_id)->get();
		$agents = User::where('company_id', Auth::user()->company_id)->get();
		$time = time() - 10; //now minus 10secs
        $online_agents = User::where('last_activity', '>', $time)
	    ->where('id', '!=', Auth::user()->id)
		->where('company_id', Auth::user()->company_id)
		->get();

	    $online_visitors_count = DB::table('sites')
				  ->join('visitors', 'visitors.site', '=', 'sites.id')
				  ->where('visitors.last_activity','>', $time)
				  ->where('sites.company_id', Auth::user()->company_id)
				  ->count();
	   $queue_visitors_count = DB::table('sites')
				  ->join('visitors', 'visitors.site', '=', 'sites.id')
				  ->whereNull('assigned_agent')
				  ->where('sites.company_id', Auth::user()->company_id)
				  ->count();
					
		$agents_onchat_count = DB::table('users')
					->select('users.*')
					->join('visitors', 'visitors.assigned_agent', '=', 'users.id')
					->where('users.company_id','=', Auth::user()->company_id)
					->whereNotNull('visitors.assigned_agent')
					->groupBy('users.id')
					->get();
		
		$website_chats = Site::where('company_id', Auth::user()->company_id)->get();

		$data = array(
		'agents'=>$agents,
		'agentswithvisitors'=>$agentids,
		'online_agents'=>$online_agents,
		'online_visitors_count'=>$online_visitors_count,
		'queue_visitors_count'=>$queue_visitors_count,
		'agents_onchat_count'=>count($agents_onchat_count),
		'website_chats'=>$website_chats,
		'departments'=>$departments,
		'translated_langs'=>$translated_langs
		);
			return view('agent_dashboard')->with($data);

		}
	}else{
	return redirect()->route('login');	
	}
    }
 
	 public function dashboard()
    {
		$company = Company::where('id',Auth::user()->company_id);
		$trial_days = Setting::where('config_key','company_trial-days')->first()->config_value;
		
		if($company->count()>0){
		$today = time();
		$interval = $today-strtotime($company->first()->created_at) ;
		$days = floor($interval / 86400); // 1 day
		}
	if(Session::has('verification')){

	return view('dashboard_menu');	
	
	}else{
	return redirect()->route('login');	
	}
	}

	    public function online(){
        $time = time() - 10; //now minus 10secs
		if (Auth::user()->admin && Auth::user()->company_id==0){
        $users_count = User::all();
		$visitors_count = Visitor::all();
		$companies_count = Company::all();
		$messages_count = Message::all();
		return response(array('visitors_count'=>count($visitors_count),'companies_count'=>count($companies_count),'users_count'=>count($users_count),'messages_count'=>count($messages_count)));
		}else{
		$online_visitors_count = DB::table('sites')
				  ->join('visitors', 'visitors.site', '=', 'sites.id')
				  ->where('visitors.last_activity','>', $time)
				  ->where('sites.company_id', Auth::user()->company_id)
				  ->count();
	   $queue_visitors_count = DB::table('sites')
				  ->join('visitors', 'visitors.site', '=', 'sites.id')
				  ->whereNull('assigned_agent')
				  ->where('sites.company_id', Auth::user()->company_id)
				  ->count();

		$agents_onchat_count = DB::table('users')
					->join('visitors', 'visitors.assigned_agent', '=', 'users.id')
					->where('users.company_id','=', Auth::user()->company_id)
					->whereNotNull('visitors.assigned_agent')
					->groupBy('visitors.assigned_agent')
					->get();
		return response(array('queue_visitors_count'=>$queue_visitors_count,'agents_onchat_count'=>count($agents_onchat_count),'online_visitors_count'=>$online_visitors_count));
		}

		
    }
	
	public function companies(){
		 $countries = DB::select('SELECT distinct country, latitude, longitude FROM `companies`');
		
		foreach($countries as $country){
			 $count = DB::select('SELECT count(*) as count FROM `companies`');
			 $country->{'count'} = $count[0]->count;
		}
		return response(array('countries'=>$countries));
	}
	 	 public function search_company_by_name(Request $request){
		session(['skip1' => 10]);
		session(['search' => $request->input('search')]);

		$companies = Company::skip(0)
							->take(10)
    						->orderBy('created_at', 'desc')
							->Where('name', 'like', '%' .$request->input('search') . '%')
    						->get();

    	if($companies->isEmpty()){
    		return response(['status'=>'no_data']);
    	}else{

    		return response(['status'=>'success', 'companies'=>$companies]);
    	}
	 }
		public function load_company_by_name_search_more(Request $request){
		if(Session::has('skip1')){
		$skip = Session::get('skip1');
		session(['skip1' => (10 + $skip)]);
		}else{
		$skip =10;
		session(['skip1' => 10]);
		}

		$companies = Company::skip($skip)
							->take(10)
    						->orderBy('created_at', 'desc')
							->Where('name', 'like', '%' .Session::get('search') . '%')
    						->get();

    	if($companies->isEmpty()){
    		return response(['status'=>'no_data']);
    	}else{

    		return response(['status'=>'success', 'companies'=>$companies]);
    	}
	 }
	 public function search_sms_by_phone(Request $request){
		session(['skip1' => 10]);
		session(['search' => $request->input('search')]);
		if (Auth::user()->company_id==0){
		$messages = TestMessage::skip(0)
							->take(10)
    						->orderBy('created_at', 'desc')
							->Where('phone', 'like', '%' .$request->input('search') . '%')
    						->get();
		}else{
		$messages = TestMessage::skip(0)
							->take(10)
    						->orderBy('created_at', 'desc')
							->Where('phone', 'like', '%' .$request->input('search') . '%')
    						->where('company_id',Auth::user()->company_id)
							->get();
		}
    	if($messages->isEmpty()){
    		return response(['status'=>'no_data']);
    	}else{

    		return response(['status'=>'success', 'messages'=>$messages]);
    	}
	 }
	 		public function search_more_sms_by_phone(Request $request){
		if(Session::has('skip1')){
		$skip = Session::get('skip1');
		session(['skip1' => (10 + $skip)]);
		}else{
		$skip =10;
		session(['skip1' => 10]);
		}


		if (Auth::user()->company_id==0){
		$messages = TestMessage::skip($skip)
							->take(10)
    						->orderBy('created_at', 'desc')
							->Where('phone', 'like', '%' .Session::get('search') . '%')
    						->get();
		}else{
		$messages = TestMessage::skip($skip)
							->take(10)
    						->orderBy('created_at', 'desc')
							->Where('phone', 'like', '%' .Session::get('search') . '%')
    						->where('company_id',Auth::user()->company_id)
							->get();
		}
    	if($messages->isEmpty()){
    		return response(['status'=>'no_data']);
    	}else{

    		return response(['status'=>'success', 'messages'=>$messages]);
    	}
	 }
}
