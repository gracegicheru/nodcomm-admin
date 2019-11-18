<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Company;
use App\User;
use RandomLib\Factory;
use Mandrill;
use App\Setting;
use Illuminate\Support\Facades\Hash;
class WebsitesController extends Controller
{
       public function __construct()
    {
    $this->middleware('auth');
    }
    public function index()
    {
    	$websites = Company::all();

        return view('addwebsite')->with('websites', $websites);
    }
		    public function addcompany(Request $request){

        try{

			if(!empty($request->id)){
				 try{
					 $company= Company::find($request->id);
				     return response(['status'=>'success', 'details'=>$company]);
				    }catch(Exception $e){
					 return response(['status'=>'error']);
					}

			}
			if($request->name==''){
				return response(['status'=>'error', 'details'=>"Please enter the company name"]);
			}
			else if($request->website==''){
				return response(['status'=>'error', 'details'=>"Please enter the company website"]);
			}
			else if($request->company_size==''){
				return response(['status'=>'error', 'details'=>"Please select the company number of employees"]);
			}
			else if($request->fname==''){
				return response(['status'=>'error', 'details'=>"Please enter your First Name"]);
			}
			else if($request->lname==''){
				return response(['status'=>'error', 'details'=>"Please enter your Last Name"]);
			}
			else if($request->email==''){
				return response(['status'=>'error', 'details'=>"Please enter the company email"]);
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
				return response(['status'=>'error', 'details'=>"Please enter the company address"]);
			}
		    else if($request->telno==''){
				return response(['status'=>'error', 'details'=>"Please enter your Telephone No."]);
			}
		    else if (Company::where('phone', '=', $request->input('phone'))->count() > 0) {
 				return response(['status'=>'error', 'details'=>"This telephone number exists"]);
			}
		    else if (User::where('phone', '=', $request->input('phone'))->count() > 0) {
 				return response(['status'=>'error', 'details'=>"This telephone number exists"]);
			}


			else{
			$factory = new Factory;
			$generator = $factory->getLowStrengthGenerator();
			$code = $generator->generateString(6, '0123456789');
		    $api_id = $generator->generateString(32, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
           	$api_key = $generator->generateString(32, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
            $password = $generator->generateString(6, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
		
			if($this->sendMailMandrill($request->input('email'), $request->input('fname')." ".$request->input('lname'), $password )){
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
            $company->name = $request->input('name');
            $company->email = $request->input('email');
			$company->lname = $request->input('lname');
            $company->fname = $request->input('fname');
		    $company->country = $request->input('country_name');
            $company->phone = $request->input('phone');
			$company->address = $request->input('address');
            $company->website = $request->input('website');
			$company->company_size = $request->input('company_size');
			$company->api_id =$api_id;
			$company->api_key =$api_key;
            $company->code =$code;
			$company->city = $geolocation->city;
            $company->region = $geolocation->regionName;
            $company->flag = $country->flag;
            $company->country = $geolocation->country;
			$company->latitude = $geolocation->lat;
			$company->longitude = $geolocation->lon;
			$company->ip = $ip;
			$company->active =1;
			$company->save();
			
			$user = new User;
			$user->company_id = $company->id;
            $user->name = $request->input('fname')." ".$request->input('lname');
			$user->admin=1;
            $user->email = $request->input('email');
			$user->phone = $request->input('phone');
			$user->address = $request->input('address');
			$user->password = Hash::make($password);
			$user->active =1;
			$user->save();
			$companies=  Company::all();
            return response(['status'=>'success', 'details'=>$companies,'code'=>$code,'api_id'=>$api_id,'api_key'=>$api_key,'password'=>$password,'user_id'=>$user->id,'company_id'=>$company->id]);
			}else{
			return response(['status'=>'error', 'details'=>'An error occurred, please try again.']);
			}
			}
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }

	
		    public function editcompany(Request $request){

        try{
			if($request->name==''){
				return response(['status'=>'error', 'details'=>"Please enter the company name"]);
			}
			else if($request->website==''){
				return response(['status'=>'error', 'details'=>"Please enter the company website"]);
			}
			else if($request->company_size==''){
				return response(['status'=>'error', 'details'=>"Please select the company number of employees"]);
			}
			
			else{
            $company = Company::find($request->input('id'));
            $company->name = $request->input('name');
            $company->email = $request->input('email');
			$company->lname = $request->input('lname');
            $company->fname = $request->input('fname');
		    $company->country = $request->input('country_name');
            $company->phone = $request->input('phone');
			$company->address = $request->input('address');
            $company->website = $request->input('website');
			$company->company_size = $request->input('company_size');
			$company->save();
			
			$user = User::where('company_id',$request->input('id'))->first();
            $user->name = $request->input('fname')." ".$request->input('lname');
            $user->email = $request->input('email');
			$user->phone = $request->input('phone');
			$user->address = $request->input('address');
			$user->save();
            $companies=  Company::all();
            
            return response(['status'=>'success', 'details'=>$companies]);
			}
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
	    public function disablecompany(Request $request){

        try{

            $website = Company::find($request->input('id'));
            $website->active =0;

            $website->save();
		
            $websites=  Company::all();
            
            return response(['status'=>'success', 'details'=>$websites]);
			
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
		public function enablecompany(Request $request){

        try{

            $website = Company::find($request->input('id'));
            $website->active =1;

            $website->save();
		
            $websites=  Company::all();
            
            return response(['status'=>'success', 'details'=>$websites]);
			
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
	
		  public function sendMailMandrill( $email, $username, $password ) {
        $mandrill_ready = NULL;
        try {
			$mandrill = new Mandrill();
            $mandrill_api_key= Setting::where('config_key','mandrill_api_key')->first();
			$mandrill->init($mandrill_api_key->config_value);
			$mandrill_ready = TRUE;
        } catch ( Mandrill_Exception $e ) {
            $mandrill_ready = FALSE;
        }

        if ( $mandrill_ready ) {
            //Send us some email!
            $html = $this->emailtemplate( $email, $password, $username );
			
            $from_email= Setting::where('config_key','from_email')->first();
            $email1 = array(
                'html' => $html, //Consider using a view file
                'text' => 'Company Account Creation Email',
                'subject' => 'Nodcomm Company Account Creation ',
				'from_email' => $from_email->config_value,
                'from_name' => 'Nodcomm Admin',
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

    public function emailtemplate($email, $password, $username) {
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
                                    An account has been created for you on Nodcomm. Login using the following credentials:
                                    </p>
                                    <p>
                                     <div><span><h4 style="display:inline">Email: </h4></span><span>'.$email.' </span></div>
                                     <div><span><h4 style="display:inline">Password: </h4></span><span>'.$password.' </span></div>
                                    </p>
                                    <div style="text-align:center">
                                            <a href="' . url('/login'). '" 
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
                                                 text-decoration: none;">Login to your account</a>
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
}
