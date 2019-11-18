<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Company;
use App\Visitor;
use DateTime;
use DateInterval;
use App\SMSPayment;
use App\SenderIDPayment;
use Illuminate\Support\Facades\DB;
use Auth;
use Carbon\Carbon;
use App\Setting;
use App\TestMessage;
use App\User;
use App\SMSCredit;
use Session;
use App\SenderID;
class AnalyticsController extends Controller
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
	 public function analytics()
    {
		

		if(Auth::user()->admin==1 && Auth::user()->company_id==0){
		$companies = DB::select('SELECT distinct company_id FROM `test_messages`');
		foreach($companies as $company){
		 if($company->company_id!=0){

			$companyname=Company::where('id','=',$company->company_id)->first();
			$company->{'company'} = $companyname->name;
			}else{
			$company->{'company'} = 'Nodcomm';
			}
		}
			return view('analytics')->with('companies',$companies);
		} else if(Auth::user()->admin==1 && Auth::user()->company_id!=0){
			return view('company_analytics');
		}else if(Auth::user()->admin==0){
			return view('analytics');
		}
		
	}
	
		public function super_admin_analytics_data(){
		$currentMonth = date('m');
		$deliveredsms = TestMessage::whereRaw('MONTH(created_at) = ?  and status = ?',[$currentMonth,'sent'])
					->get();
		$undeliveredsms = TestMessage::whereRaw('MONTH(created_at) = ?  and status = ?',[$currentMonth,'fail'])
					->get();
		$newcompanies = Company::whereRaw('MONTH(created_at) = ?',[$currentMonth])
					->get();
		$newsmssales= SMSPayment::whereRaw('MONTH(created_at) = ?',[$currentMonth])
					->get();
		$newsenderidsales= SenderIDPayment::whereRaw('MONTH(created_at) = ?',[$currentMonth])
					->get();
		$sender_id_cost= SenderIDPayment::select(DB::raw("SUM(amount) as sum"))->first();
		if(!empty($sender_id_cost)){
			$sender_id = "KES ".$sender_id_cost->sum;
		}else{
			$sender_id = "KES 0";
		}
		$newvisitors= Visitor::whereRaw('MONTH(created_at) = ? and company = ?',[$currentMonth,0])
					->get();
		$now = new DateTime('now');
		// Create a date interval string to go back to the first day of the previous month
		$int = sprintf('P1M%dD', $now->format('j')-1);
		// Get the first day of the previous month as DateTime
		$fdopm = $now->sub(new DateInterval($int));
		// Verify it works
		//echo($fdopm->format('Y-m-d'));
	   $lastmonthdeliveredsms = TestMessage::whereRaw('MONTH(created_at) = ?  and status = ?',[$fdopm->format('m'),'sent'])
					->get();
	   $lastmonthundeliveredsms = TestMessage::whereRaw('MONTH(created_at) = ?  and status = ?',[$fdopm->format('m'),'fail'])
					->get();
		$lastmonthcompanies = Company::whereRaw('MONTH(created_at) = ?',[$fdopm->format('m')])
					->get();
		$diff=count($newcompanies)-count($lastmonthcompanies);
			if((count($lastmonthcompanies)==0) && (count($newcompanies)>0)){
			 $percentage=100; 
			 }else if(count($lastmonthcompanies)==count($newcompanies)){
			 $percentage=0;	 
			 }else{
			 $percentage=round(($diff/count($lastmonthcompanies))*(100));
			 }
			$deliveredsmsdiff=count($deliveredsms)-count($lastmonthdeliveredsms);
			if((count($lastmonthdeliveredsms)==0) && (count($deliveredsms)>0)){
			 $deliveredsmspercentage=100; 
			 }else if(count($lastmonthdeliveredsms)==count($deliveredsms)){
			 $deliveredsmspercentage=0;	 
			 }else{
			 $deliveredsmspercentage=round(($deliveredsmsdiff/count($lastmonthdeliveredsms))*(100));
			 }
		$undeliveredsmsdiff=count($undeliveredsms)-count($lastmonthundeliveredsms);
			if((count($lastmonthundeliveredsms)==0) && (count($undeliveredsms)>0)){
			 $undeliveredsmspercentage=100; 
			 }else if(count($lastmonthundeliveredsms)==count($undeliveredsms)){
			 $undeliveredsmspercentage=0;	 
			 }else{
			 $undeliveredsmspercentage=round(($undeliveredsmsdiff/count($lastmonthundeliveredsms))*(100));
			 }
		$lastmonthsmssales = SMSPayment::whereRaw('MONTH(created_at) = ?',[$fdopm->format('m')])
					->get();	
		$smssalesdiff=count($newsmssales)-count($lastmonthsmssales);
			if((count($lastmonthsmssales)==0) && (count($newsmssales)>0)){
			 $smssalespercentage=100; 
			 }else if(count($lastmonthsmssales)==count($newsmssales)){
			 $smssalespercentage=0;	 
			 }else{
			 $smssalespercentage=round(($smssalesdiff/count($lastmonthsmssales))*(100));
			 }
		$lastmonthsenderidsales = SenderIDPayment::whereRaw('MONTH(created_at) = ?',[$fdopm->format('m')])
					->get();	
		$senderidsalesdiff=count($newsenderidsales)-count($lastmonthsenderidsales);
			if((count($lastmonthsenderidsales)==0) && (count($newsenderidsales)>0)){
			 $senderidsalespercentage=100; 
			 }else if(count($lastmonthsenderidsales)==count($newsenderidsales)){
			 $senderidsalespercentage=0;	 
			 }else{
			 $senderidsalespercentage=round(($senderidsalesdiff/count($lastmonthsenderidsales))*(100));
			 }	
		$lastmonthvisitors = Visitor::whereRaw('MONTH(created_at) = ? and company = ?',[$fdopm->format('m'),0])
					->get();	
		$visitorsdiff=count($newvisitors)-count($lastmonthvisitors);
			if((count($lastmonthvisitors)==0) && (count($newvisitors)>0)){
			 $visitorssalespercentage=100; 
			 }else if(count($lastmonthvisitors)==count($newvisitors)){
			 $visitorssalespercentage=0;	 
			 }else{
			 $visitorssalespercentage=round(($visitorsdiff/count($lastmonthvisitors))*(100));
			 }
		$agents = User::where('admin',0)->where('company_id',0)->get();			 
		return response
		([
		'newcompanies'=>count($newcompanies), 
		'companiespercentage'=>$percentage,
		'deliveredsms'=>count($deliveredsms), 
		'deliveredsmspercentage'=>$deliveredsmspercentage,
		'undeliveredsms'=>count($undeliveredsms), 
		'undeliveredsmspercentage'=>$undeliveredsmspercentage,
		'newsmssales'=>count($newsmssales), 
		'smssalespercentage'=>$smssalespercentage,
		'newsenderidsales'=>count($newsenderidsales), 
		'senderidsalespercentage'=>$senderidsalespercentage,
		'newvisitors'=>count($newvisitors), 
		'visitorssalespercentage'=>$visitorssalespercentage,
		'sender_id_cost'=>$sender_id,
		'agents'=>count($agents),
		]);
	}
	 public function admin_analytics_data(){
		$currentMonth = date('m');
		$newcredits = DB::select('SELECT sum(credit) as sum, amount FROM `smspayment` where MONTH(created_at) = ? and company_id = ? and user_id = ?',[$currentMonth,Auth::user()->company_id,Auth::user()->id]);
		$sum = 0;
		$amount = 0;
		foreach($newcredits as $credit){
			$sum +=  floatval($credit->sum);
			$amount +=  floatval($credit->amount);
		}
		$sender_id_cost= SenderIDPayment::whereRaw('company_id = ? ',[Auth::user()->company_id])
					->first();
		if(!empty($sender_id_cost)){
			$sender_id = $sender_id_cost->currency." ".$sender_id_cost->amount;
		}else{
			$sender_id = "KES 0";
		}
		$agents = User::where('admin',0)->where('company_id',Auth::user()->company_id)->get();
		$newsmssent = TestMessage::whereRaw('MONTH(created_at) = ? and company_id = ?',[$currentMonth,Auth::user()->company_id])
					->get();
		$deliveredsms = TestMessage::whereRaw('MONTH(created_at) = ? and company_id = ? and status = ?',[$currentMonth,Auth::user()->company_id,'sent'])
					->get();
		$undeliveredsms = TestMessage::whereRaw('MONTH(created_at) = ? and company_id = ? and status = ?',[$currentMonth,Auth::user()->company_id,'fail'])
					->get();
		$newvisitors= Visitor::whereRaw('MONTH(created_at) = ? and company = ?',[$currentMonth,Auth::user()->company_id])
					->get();
		$now = new DateTime('now');
		// Create a date interval string to go back to the first day of the previous month
		$int = sprintf('P1M%dD', $now->format('j')-1);
		// Get the first day of the previous month as DateTime
		$fdopm = $now->sub(new DateInterval($int));
		// Verify it works
		//echo($fdopm->format('Y-m-d'));

		$lastmonthsmssent = TestMessage::whereRaw('MONTH(created_at) = ? and company_id = ?',[$fdopm->format('m'),Auth::user()->company_id])
					->get();
		$lastmonthdeliveredsms = TestMessage::whereRaw('MONTH(created_at) = ? and company_id = ? and status = ?',[$fdopm->format('m'),Auth::user()->company_id,'sent'])
					->get();
	    $lastmonthundeliveredsms = TestMessage::whereRaw('MONTH(created_at) = ? and company_id = ? and status = ?',[$fdopm->format('m'),Auth::user()->company_id,'fail'])
					->get();
		$diff=count($newsmssent)-count($lastmonthsmssent);
			if((count($lastmonthsmssent)==0) && (count($newsmssent)>0)){
			 $percentage=100; 
			 }else if(count($lastmonthsmssent)==count($newsmssent)){
			 $percentage=0;	 
			 }else{
			 $percentage=round(($diff/count($lastmonthsmssent))*(100));
			 }
		$deliveredsmsdiff=count($deliveredsms)-count($lastmonthdeliveredsms);
			if((count($lastmonthdeliveredsms)==0) && (count($deliveredsms)>0)){
			 $deliveredsmspercentage=100; 
			 }else if(count($lastmonthdeliveredsms)==count($deliveredsms)){
			 $deliveredsmspercentage=0;	 
			 }else{
			 $deliveredsmspercentage=round(($deliveredsmsdiff/count($lastmonthdeliveredsms))*(100));
			 }
		$undeliveredsmsdiff=count($undeliveredsms)-count($lastmonthundeliveredsms);
			if((count($lastmonthundeliveredsms)==0) && (count($undeliveredsms)>0)){
			 $undeliveredsmspercentage=100; 
			 }else if(count($lastmonthundeliveredsms)==count($undeliveredsms)){
			 $undeliveredsmspercentage=0;	 
			 }else{
			 $undeliveredsmspercentage=round(($undeliveredsmsdiff/count($lastmonthundeliveredsms))*(100));
			 }
		$lastmonthvisitors = Visitor::whereRaw('MONTH(created_at) = ? and company = ?',[$fdopm->format('m'),Auth::user()->company_id])
					->get();	
		$visitorsdiff=count($newvisitors)-count($lastmonthvisitors);
			if((count($lastmonthvisitors)==0) && (count($newvisitors)>0)){
			 $visitorssalespercentage=100; 
			 }else if(count($lastmonthvisitors)==count($newvisitors)){
			 $visitorssalespercentage=0;	 
			 }else{
			 $visitorssalespercentage=round(($visitorsdiff/count($lastmonthvisitors))*(100));
			 }	
		$lastcredits = DB::select('SELECT sum(credit) as sum, amount FROM `smspayment` where MONTH(created_at) = ? and company_id = ? and user_id = ?',[$fdopm->format('m'),Auth::user()->company_id,Auth::user()->id]);
		$sum1 = 0;
		$amount1 = 0;
		foreach($lastcredits as $credit1){
			$sum1 +=  floatval($credit1->sum);
			$amount1 +=  floatval($credit1->amount);
		}	
		$creditdiff=$sum-$sum1;
		$amountdiff=$amount-$amount1;
			 if(($sum1 == 0) && ($sum > 0)){
			 $creditpercentage=100; 
			 }else if($sum1==$sum){
			 $creditpercentage=0;	 
			 }else{
			 $creditpercentage=round(($creditdiff/$sum1)*(100));
			 }	
			 
			 if(($amount1 == 0) && ($amount > 0)){
			 $amountpercentage=100; 
			 }else if($amount1==$amount){
			 $amountpercentage=0;	 
			 }else{
			 $amountpercentage=round(($amountdiff/$amount1)*(100));
			 }	
		return response
		([
		'newsmssent'=>count($newsmssent), 
		'agents'=>count($agents), 
		'smssentpercentage'=>$percentage,
		'deliveredsms'=>count($deliveredsms), 
		'deliveredsmspercentage'=>$deliveredsmspercentage,
		'undeliveredsms'=>count($undeliveredsms), 
		'undeliveredsmspercentage'=>$undeliveredsmspercentage,
		'newvisitors'=>count($newvisitors), 
		'visitorssalespercentage'=>$visitorssalespercentage,
		'newcredit'=>$sum, 
		'creditpercentage'=>$creditpercentage,
		'sender_id_cost'=>$sender_id,
		'newamount'=>$amount, 
		'amountpercentage'=>$amountpercentage,
		]);
	}
	public function visitors(){
		 $countries = DB::select('SELECT distinct country, latitude, longitude FROM `visitors` where company = ? ',[Auth::user()->company_id]);
		
		foreach($countries as $country){
			 $count = DB::select('SELECT count(*) as count FROM `visitors` where country = ? ',[$country->country]);
			 $country->{'count'} = $count[0]->count;
		}
		return response(array('countries'=>$countries));
	}

	public function companies_graph()
    {
		function lastSixMonths() {
			return [
				date('F', strtotime('-5 month')),
				date('F', strtotime('-4 month')),
				date('F', strtotime('-3 month')),
				date('F', strtotime('-2 month')),
				date('F', strtotime('-1 month')),
				date('F', time())
			];
		}
		$currentMonth = date('F');
		$months = [];
		$count = [];
	   foreach(lastSixMonths() as $month){
			$credit = Company::whereMonth('created_at', '=', date('m', strtotime($month)))
              ->count('*');
			$count [] = $credit;
			$months [] = $month;
		}
		return response(array('data'=>$count, 'labels'=>$months));
	}
		public function sms_profit()
    {
		function lastSixMonths() {
			return [
				date('F', strtotime('-5 month')),
				date('F', strtotime('-4 month')),
				date('F', strtotime('-3 month')),
				date('F', strtotime('-2 month')),
				date('F', strtotime('-1 month')),
				date('F', time())
			];
		}
		$currentMonth = date('F');
		$months = [];
		$count = [];
		$sms_credit_purchase_price = Setting::where('config_key','sms_credit_purchase_price')->first()->config_value;
		$sms_credit_amount = Setting::where('config_key','sms_credit_amount')->first()->config_value;
		$profit = $sms_credit_amount - $sms_credit_purchase_price;
	   foreach(lastSixMonths() as $month){
			$credit = SMSPayment::whereMonth('created_at', '=', date('m', strtotime($month)))
              ->sum('credit');
			$revenue = $profit * $credit;
			$count [] = $revenue/100;
			$months [] = $month;
		}
		return response(array('data'=>$count, 'labels'=>$months));
	}
			public function visitors_graph()
    {
		function lastSixMonths() {
			return [
				date('F', strtotime('-5 month')),
				date('F', strtotime('-4 month')),
				date('F', strtotime('-3 month')),
				date('F', strtotime('-2 month')),
				date('F', strtotime('-1 month')),
				date('F', time())
			];
		}
		$currentMonth = date('F');
		$months = [];
		$count = [];
	   foreach(lastSixMonths() as $month){
			$credit = Visitor::where('company','=',Auth::user()->company_id)->whereMonth('created_at', '=', date('m', strtotime($month)))
              ->count('*');
			$count [] = $credit;
			$months [] = $month;
		}
		return response(array('data'=>$count, 'labels'=>$months));
	}
		public function sms_revenue()
    {
		function lastSixMonths() {
			return [
				date('F', strtotime('-5 month')),
				date('F', strtotime('-4 month')),
				date('F', strtotime('-3 month')),
				date('F', strtotime('-2 month')),
				date('F', strtotime('-1 month')),
				date('F', time())
			];
		}
		$currentMonth = date('F');
		$months = [];
		$count = [];
	   foreach(lastSixMonths() as $month){
			$credit = SMSPayment::whereMonth('created_at', '=', date('m', strtotime($month)))
              ->sum('credit');
			$count [] = $credit;
			$months [] = $month;
		}
		return response(array('data'=>$count, 'labels'=>$months));
	}
		/*public function sender_id_revenue()
    {
		$currentMonth = date('F');
		$months = [];
		$count = [];
		$sender_id_purchase_price = Setting::where('config_key','sender_id_purchase_price')->first()->config_value;
		$sender_id_cost = Setting::where('config_key','sender_id_cost')->first()->config_value;
		$profit = $sender_id_cost - $sender_id_purchase_price;
	    $credits = DB::select('SELECT distinct MONTHNAME(`created_at`) as month, count(*) as count FROM `sender_id_payment` where `created_at` >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)  group by MONTHNAME(`created_at`) order by `created_at` ASC');
		foreach($credits as $credit){
			$count [] = $profit * $credit->count;
			$months [] = $credit->month;
		}
		if(!empty($count) && !empty($months)){
		return response(array('data'=>$count, 'labels'=>$months));
		}else{
		$count [] = 0;
		$months [] = $currentMonth ;
		return response(array('data'=>$count, 'labels'=>$months));	
		}
	}*/
	public function sender_id_revenue()
    {
		function lastSixMonths() {
			return [
				date('F', strtotime('-5 month')),
				date('F', strtotime('-4 month')),
				date('F', strtotime('-3 month')),
				date('F', strtotime('-2 month')),
				date('F', strtotime('-1 month')),
				date('F', time())
			];
		}
		$currentMonth = date('F');
		$months = [];
		$count = [];
	   foreach(lastSixMonths() as $month){
			$credit = SenderID::whereMonth('created_at', '=', date('m', strtotime($month)))
              ->sum('credit');
			$count [] = $credit;
			$months [] = $month;
		}
		return response(array('data'=>$count, 'labels'=>$months));
	}
	/*public function sent_sms()
    {
		$currentMonth = date('F');
	    $sms = DB::select('SELECT distinct MONTHNAME(`created_at`) as month, count(*) as count FROM `test_messages` where `created_at` >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH) and company_id = ? and sent_by = ? group by MONTHNAME(`created_at`) order by `created_at` ASC',[Auth::user()->company_id,Auth::user()->id]);
		$months = [];
		$count = [];
		foreach($sms as $sm){
			$count [] = $sm->count;
			$months [] = $sm->month;
		}
		if(!empty($count) && !empty($months)){
		return response(array('data'=>$count, 'labels'=>$months));
		}else{
		$count [] = 0;
		$months [] = $currentMonth ;
		return response(array('data'=>$count, 'labels'=>$months));	
		}
	}*/
		public function sent_sms()
    {
		function lastSixMonths() {
			return [
				date('F', strtotime('-5 month')),
				date('F', strtotime('-4 month')),
				date('F', strtotime('-3 month')),
				date('F', strtotime('-2 month')),
				date('F', strtotime('-1 month')),
				date('F', time())
			];
		}
		$currentMonth = date('F');
		$months = [];
		$count = [];
	   foreach(lastSixMonths() as $month){
			$credit = TestMessage::whereMonth('created_at', '=', date('m', strtotime($month)))
              ->sum('recipients');
			$count [] = $credit;
			$months [] = $month;
		}
		return response(array('data'=>$count, 'labels'=>$months));
	}
		public function SMSs(){
		 $companies = DB::select('SELECT distinct company_id FROM `test_messages`');
		foreach($companies as $company){
		 if($company->company_id!=0){

			$companyname=Company::where('id','=',$company->company_id)->first();
			$company->{'company'} = $companyname->name;
			}else{
			$company->{'company'} = 'Nodcomm';
			}
			 $count = DB::select('SELECT count(*) as count FROM `test_messages` where company_id = ? ',[$company->company_id]);
			 $company->{'sms_count'} = $count[0]->count;
			 $credit= SMSCredit::whereRaw('company_id = ? ',[$company->company_id])
					->first();
			if(!empty($credit)){
			 $company->{'credit'}= $credit->credit;
			}else{
				$company->{'credit'}= 0;
			}
			
		$totalcredits = DB::select('SELECT sum(credit) as sum, sum(amount) as amount_sum FROM `smspayment` where  company_id = ? ',[$company->company_id]);
		$sum = 0;
		$amount = 0;
		foreach($totalcredits as $tcredit){
			$sum +=  floatval($tcredit->sum);
			$amount +=  floatval($tcredit->amount_sum);
		}
		$company->{'total_credit'}= $sum;
		$company->{'credit_amount'}= $amount;
		}
		//dd($companies);
		return response(array('companies'=>$companies));
	}
	 public function search_sms(Request $request){
		if($request->search==''){
		 return response(['status'=>'error', 'details'=>"Please select a company "]);
		}else{
		session(['skip1' => 10]);
		session(['search' => $request->input('search')]);
		$messages = TestMessage::skip(0)
							->take(10)
    						->orderBy('created_at', 'desc')
							->where('company_id', 'like', '%' .$request->input('search') . '%')
							->get();
		
    	if($messages->isEmpty()){
    		return response(['status'=>'no_data']);
    	}else{
    		return response(['status'=>'success', 'messages'=>$messages]);
    	}
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

		$messages = TestMessage::skip($skip)
							->take(10)
    						->orderBy('created_at', 'desc')
							->Where('company_id', 'like', '%' .Session::get('search') . '%')
    						->get();

    	if($messages->isEmpty()){
    		return response(['status'=>'no_data']);
    	}else{
    		return response(['status'=>'success', 'messages'=>$messages]);
    	}
	 }
	 	 public function search_time_sms(Request $request){
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
			session(['skip1' => 10]);
			session(['search' => $request->input('time_search')]);
			if($request->input('time_search')==1){
				$messages = TestMessage::skip(0)->take(10)->whereDate('created_at', Carbon::today())->orderBy('created_at', 'desc')->get();
			}else if($request->input('time_search')==2){
				$messages = TestMessage::skip(0)->take(10)->whereBetween('created_at', [$monday, $sunday])->orderBy('created_at', 'desc')->get();
			}else if($request->input('time_search')==3){
				$messages = TestMessage::skip(0)->take(10)->whereBetween('created_at', [$monday1, $sunday1])->orderBy('created_at', 'desc')->get();
			}else if($request->input('time_search')==4){
				$messages = TestMessage::skip(0)->take(10)->whereRaw('MONTH(created_at) = ?',[$currentMonth])->get();
			}else if($request->input('time_search')==5){
				$messages = TestMessage::skip(0)->take(10)->whereRaw('MONTH(created_at) = ?',[$fdopm->format('m')])->get();
			}
			
			if($messages->isEmpty()){
				return response(['status'=>'no_data']);
			}else{
				return response(['status'=>'success', 'messages'=>$messages]);
			}
		 }
	 }
	 	 	public function load_time_search_more(Request $request){
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
			if(Session::has('skip1')){
			$skip = Session::get('skip1');
			session(['skip1' => (10 + $skip)]);
			}else{
			$skip =10;
			session(['skip1' => 10]);
			}
			if(Session::get('search')==1){
				$messages = TestMessage::skip($skip)->take(10)->whereDate('created_at', Carbon::today())->orderBy('created_at', 'desc')->get();
			}else if(Session::get('search')==2){
				$messages = TestMessage::skip($skip)->take(10)->whereBetween('created_at', [$monday, $sunday])->orderBy('created_at', 'desc')->get();
			}else if(Session::get('search')==3){
				$messages = TestMessage::skip($skip)->take(10)->whereBetween('created_at', [$monday1, $sunday1])->orderBy('created_at', 'desc')->get();
			}else if(Session::get('search')==4){
				$messages = TestMessage::skip($skip)->take(10)->whereRaw('MONTH(created_at) = ?',[$currentMonth])->get();
			}else if(Session::get('search')==5){
				$messages = TestMessage::skip($skip)->take(10)->whereRaw('MONTH(created_at) = ?',[$fdopm->format('m')])->get();
			}
    	if($messages->isEmpty()){
    		return response(['status'=>'no_data']);
    	}else{
    		return response(['status'=>'success', 'messages'=>$messages]);
    	}
	 }
	 	 	 public function analytics_search_sender_time_sms(Request $request){
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
			session(['skip1' => 10]);
			session(['search' => $request->input('time_search')]);
			if($request->input('time_search')==1){
				$messages = SenderIDPayment::skip(0)->take(10)->whereDate('created_at', Carbon::today())->orderBy('created_at', 'desc')->get();
			}else if($request->input('time_search')==2){
				$messages = SenderIDPayment::skip(0)->take(10)->whereBetween('created_at', [$monday, $sunday])->orderBy('created_at', 'desc')->get();
			}else if($request->input('time_search')==3){
				$messages = SenderIDPayment::skip(0)->take(10)->whereBetween('created_at', [$monday1, $sunday1])->orderBy('created_at', 'desc')->get();
			}else if($request->input('time_search')==4){
				$messages = SenderIDPayment::skip(0)->take(10)->whereRaw('MONTH(created_at) = ?',[$currentMonth])->get();
			}else if($request->input('time_search')==5){
				$messages = SenderIDPayment::skip(0)->take(10)->whereRaw('MONTH(created_at) = ?',[$fdopm->format('m')])->get();
			}
			
			if($messages->isEmpty()){
				return response(['status'=>'no_data']);
			}else{
				foreach($messages as $credit){
				if($credit->company_id==0){
				$credit->{'company'} = 'Nodcomm';
				}else{
				$credit->{'company'} = Company::where('id','=',$credit->company_id)->first()->name;
					
				}
				$credit->{'user'} = User::where('id','=',$credit->user_id)->first();
				}
				return response(['status'=>'success', 'messages'=>$messages]);
			}
		 }
	 }
		 	public function load_senderid_search_more(Request $request){
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
			if(Session::has('skip1')){
			$skip = Session::get('skip1');
			session(['skip1' => (10 + $skip)]);
			}else{
			$skip =10;
			session(['skip1' => 10]);
			}
			if(Session::get('search')==1){
				$messages = SenderIDPayment::skip($skip)->take(10)->whereDate('created_at', Carbon::today())->orderBy('created_at', 'desc')->get();
			}else if(Session::get('search')==2){
				$messages = SenderIDPayment::skip($skip)->take(10)->whereBetween('created_at', [$monday, $sunday])->orderBy('created_at', 'desc')->get();
			}else if(Session::get('search')==3){
				$messages = SenderIDPayment::skip($skip)->take(10)->whereBetween('created_at', [$monday1, $sunday1])->orderBy('created_at', 'desc')->get();
			}else if(Session::get('search')==4){
				$messages = SenderIDPayment::skip($skip)->take(10)->whereRaw('MONTH(created_at) = ?',[$currentMonth])->get();
			}else if(Session::get('search')==5){
				$messages = SenderIDPayment::skip($skip)->take(10)->whereRaw('MONTH(created_at) = ?',[$fdopm->format('m')])->get();
			}
    	if($messages->isEmpty()){
    		return response(['status'=>'no_data']);
    	}else{
				foreach($messages as $credit){
				if($credit->company_id==0){
				$credit->{'company'} = 'Nodcomm';
				}else{
				$credit->{'company'} = Company::where('id','=',$credit->company_id)->first()->name;
					
				}
				$credit->{'user'} = User::where('id','=',$credit->user_id)->first();
				}
    		return response(['status'=>'success', 'messages'=>$messages]);
    	}
	 } 
	 	 public function search_senderid_by_name(Request $request){
		session(['skip1' => 10]);
		session(['search' => $request->input('search')]);

		$messages = SenderIDPayment::skip(0)
							->take(10)
    						->orderBy('created_at', 'desc')
							->Where('sender_id', 'like', '%' .$request->input('search') . '%')
    						->get();

    	if($messages->isEmpty()){
    		return response(['status'=>'no_data']);
    	}else{
			foreach($messages as $credit){
				if($credit->company_id==0){
				$credit->{'company'} = 'Nodcomm';
				}else{
				$credit->{'company'} = Company::where('id','=',$credit->company_id)->first()->name;
					
				}
				$credit->{'user'} = User::where('id','=',$credit->user_id)->first();
				}
    		return response(['status'=>'success', 'messages'=>$messages]);
    	}
	 }
	 	 public function load_sendderid_by_name_search_more(Request $request){
		if(Session::has('skip1')){
		$skip = Session::get('skip1');
		session(['skip1' => (10 + $skip)]);
		}else{
		$skip =10;
		session(['skip1' => 10]);
		}

		$messages = SenderIDPayment::skip($skip)
							->take(10)
    						->orderBy('created_at', 'desc')
							->Where('sender_id', 'like', '%' .Session::get('search') . '%')
    						->get();

    	if($messages->isEmpty()){
    		return response(['status'=>'no_data']);
    	}else{
				foreach($messages as $credit){
				if($credit->company_id==0){
				$credit->{'company'} = 'Nodcomm';
				}else{
				$credit->{'company'} = Company::where('id','=',$credit->company_id)->first()->name;
					
				}
				$credit->{'user'} = User::where('id','=',$credit->user_id)->first();
				}
    		return response(['status'=>'success', 'messages'=>$messages]);
    	}
	 }
}
