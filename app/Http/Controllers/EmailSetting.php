<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Email;
class EmailSetting extends Controller
{
   
     public function __construct()
    {
    $this->middleware('auth');
    }
    public function index()
    {
		$email = Email::first();

        return view('settings.email')->with('email', $email);
    }
		public function addemailsetting(Request $request){

        try{

			if($request->name==''){
				return response(['status'=>'error', 'details'=>"Please enter the email username"]);
			}
			else if($request->port==''){
				return response(['status'=>'error', 'details'=>"Please enter the email port"]);
			}else if($request->host==''){
				return response(['status'=>'error', 'details'=>"Please enter the email host"]);
			}else if($request->encryption==''){
				return response(['status'=>'error', 'details'=>"Please enter the email encryption"]);
			}else if($request->password==''){
				return response(['status'=>'error', 'details'=>"Please enter a password"]);
			}else{

			$email = new Email;
            $email->username = $request->input('name');
            $email->password = $request->input('password');
			$email->host = $request->input('host');
            $email->encryption = $request->input('encryption');
		    $email->port = $request->input('port');

			$email->save();
		
            return response(['status'=>'success', 'details'=>$email]);
			}
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
			    public function editemailsetting(Request $request){

        try{
			if($request->name==''){
				return response(['status'=>'error', 'details'=>"Please enter the email username"]);
			}
			else if($request->port==''){
				return response(['status'=>'error', 'details'=>"Please enter the email port"]);
			}else if($request->host==''){
				return response(['status'=>'error', 'details'=>"Please enter the email host"]);
			}else if($request->encryption==''){
				return response(['status'=>'error', 'details'=>"Please enter the email encryption"]);
			}else if($request->password==''){
				return response(['status'=>'error', 'details'=>"Please enter a password"]);
			}else{
            $email = Email::find($request->input('id'));
            $email->username = $request->input('name');
            $email->password = $request->input('password');
			$email->host = $request->input('host');
            $email->encryption = $request->input('encryption');
		    $email->port = $request->input('port');

			$email->save();


            return response(['status'=>'success', 'details'=>$email]);
			}
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
		
}
