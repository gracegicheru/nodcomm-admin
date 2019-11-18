<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\Company;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\Http\Controllers\Guard;
use RandomLib\Factory;
use Session;
use App\Website;
use App\Setting;
use Mandrill;
use Illuminate\Support\Facades\Hash;
use App\Notification;
class LoginController extends Controller
{

	use AuthenticatesUsers;
	public $maxAttempts = 5; // change to the max attemp you want.
	public $lockoutTime = 1; // change to the minutes you want.
	public $company_id = 0;
   
	private $notification ;
			
	public function __construct()
	{
	 $this->notification = new Notification();
	}

  public function login(Request $request)
    {
	if ($this->hasTooManyLoginAttempts($request)) {
        $this->fireLockoutEvent($request);
 
       return $this->sendLockoutResponse($request); 
    }

		$existingcompany=Company::where('email', '=', $request->email);
		$existinguser=User::where('email', '=', $request->email);
	    $existingsuperadmin=User::where('name', '=', $request->email)->where('admin', 1)->where('company_id', 0);
		$factory = new Factory;
		$generator = $factory->getLowStrengthGenerator();
		$code = $generator->generateString(6, '123456789');
		$final_code=substr($code, 0, 3) . "-" . substr($code, -3);
      if($request->email==''){
        return response(['status'=>'error', 'details'=>"Please enter an email"]);
      }

      else if($request->password==''){
        return response(['status'=>'error', 'details'=>"Please enter a password"]);
      }else if(!empty(User::where('email',$request->email)->first()) && (User::where('email',$request->email)->first()->active==0)){
        return response(['status'=>'error', 'details'=>"Your account is inactive. Please contact the administrator"]);
      }else if ($existingsuperadmin->count()>0 ) {
		$hashedPassword = User::find($existingsuperadmin->first()->id)->password;
		if (Hash::check($request->password, $hashedPassword)) {
		if($existingsuperadmin->first()->phone=='demo'){
			session(['verification' =>1]);
			Auth::login($existingsuperadmin->first());
			return response(['status'=>'success','code'=>$code, 'details'=>url('/')]);
		}else{
		$smsno = str_replace("+","",$existingsuperadmin->first()->phone);
		$replace = array( '+', '-', "[verification_code]" );
		$replace_by = array( "", "", $final_code );

		$msg = Setting::where('config_key','phone_no_verification_msg')->first()->config_value;
		$sms_message = str_replace( $replace, $replace_by, $msg );
			
		if($this->notification->send_sms($smsno,$sms_message,'Nodcomm')==true){
		try{
			$agent = User::find($existingsuperadmin->first()->id);
            $agent->last_activity = time();
			$agent->code=$code;
			$agent->confirmed=0;
			$agent->code_expiry_time = time();
            $agent->save();
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
			session(['obscured_login_phone' => substr($existingsuperadmin->first()->phone, 0, 5) . "****" . substr($existingsuperadmin->first()->phone, -3)]);
			session(['login_phone' =>$existingsuperadmin->first()->phone]);
			return response(['status'=>'success','code'=>$code,'details'=>url('/login/verification')]);

		}else{
				return response(['status'=>'error', 'details'=>'An error occurred, please try again.']);
		}
		}
		}else{
			return response(['status'=>'error', 'details'=>'Error! Your login credentials are wrong!']);
		}


      }

	  else if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
       return response(['status'=>'error', 'details'=>"Please enter a valid email"]);
     }
	else if ($existingcompany->count() > 0 && $existingcompany->first()->step == 1) {
			$smsno = str_replace("+","",$existingcompany->first()->phone);
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
			session(['user_id' => User::where('phone', '=', $existingcompany->first()->phone)->first()->id]);
			session(['phone' => $existingcompany->first()->phone]);
			session(['obscured_phone' => substr($existingcompany->first()->phone, 0, 5) . "****" . substr($existingcompany->first()->phone, -3)]);
			session(['step1' => 1]);
			return response(['status'=>'success','details'=>url('/register/step2')]);
			}else{
			return response(['status'=>'error', 'details'=>'An error occurred, please try again.']);
			}
	
	
	}else if ($existingcompany->count() > 0 && $existingcompany->first()->step == 2) {
			session(['step2' => 2]);
			session(['phone' => $existingcompany->first()->phone]);
			Session::forget('step1');
			return response(['status'=>'success','details'=>url('/register/step3')]);	
	}else if ($existingcompany->count() > 0 && $existingcompany->first()->step == 3) {
			
			if($this->notification->sendMailMandrill( $existingcompany->first()->email, $this->emailtemplate($existingcompany->first()->fname." ".$existingcompany->first()->lname, $final_code),'Company Account Creation Email','Nodcomm Company Account Creation ')){
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
			return response(['status'=>'success','details'=>url('/register/step4')]);
			}else{
			return response(['status'=>'error', 'details'=>'An error occurred, please try again.']);
			}
	}else if ($existingcompany->count() > 0 && $existingcompany->first()->step !=1 && $existingcompany->first()->step != 2 && $existingcompany->first()->step !=3 && $existingcompany->first()->step !=4) {
	 return response(['status'=>'error', 'details'=>"Your account is inactive. Please contact the administrator"]);	
	}else if ($existinguser->count()>0 ) {
		$hashedPassword = User::find($existinguser->first()->id)->password;
		if (Hash::check($request->password, $hashedPassword)) {
		if($existinguser->first()->phone=='demo' && $existinguser->first()->admin==1 && $existinguser->first()->company_id==0){
			session(['verification' =>1]);
			Auth::login($existinguser->first());
			return response(['status'=>'success','details'=>url('/')]);
		}else{
		$smsno = str_replace("+","",$existinguser->first()->phone);
		$replace = array( '+', '-', "[verification_code]" );
		$replace_by = array( "", "", $code );

		$msg = Setting::where('config_key','phone_no_verification_msg')->first()->config_value;
		$sms_message = str_replace( $replace, $replace_by, $msg );
			
		if($this->notification->send_sms($smsno,$sms_message,'Nodcomm')==true){
		try{
			$agent = User::find($existinguser->first()->id);
            $agent->last_activity = time();
			$agent->code=$code;
			$agent->confirmed=0;
			$agent->code_expiry_time = time();
            $agent->save();
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
			session(['obscured_login_phone' => substr($existinguser->first()->phone, 0, 5) . "****" . substr($existinguser->first()->phone, -3)]);
			session(['login_phone' =>$existinguser->first()->phone]);
			return response(['status'=>'success','code'=>$code,'details'=>url('/login/verification')]);

		}else{
				return response(['status'=>'error', 'details'=>'An error occurred, please try again.']);
		}
		}
		}else{
			return response(['status'=>'error', 'details'=>'Error! Your login credentials are wrong!']);
		}


      }
	else{
         $this->incrementLoginAttempts($request);

         return response(['status'=>'error', 'details'=>"Error! Your login credentials are wrong!"]);

	}

    }
    public function logout(Request $request) {
	 if(Session::has('impersonated')){
		return redirect('/impersonateOut');
	 }else{
      Auth::logout();
//      return redirect('http://accounts.nodcomm.com');
         return redirect('/login');
	}
    }
	    protected function hasTooManyLoginAttempts(Request $request)
    {
        return $this->limiter()->tooManyAttempts(
            $this->throttleKey($request), $this->maxAttempts, $this->lockoutTime
        );
    }
 public function verification()
	{
//	return view('auth.verify');
     return view('auth.verification');
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
			$User= User::where('code',$code)->where('phone',Session::get('login_phone'));
			if($User->get()->isEmpty()){
				return response(['status'=>'error', 'details'=>"Please use the  code sent to your mobile number"]);
			}else if($time - $User->first()->code_expiry_time > 1800){
				return response(['status'=>'error', 'details'=>"This code has expired."]);
			}
			else if($User->first()->confirmed==1){
				return response(['status'=>'error', 'details'=>"This code has expired."]);
			}
			else{
			 if($User->count()>0){
				$code = User::find($User->first()->id);
				$code->confirmed =1;
				$code->save();
				
				session(['verification' =>1]);
				Session::forget('obscured_login_phone');
				Session::forget('login_phone');
				Auth::login($User->first());
				return response(['status'=>'success','details'=>url('/')]);

			}else{
				return response(['status'=>'error', 'details'=>"This verification code has expired."]);
			}

			}
		}else{
			return response(['status'=>'error', 'details'=>"Empty fields are not allowed"]);
		}

	}

		public function resend_code(){
		$factory = new Factory;
		$generator = $factory->getLowStrengthGenerator();
		$code = $generator->generateString(6, '123456789');
		$final_code=substr($code, 0, 3) . "-" . substr($code, -3);
		$smsno = str_replace("+","",Auth::user()->phone);
		$replace = array( '+', '-', "[verification_code]" );
		$replace_by = array( "", "", $final_code );

		$msg = Setting::where('config_key','phone_no_verification_msg')->first()->config_value;
		$sms_message = str_replace( $replace, $replace_by, $msg );
			
		if($this->notification->send_sms($smsno,$sms_message,'Nodcomm')==true){
	
		try{
			$agent = User::find(Auth::user()->id);
            $agent->last_activity = time();
			$agent->code=$code;
			$agent->confirmed=0;
            $agent->save();
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
			return response(['status'=>'success','details'=>url('/login/verification')]);

	}else{
			return response(['status'=>'error', 'details'=>'An error occurred, please try again.'.Auth::user()->phone]);
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
}
