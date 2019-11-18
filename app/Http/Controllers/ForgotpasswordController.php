<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests;

use App\User;

use App\Setting;

use App\PasswordReset;

use Mandrill;

use RandomLib\Factory;
class ForgotpasswordController extends Controller
{
   	public function forgotpassword()
    {	
        return view('forgotpassword');
    }
	 public function resetemail(Request $request)
    {
      if($request->email==''){
        return response(['status'=>'error', 'details'=>"Please enter an email"]);
      }else if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
        return response(['status'=>'error', 'details'=>"Please enter a valid email"]);
      }

     else if (User::where('email',$request->email)->count()>0) {
        $user =User::where('email',$request->email)->first();
		if ($this->sendMailMandrill(trim($request->input('email')), $user->name)){
        return response(['status'=>'success', 'details'=>'Reset password link is sent to '.$request->email]);
		}else{
			return response(['status'=>'success', 'details'=>'Unable to send password reset email to '.$request->email]);
		}
	  }else{
        return response(['status'=>'error', 'details'=>"Error! ".$request->email." is not registered in our system!"]);
      }

    }
	public function sendMailMandrill( $email, $username ) {
		$mandrill_ready = NULL;
		try {
			$mandrill = new Mandrill;
            $mandrill_api_key= Setting::where('config_key','mandrill_api_key')->first();
            $mandrill->init($mandrill_api_key->config_value);
			$mandrill_ready = TRUE;
		} catch ( Mandrill_Exception $e ) {
			$mandrill_ready = FALSE;
		}

		if ( $mandrill_ready ) {
			//Send us some email!
			$from_email= Setting::where('config_key','from_email')->first();
			
			$factory = new Factory;
			$generator = $factory->getLowStrengthGenerator();
			$token = $generator->generateString(32, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
			$url = 'resetpassword/'.$token;
			
			$ResetPassword = new PasswordReset;
			if (PasswordReset::where('email',$email)->count()>0){

			DB::table('password_resets')
            ->where('email', $email)
            ->update(['token' => $token,'expired'=>0]);
			}else{
				DB::table('password_resets')->insert([
				['email' => $email, 'token' => $token]
				]);

			}
			
			$html = $this->emailtemplate( $username,$url);
			$email1 = array(
				'html' => $html, //Consider using a view file
				'text' => 'Account password reset',
				'subject' => 'Nodcomm Admin Account Password Reset ',
				'from_email' => $from_email->config_value,
				'from_name' => 'Nodcomm',
				'to' => array( array( 'email' => $email ) ) //Check documentation for more details on this one
				//'to' => array(array('email' => 'joe@example.com' ),array('email' => 'joe2@example.com' )) //for multiple emails
			);
			$result = $mandrill->messages_send( $email1 );
			if ( !empty( $result ) ) {
				return TRUE;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}
	    public function emailtemplate($username,$url) {
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
                                    <h3 style="color: #037caa">Account Password Reset</h3> 
                                    <h4>Hello '.$username.',</h4>
                                    <p>
										A request has been received to change the password for your account.
                                    </p>

                                    <div style="text-align:center">
                                            <a href="' . url($url). '" 
                                            style="display: inline-block;
                                                padding: 6px 12px;
                                                margin-bottom: 0;
                                                font-size: 14px;
                                                font-weight: 400;
                                                color:#ffffff;
                                                line-height: 1.42857143;
                                                text-align: center;
                                                white-space: nowrap;
                                                vertical-align: middle;
                                                cursor: pointer;
                                                -webkit-user-select: none;
                                                -moz-user-select: none;
                                                -ms-user-select: none;
                                                user-select: none;
                                                background-image: none;
                                                border: 1px solid transparent;
                                                border-radius: 4px;    background: #65cea7;
                                                border: 1px solid #3ec291; 
                                                 text-decoration: none;">Click here to reset your password</a>
                                    </div>
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
   	public function resetpassword($token)
    {
		$PasswordReset= PasswordReset::where('token',$token);
       if ($PasswordReset->count()>0){
		if($PasswordReset->first()->expired==1){
			return view('wronglink')->with('token', 'The link has been used');  
		}else{ 
          return view('resetpassword')->with('email', $PasswordReset->first()->email);
		 }
		}else{
		return view('wronglink')->with('token', 'Use the link sent to your email to reset your password'); 
	   }
    }
	    public function updatepassword(Request $request){

        try{
		    if($request->password==''){
				return response(['status'=>'error', 'details'=>"Please enter a new password"]);
			}
			else if($request->confirm_password==''){
				return response(['status'=>'error', 'details'=>"Please confirm your password"]);
			}else if (trim($request->password)!=trim($request->confirm_password)) {
				return response(['status'=>'error', 'details'=>"The passwords do not match"]);
			}

			else{
			DB::table('users')
            ->where('email', $request->email)
            ->update(['password' => Hash::make(trim($request->password))]);
           
		   DB::table('password_resets')
            ->where('email', $request->email)
            ->update(['expired' => 1]);
            return response(['status'=>'success', 'details'=>'password changed']);
			}
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
}
