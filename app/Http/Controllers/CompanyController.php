<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Company;
use App\Setting;
use App\Website;
use Auth;
use App\User;
use RandomLib\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Mandrill;
use Session;
use App\Notification;
class CompanyController extends Controller
{
			private $notification ;

		    public function __construct()
			  {
				  $this->notification = new Notification();
			  }
				public function index()
			{

			$Company= Company::where('phone',Session::get('phone'))->first();


			if((!empty($Company) && $Company->step==1 && !empty($Company->code) ) && Session::has('step1'))
			{
			$data = array(
			'phone'=>Session::get('obscured_phone')
			);
			return redirect()->route('step_2')->with($data);
			}
			elseif((!empty($Company) && $Company->step==2 && !empty($Company->code) ) && Session::has('step2'))
			{
			$data = array(
			'phone'=>Session::get('phone')
			);

			return redirect()->route('step_3')->with($data);
			}elseif((!empty($Company) && $Company->step==3 && !empty($Company->code) ) && Session::has('step3'))
			{
			$data = array(
			'email'=>Session::get('email')
			);
			return redirect()->route('step_4')->with($data);
			}else{
//	 return view('registration_step1');
			return view('register1');
			}

			}
			public function step2()
			{
			$Company= Company::where('phone',Session::get('phone'))->first();

			if((!empty($Company) && $Company->step==1 && !empty($Company->code) ) && Session::has('step1'))
			{
			$data = array(
			'phone'=>Session::get('obscured_phone')
			);
			//return view('registration_step2')->with($data);
              return view('register3')->with($data);
			}
			elseif((!empty($Company) && $Company->step==2 && !empty($Company->code) )&& Session::has('step2'))
			{
			$data = array(
			'phone'=>Session::get('phone')
			);
			return redirect()->route('step_3')->with($data);
			}elseif((!empty($Company) && $Company->step==3 && !empty($Company->code) ) && Session::has('step3'))
			{
			$data = array(
			'email'=>Session::get('email')
			);
			return redirect()->route('step_4')->with($data);
			}else{
			return redirect()->route('step_1');
			}

			}
			public function step3()
			{
			$Company= Company::where('phone',Session::get('phone'))->first();
			if((!empty($Company) && $Company->step==1 && !empty($Company->code) ) && Session::has('step1'))
			{
			$data = array(
			'phone'=>Session::get('obscured_phone')
			);
			return redirect()->route('step_2')->with($data);
			}
			elseif((!empty($Company) && $Company->step==2) && Session::has('step2'))
			{
			$data = array(
			'phone'=>Session::get('phone')
			);

//			return view('registration_step3')->with($data);
                return view('register2')->with($data);
			}elseif((!empty($Company) && $Company->step==3 && !empty($Company->code) ) && Session::has('step3'))
			{
			$data = array(
			'email'=>Session::get('email')
			);
			return redirect()->route('step_4')->with($data);
			}else{
			return redirect()->route('step_1');
			}
			}
		     public function step4()
			{

			$Company= Company::where('email',Session::get('email'))->first();

			if((!empty($Company) && $Company->step==1 && !empty($Company->code) ) && Session::has('step1'))
			{
			$data = array(
			'phone'=>Session::get('obscured_phone')
			);
			return redirect()->route('step_2')->with($data);
			}
			elseif((!empty($Company) && $Company->step==2 && !empty($Company->code) ) && Session::has('step2'))
			{
			$data = array(
			'phone'=>Session::get('phone')
			);
			return redirect()->route('step_3')->with($data);
			}elseif((!empty($Company) && $Company->step==3 && !empty($Company->code) ) && Session::has('step3'))
			{
			$data = array(
			'email'=>Session::get('email')
			);
			return view('registration_step4')->with($data);

			}else{
			return redirect()->route('step_1');
			}

			}
		    public function registercompany(Request $request){

        try{
			$factory = new Factory;
			$generator = $factory->getLowStrengthGenerator();
			$code = $generator->generateString(6, '123456789');
			$api_id = $generator->generateString(32, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
           	$api_key = $generator->generateString(32, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
			$final_code=substr($code, 0, 3) . "-" . substr($code, -3);
			$smsno = str_replace("+","",$request->input('phone'));
			$existingcompany=Company::where('phone', '=', $request->input('phone'));

			if($request->telno==''){
				return response(['status'=>'error', 'details'=>"Please enter your Mobile Number."]);
			}
		    else if ($existingcompany->count() > 0 && User::where('phone', '=', $request->input('phone'))->count() > 0 && $existingcompany->first()->step==1) {
			$replace = array( '+', '-', "[verification_code]" );
			$replace_by = array( "", "", $final_code );

			$msg = Setting::where('config_key','phone_no_verification_msg')->first()->config_value;
			$sms_message = str_replace( $replace, $replace_by, $msg );

			if($this->notification->send_sms($smsno,$sms_message,'Nodcomm')==true){
			$company = Company::find($existingcompany->first()->id);
			$company->confirmed =0;
			$company->code =$code;
			$company->code_expiry_time = time();
			$company->save();
			session(['user_id' => User::where('phone', '=', $request->input('phone'))->first()->id]);
			session(['phone' => $request->input('phone')]);
			session(['obscured_phone' => substr($request->input('phone'), 0, 5) . "****" . substr($request->input('phone'), -3)]);
			session(['step1' => 1]);
			return response(['status'=>'success','details'=>url('/register/step2'),'code'=>$code,'api_id'=>$api_id,'api_key'=>$api_key,'step1'=>'exists']);
			}else{
			return response(['status'=>'error', 'details'=>'An error occurred, please try again.']);
			}
			}else if ($existingcompany->count() > 0 && User::where('phone', '=', $request->input('phone'))->count() > 0 && $existingcompany->first()->step==2) {
				session(['step2' => 2]);
				session(['phone' => $request->input('phone')]);
				Session::forget('step1');
				return response(['status'=>'success','details'=>url('/register/step3'),'phone'=>$request->input('phone')]);
			}else if ($existingcompany->count() > 0 && User::where('phone', '=', $request->input('phone'))->count() > 0 && $existingcompany->first()->step==3) {
			// if($this->notification->sendMailMandrill( $existingcompany->first()->email, $this->emailtemplate($existingcompany->first()->fname." ".$existingcompany->first()->lname, $final_code),'Company Account Creation Email','Nodcomm Company Account Creation ')){
				if(true){

			$company = Company::find($existingcompany->first()->id);
			$company->confirmed =0;
			$company->code =$code;
			$company->code_expiry_time = time();
			$company->save();
            session(['step3' => 3]);
			session(['email' => $existingcompany->first()->email]);

			Session::forget('obscured_phone');
			Session::forget('phone');
			Session::forget('step2');
			return response(['status'=>'success','details'=>url('/register/step4'),'code'=>$code,'phone'=>$existingcompany->first()->phone,'step3'=>'exists']);
			}else{
			return response(['status'=>'error', 'details'=>'An error occurred, please try again.']);
			}
			}else if ($existingcompany->count() > 0 && User::where('phone', '=', $request->input('phone'))->count() > 0 && $existingcompany->first()->step==4) {

				return response(['status'=>'account_exists','details'=>url('/login')]);
			}

			else{
			$obscured_phone = substr($request->input('phone'), 0, 5) . "****" . substr($request->input('phone'), -3);
			$replace = array( '+', '-', "[verification_code]" );
			$replace_by = array( "", "", $final_code );

			$msg = Setting::where('config_key','phone_no_verification_msg')->first()->config_value;
			$sms_message = str_replace( $replace, $replace_by, $msg );

			if($this->notification->send_sms($smsno,$sms_message,'Nodcomm')==true){

			$ip = $request->input('ip');
			$geolocation = json_decode(@file_get_contents("http://ip-api.com/json/{$ip}"));
			if(!empty($geolocation)){
				$country = json_decode(@file_get_contents("https://restcountries.eu/rest/v2/alpha/{$geolocation->countryCode}"));
			}else{
				$geolocation = new stdClass;
				$geolocation->city = '-';
				$geolocation->regionName = '-';
				$geolocation->country = '-';
				$geolocation->lat = '-';
				$geolocation->lon = '-';
			}
			if(empty($ip)){
				$ip = 'Unknown';
			}
			if(empty($country)){
				$country = new stdClass;
				$country->flag = '-';
			}
			$company = new Company;
		    $company->country = $request->input('country_name');
            $company->phone = $request->input('phone');
			$company->api_id =$api_id;
			$company->step =1;
			$company->api_key =$api_key;
			$company->code_expiry_time = time();
            $company->code =$code;
			$company->city = $geolocation->city;
            $company->region = $geolocation->regionName;
            $company->flag = $country->flag;
            $company->country = $geolocation->country;
			$company->latitude = $geolocation->lat;
			$company->longitude = $geolocation->lon;
			$company->active =1;
			$company->ip = $ip;
			$company->save();

			$user = new User;
			$user->company_id = $company->id;
			$user->admin=1;
			$user->phone = $request->input('phone');
			$user->active =1;
			$user->save();

			session(['user_id' => $user->id]);
			session(['phone' => $request->input('phone')]);
			session(['obscured_phone' => $obscured_phone]);
			session(['step1' => 1]);
			return response(['status'=>'success','details'=>url('/register/step2'),'code'=>$code,'api_id'=>$api_id,'api_key'=>$api_key,'step1'=>'no','user_id'=>$user->id,'company_id'=>$company->id]);
			}else{
			return response(['status'=>'error', 'details'=>'An error occurred, please try again.ttttt']);
			}
			}
        }catch(Exception $e){
            return response(['status'=>'error']);
        }

    }
	    public function addcompany(Request $request){

        try{
			if($request->name==''){
				return response(['status'=>'error', 'details'=>"Please enter the company name"]);
			}
			else if($request->fname==''){
				return response(['status'=>'error', 'details'=>"Please enter your First Name"]);
			}
			else if($request->lname==''){
				return response(['status'=>'error', 'details'=>"Please enter your Last Name"]);
			}
			else if($request->email==''){
				return response(['status'=>'error', 'details'=>"Please enter your email"]);
			}
			else if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
				return response(['status'=>'error', 'details'=>"Please enter a valid email"]);
			}
			else if (Company::where('email', '=', $request->input('email'))->count() > 0) {
 				return response(['status'=>'error', 'details'=>"This email exists"]);
			}
			else if (User::where('email', '=', $request->input('email'))->count() > 0) {
 				return response(['status'=>'error', 'details'=>"This email exists"]);
			}else if($request->address==''){
                return response(['status'=>'error', 'details'=>"Please enter an address"]);
            }
			else if($request->password==''){
				return response(['status'=>'error', 'details'=>"Please enter your password"]);
			}else if($request->password1==''){
				return response(['status'=>'error', 'details'=>"Please confirm your password"]);
			}else if($request->password1!=$request->password){
				return response(['status'=>'error', 'details'=>"Your passwords do not match"]);
			}
			else{
			$factory = new Factory;
			$generator = $factory->getLowStrengthGenerator();
			$code = $generator->generateString(6, '123456789');
			$final_code=substr($code, 0, 3) . "-" . substr($code, -3);
//			if($this->notification->sendMailMandrill($request->input('email'), $this->emailtemplate($request->input('fname')." ".$request->input('lname'), $final_code),'Company Account Creation Email','Nodcomm Company Account Creation ')){
			if(true){
                $password=Hash::make($request->input('password'));
			$Company1= Company::where('phone',Session::get('phone'))->first();

			$company = Company::find($Company1->id);
            $company->name = $request->input('name');
            $company->email = $request->input('email');
			$company->address = $request->input('address');
			$company->lname = $request->input('lname');
            $company->fname = $request->input('fname');
			$company->step =3;
			$company->confirmed =0;
			$company->code =$code;
			$company->code_expiry_time = time();

			$company->save();
			$user1 = User::where('phone',$request->input('phone'))->first();
			//$user = User::find($user1->id);
            $user->name = $request->input('fname')." ".$request->input('lname');
			$user->admin=1;
            $user->email = $request->input('email');
			$user->address = $request->input('address');
			$user->password = $password;
			$user->save();

            session(['step3' => 3]);
			session(['email' => $request->input('email')]);
			Session::forget('obscured_phone');
			Session::forget('phone');
			Session::forget('step2');
			return response(['status'=>'success','details'=>url('/register/step4'),'phone'=>$request->input('phone'),'code'=>$code,'password'=>$password,'step3'=>'no']);
			}else{
			return response(['status'=>'error', 'details'=>'An error occurred, please try again.']);
			}
			}
        }catch(Exception $e){
            return response(['status'=>'error']);
        }

    }

    public function emailtemplate($username, $code) {
        $html = '<!DOCTYPE html>
                    <html>

                    <head>
                        <title></title>
                        <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet" type="text/css"/>
                        <style type="text/css">
                            body {
                                font-family: ‘Lobster’, Arial, sans-serif;
                                font-weight: 400;
                                font-size: 14px;
                            }
                        </style>
                    </head>

                    <body style="">
                        <div style="height:20px;"></div>
                        <table cellpadding="0" cellspacing="0" style="width:320px; border-radius: 4px;overflow: hidden;background-color: #E8E8E8 ; border-collapse: collapse;  margin:0px auto; border: 1px solid #ccc; ">
                            <tr>
                                <td style="text-align: center; padding: 10px; border-bottom:2px solid #037caa; "><img style="width: 80%;" src="' . url('/images/Nodcomm.png'). '" alt="Company Logo"/>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px; background-color:#fff; ">
                                    <h3 style="color: #037caa">Account Creation Confirmation</h3> 
                                    <h4>Dear '.$username.',</h4>
                                    <p>
                                   Welcome to Nodcomm. Please use the verification code below to complete your registration.
                                    </p>
                                    <p>
                                     <div><span><h4 style="display:inline">Verification Code: </h4></span><span>'.$code.' </span></div>
                                    </p>
                                    <p>Regards,</p>
                                    <p>Nodcomm</p>
                                </td>
                            </tr>
                            <tr>
                                <td style=" text-align: center; color: #000; padding: 10px;">

                                    © ' . date( "Y" ) . ' ' . ' Nodcomm / Terms & Conditions / Privacy Notice</td>
                            </tr>
                        </table>

                    </body>

                    </html>
                    ';
        return $html;
    }
	   	public function confirmemail(Request $request){

		$Company= Company::where('code',$request->code);
		if($Company->get()->isEmpty()){
			return response(['status'=>'error', 'details'=>"Please use the  code sent to your email"]);
		}else{
        $user = User::where('email',$Company->first()->email)->first();
	   try{
		    if($request->code==''){
				return response(['status'=>'error', 'details'=>"Please enter a code"]);
			}else if($Company->first()->confirmed==1){
				return response(['status'=>'error', 'details'=>"This code has expired."]);
			}
			else{
			 if($Company->count()>0){
				$code = Company::find($Company->first()->id);
				$code->confirmed =1;
				$code->save();

				Session::forget('step3');
				Session::forget('email');
				Auth::login($user);

				return response(['status'=>'success','details'=>url('/')]);

			}else{
				return response(['status'=>'error', 'details'=>"Please enter the code sent to you"]);
			}

			}
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
		}
    }

	public function login($id)
    {
			$email = Company::find($id)->email;
			$user = User::where('email',$email)->first();
			session(['previouslogin' => Auth::user()]);
			Auth::login($user);

			return redirect('/');
	}
		public function back()
    {
			Auth::login(Session::get('previouslogin'));
			Session::forget('previouslogin');
			return redirect('/');
	}
	public function verify_code(Request $request){

		$part1 = $request->input('code1');
		$part2 = $request->input('code2');
		$part3 = $request->input('code3');
		$part4 = $request->input('code4');
		$part5 = $request->input('code5');
		$part6 = $request->input('code6');

		if($part1!='' && $part2!='' && $part3!='' && $part4!='' && $part5!='' && $part6!=''){

			$code = $part1 . $part2 . $part3 . $part4 . $part5 . $part6;
			$time = time();
			$Company= Company::where('code',$code);
			if($Company->get()->isEmpty()){
				return response(['status'=>'error', 'details'=>"Please use the  code sent to your mobile number"]);
			}
			else if($time - $Company->first()->code_expiry_time > 1800){
				return response(['status'=>'error', 'details'=>"This code has expired."]);
			}
			else if($Company->first()->confirmed==1){
				return response(['status'=>'error', 'details'=>"This code has expired."]);
			}
			else{
			 if($Company->count()>0){
				$code = Company::find($Company->first()->id);
				$code->confirmed =1;
				$code->step =2;
				$code->save();
				Session::forget('step1');
				session(['step2' => 2]);
				return response(['status'=>'success','details'=>url('/register/step3'),'phone'=>$code->phone]);

			}else{
				return response(['status'=>'error', 'details'=>"This verification code has expired."]);
			}

			}
		}else{
			return response(['status'=>'error', 'details'=>"Empty fields are not allowed"]);
		}

	}

		public function verify_email_code(Request $request){

		$part1 = $request->input('code1');
		$part2 = $request->input('code2');
		$part3 = $request->input('code3');
		$part4 = $request->input('code4');
		$part5 = $request->input('code5');
		$part6 = $request->input('code6');

		if($part1!='' && $part2!='' && $part3!='' && $part4!='' && $part5!='' && $part6!=''){

			$code = $part1 . $part2 . $part3 . $part4 . $part5 . $part6;
			$time = time();
			$Company= Company::where('code',$code);
			if($Company->get()->isEmpty()){
				return response(['status'=>'error', 'details'=>"Please use the  code sent to your email"]);
			}else if($time - $Company->first()->code_expiry_time > 1800){
				return response(['status'=>'error', 'details'=>"This code has expired."]);
			}
			else if($Company->first()->confirmed==1){
				return response(['status'=>'error', 'details'=>"This code has expired."]);
			}
			else{
			 if($Company->count()>0){
				$code = Company::find($Company->first()->id);
				$code->confirmed =1;
				$code->step =4;
				$code->save();

				$user = User::where('email',$Company->first()->email)->first();
				session(['verification' =>1]);
				Session::forget('step3');
				Session::forget('email');
				Auth::login($user);

				return response(['status'=>'success','details'=>url('/'),'phone'=>$Company->first()->phone]);

			}else{
				return response(['status'=>'error', 'details'=>"This verification code has expired."]);
			}

			}
		}else{
			return response(['status'=>'error', 'details'=>"Empty fields are not allowed"]);
		}

	}
	public function resend_code(Request $request){

		$factory = new Factory;
		$generator = $factory->getLowStrengthGenerator();
		$code = $generator->generateString(6, '123456789');
		$final_code=substr($code, 0, 3) . "-" . substr($code, -3);
		if(Session::has('step1') && Session::has('phone')){
			$existingcompany=Company::where('phone', '=', $request->input('phone'));
			$smsno = str_replace("+","",$request->input('phone'));

			$replace = array( '+', '-', "[verification_code]" );
			$replace_by = array( "", "", $final_code );

			$msg = Setting::where('config_key','phone_no_verification_msg')->first()->config_value;
			$sms_message = str_replace( $replace, $replace_by, $msg );

			if($this->notification->send_sms($smsno,$sms_message,'Nodcomm')==true){
			$company = Company::find($existingcompany->first()->id);
			$company->confirmed =0;
			$company->code =$code;
			$company->code_expiry_time = time();
			$company->save();
			return response(['status'=>'success','code'=>$code,'phone'=>$request->input('phone'),'step4'=>'no']);
			}else{
			return response(['status'=>'error', 'details'=>'An error occurred, please try again.']);
			}
		}else if(Session::has('step3') && Session::has('email')){

		$existingcompany=Company::where('email', '=', $request->input('email'));

		    // if($this->notification->sendMailMandrill( $existingcompany->first()->email, $this->emailtemplate($existingcompany->first()->fname." ".$existingcompany->first()->lname, $final_code),'Company Account Creation Email','Nodcomm Company Account Creation ')){
		if(true){
			$company = Company::find($existingcompany->first()->id);
			$company->confirmed =0;
			$company->code =$code;
			$company->code_expiry_time = time();
			$company->save();
			return response(['status'=>'success','code'=>$code,'email'=>$request->input('email'),'step4'=>'yes']);
			}else{
			return response(['status'=>'error', 'details'=>'An error occurred, please try again.']);
			}
		}else{
			return response(['status'=>'error', 'details'=>"An error occurred. Please try again"]);
		}
	}

			    public function editmobileno(Request $request){

			try{
			$query= DB::table('users')
            ->where('id', Session::get('user_id'))
			->where('phone', $request->input('phone'))->count();

			if($request->telno==''){
				return response(['status'=>'error', 'details'=>"Please enter your Mobile Number."]);
			}
		    else if (Company::where('phone', '=', $request->input('phone'))->count() > 0 && !($query==1)) {
 				return response(['status'=>'error', 'details'=>"This mobile number exists"]);
			}
 			else if (User::where('phone', '=', $request->input('phone'))->count() > 0 && !($query==1)) {
			return response(['status'=>'error', 'details'=>"This mobile number exists"]);
			}
			else{
            $user = User::find(Session::get('user_id'));

            $user->phone = $request->input('phone');

            $user->save();

			if($user->company_id!=0 && $user->admin==1 ){
		    $company = Company::find($user->company_id);
            $company->phone = $request->input('phone');
			$company->country = $request->input('country_name');
            $company->save();
            }
            return response(['status'=>'success', 'details'=>substr($request->input('phone'), 0, 5) . "****" . substr($request->input('phone'), -3),'phone'=>$request->input('phone'),'email'=>$company->email]);
			}
        }catch(Exception $e){
            return response(['status'=>'error']);
        }

    }
		 public function editemail(Request $request){

			try{
			$query1= DB::table('users')
            ->where('id', Session::get('user_id'))
			->where('email', $request->input('email'))->count();

		     if($request->email==''){
				return response(['status'=>'error', 'details'=>"Please enter an email"]);
			}else if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
				return response(['status'=>'error', 'details'=>"Please enter a valid email"]);
			}else if (User::where('email', '=', $request->input('email'))->count() > 0 && !($query1==1)) {
			return response(['status'=>'error', 'details'=>"This email exists"]);
			}else if (Company::where('email', '=', $request->input('email'))->count() > 0 && !($query1==1)) {
 				return response(['status'=>'error', 'details'=>"This email exists"]);
			}
			else{
            $user = User::find(Session::get('user_id'));

            $user->email = $request->input('email');

            $user->save();

			if($user->company_id!=0 && $user->admin==1 ){
		    $company = Company::find($user->company_id);
            $company->email = $request->input('email');
            $company->save();
            }
            return response(['status'=>'success', 'details'=>$request->input('email'),'phone'=>$user->phone]);
			}
        }catch(Exception $e){
            return response(['status'=>'error']);
        }

    }
}
