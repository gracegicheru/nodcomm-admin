<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\Company;
use App\Website;
use App\Setting;
use Auth;
use RandomLib\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Mandrill;
use Gregwar\Image\Image;
use App\Notification;
class RegisterController extends Controller
{
	 private $notification ;
	 private $translator ;
     public function __construct()
    {
	 set_time_limit(300);
    $this->middleware('auth');
	$this->notification = new Notification();
    }

    public function index()
    {
		if (Auth::user()->admin && Auth::user()->company_id==0){
       	$users= User::all();
		$companies= Company::all();
		$users_array = [];
		foreach($users as $user){
		$company=Company::where('id','=',$user->company_id);
		if($user->company_id!=0 && $company->count()>0){
		$user->{'company'} = $company->first()->name;
		$users_array [] =$user;
		}else if($user->company_id==0 ){
		$user->{'company'} = 'Nodcomm';
		$users_array [] =$user;
		}
		}
		return view('addusersuper')->with('users', $users_array)->with('companies', $companies);
		}else{

		$users= User::where('company_id','=' , Auth::user()->company_id)->get();
		return view('adduser')->with('users', $users);
		}

        
    }
	    public function companyusers($id){

		$users= Company::where('id','=' , $id)->first();

		$data = array(
		'users'=>$users,
		);

		return view('company_users')->with('users', $users);
    }
	    public function profile()
    {
        return view('profile');
    }
	 public function company_profile()
    {
		$company= Company::where('id',Auth::user()->company_id)->first();
        return view('company_profile')->with('company', $company);
    }
	public function update_company_profile(Request $request){

        try{
			$logo= Company::where('id',Auth::user()->company_id)->first();
			if($request->username==''){
				return response(['status'=>'error', 'details'=>"Please enter the company name"]);
			}
		    else if(!empty($logo) && !empty($logo->logo) && $request->file==''){
			 return response(['status'=>'error', 'details'=>"Please upload your company logo"]);
			}
			else{

				if($request->hasFile('file')){
				$extension = $request->file('file')->getClientOriginalExtension();
				if($extension!='png'&&$extension!='PNG'&&$extension!='jpg'&&$extension!='jpeg'){
				   return response(['status'=>'error', 'details'=>"Please upload a valid logo"]);
			    }else{
				$image = $request->file('file');
				$name = Auth::user()->company_id . '.' . $extension;
                $destinationPath = $_SERVER['DOCUMENT_ROOT'] .'/logos';
				$image->move($destinationPath, $name);
				$company = Company::find($request->id);
				$company->name = $request->username;
				$company->logo = $name;
				$company->save();
				return response(['status'=>'success', 'details'=>$company]);
				}
				}else{
					return response(['status'=>'error', 'details'=>"Please upload your company logo"]);
				}

			}

        }catch(Exception $e){
            return response(['status'=>'error']);
        }

    }
	    public function superadduser(Request $request){

        try{
			if(!empty($request->id)){
				 try{
					 $user= User::find($request->id);
					if($user->company_id!=0){
					$company=Company::where('id','=',$user->company_id)->first();
					$user->{'company'} = $company->name;
					}else{
					$user->{'company'} = 'Nodcomm';
					}
				     return response(['status'=>'success', 'details'=>$user]);
				    }catch(Exception $e){
					 return response(['status'=>'error']);
					}

			}
			if($request->username==''){
				return response(['status'=>'error', 'details'=>"Please enter a name"]);
			}
			else if($request->email==''){
				return response(['status'=>'error', 'details'=>"Please enter an email"]);
			}else if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
				return response(['status'=>'error', 'details'=>"Please enter a valid email"]);
			}
			else if (User::where('email', '=', $request->input('email'))->count() > 0) {
 				return response(['status'=>'error', 'details'=>"This email exists"]);
			}else if($request->telno==''){
				return response(['status'=>'error', 'details'=>"Please enter your Telephone No."]);
			}
		    else if (Company::where('phone', '=', $request->input('phone'))->count() > 0) {
 				return response(['status'=>'error', 'details'=>"This telephone number exists"]);
			}
		    else if (User::where('phone', '=', $request->input('phone'))->count() > 0) {
 				return response(['status'=>'error', 'details'=>"This telephone number exists"]);
			}
			else if($request->usertype==''){
				return response(['status'=>'error', 'details'=>"Please select a user type"]);
			}else if($request->company==''){
				return response(['status'=>'error', 'details'=>"Please select a company"]);
			}

			else{
			$factory = new Factory;
			$generator = $factory->getLowStrengthGenerator();
			$token = $generator->generateString(6, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');

			$company= Company::where('id','=' , $request->input('company'))->first()->name;
			$password = Hash::make($token);
		   if($this->notification->sendMailMandrill(trim($request->input('email')), $this->emailtemplate(trim($request->input('email')),$token,$company,trim($request->input('username'))),'Company Account Creation Email','Nodcomm Company Account Creation ')){
		    $user = new User;
            $user->name = $request->input('username');
			$user->admin = $request->input('usertype');
			$user->phone = $request->input('phone');
            $user->email = $request->input('email');
			$user->password = $password;
			$user->active =1;
			$user->company_id =$request->input('company');
            $user->save();

		    $users= User::all();
			$users_array = [];
			foreach($users as $user){
			$company=Company::where('id','=',$user->company_id);
			if($user->company_id!=0 && $company->count()>0){
			$user->{'company'} = $company->first()->name;
			$users_array [] =$user;
			}else if($user->company_id==0 ){
			$user->{'company'} = 'Nodcomm';
			$users_array [] =$user;
			}
			}
			return response(['status'=>'success', 'details'=>$users_array,'user_id'=>$user->id,'company_id'=>$request->input('company'),'email'=>$request->input('email'),'admin'=>$request->input('usertype'),'name'=>$request->input('username'),'password'=>$password]);
			}else{
			return response(['status'=>'success', 'details'=>'Unable to send registration email to the agent.']);
			}
			}
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
		    public function superedituser(Request $request){

        try{
			$query= DB::table('users')
            ->where('id', $request->input('id'))
			->where('phone', $request->input('phone'))->count();
			
			$query1= DB::table('users')
            ->where('id', $request->input('id'))
			->where('email', $request->input('email'))->count();
			
		    if($request->username==''){
				return response(['status'=>'error', 'details'=>"Please enter a name"]);
			}
			else if($request->email==''){
				return response(['status'=>'error', 'details'=>"Please enter an email"]);
			}else if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
				return response(['status'=>'error', 'details'=>"Please enter a valid email"]);
			}else if (User::where('email', '=', $request->input('email'))->count() > 0 && !($query1==1)) {
			return response(['status'=>'error', 'details'=>"This email exists"]);
			}else if (Company::where('email', '=', $request->input('email'))->count() > 0 && !($query1==1)) {
 				return response(['status'=>'error', 'details'=>"This email exists"]);
			}
			else if($request->telno==''){
				return response(['status'=>'error', 'details'=>"Please enter your Telephone No."]);
			}
		    else if (Company::where('phone', '=', $request->input('phone'))->count() > 0 && !($query==1)) {
 				return response(['status'=>'error', 'details'=>"This telephone number exists"]);
			}
 			else if (User::where('phone', '=', $request->input('phone'))->count() > 0 && !($query==1)) {
			return response(['status'=>'error', 'details'=>"This telephone number exists"]);
			}
			else if($request->usertype==''){
				return response(['status'=>'error', 'details'=>"Please select a user type"]);
			}else if($request->company==''){
				return response(['status'=>'error', 'details'=>"Please select a company"]);
			}

			else{
            $user = User::find($request->input('id'));
            $user->name = $request->input('username');
            $user->email = $request->input('email');
			$user->phone = $request->input('phone');
			$user->admin = $request->input('usertype');
			$user->company_id = $request->input('company');

            $user->save();
		
		    $users= User::all();
			$users_array = [];
			foreach($users as $user){
			$company=Company::where('id','=',$user->company_id);
			if($user->company_id!=0 && $company->count()>0){
			$user->{'company'} = $company->first()->name;
			$users_array [] =$user;
			}else if($user->company_id==0 ){
			$user->{'company'} = 'Nodcomm';
			$users_array [] =$user;
			}
			}

			return response(['status'=>'success', 'details'=>$users_array,'user_id'=>$request->input('id'),'company_id'=>$request->input('company'),'email'=>$request->input('email'),'admin'=>$request->input('usertype'),'name'=>$request->input('username')]);
			}
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
	public function superdisableuser(Request $request){

        try{

            $user = User::find($request->input('id'));
            $user->active =0;

            $user->save();
		
		    $users= User::all();
			$users_array = [];
			foreach($users as $user){
			$company=Company::where('id','=',$user->company_id);
			if($user->company_id!=0 && $company->count()>0){
			$user->{'company'} = $company->first()->name;
			$users_array [] =$user;
			}else if($user->company_id==0 ){
			$user->{'company'} = 'Nodcomm';
			$users_array [] =$user;
			}
			}
            
            return response(['status'=>'success', 'details'=>$users_array,'user_id'=>$request->input('id')]);
			
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
	public function superenableuser(Request $request){

        try{

            $user = User::find($request->input('id'));
            $user->active =1;

            $user->save();
		
		    $users= User::all();
			$users_array = [];
			foreach($users as $user){
			$company=Company::where('id','=',$user->company_id);
			if($user->company_id!=0 && $company->count()>0){
			$user->{'company'} = $company->first()->name;
			$users_array [] =$user;
			}else if($user->company_id==0 ){
			$user->{'company'} = 'Nodcomm';
			$users_array [] =$user;
			}
			}
            
            return response(['status'=>'success', 'details'=>$users_array,'user_id'=>$request->input('id')]);
			
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
    public function addagent(Request $request){

        try{
			if(!empty($request->id)){
				 try{
					 $user= User::find($request->id);
				     return response(['status'=>'success', 'details'=>$user]);
				    }catch(Exception $e){
					 return response(['status'=>'error']);
					}

			}
			if($request->username==''){
				return response(['status'=>'error', 'details'=>"Please enter a name"]);
			}
			else if($request->email==''){
				return response(['status'=>'error', 'details'=>"Please enter an email"]);
			}else if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
				return response(['status'=>'error', 'details'=>"Please enter a valid email"]);
			}
			else if (User::where('email', '=', $request->input('email'))->count() > 0) {
 				return response(['status'=>'error', 'details'=>"This email exists"]);
			}else if($request->telno==''){
				return response(['status'=>'error', 'details'=>"Please enter your Telephone No."]);
			}
		    else if (Company::where('phone', '=', $request->input('phone'))->count() > 0) {
 				return response(['status'=>'error', 'details'=>"This telephone number exists"]);
			}
		    else if (User::where('phone', '=', $request->input('phone'))->count() > 0) {
 				return response(['status'=>'error', 'details'=>"This telephone number exists"]);
			}
			else if($request->usertype==''){
				return response(['status'=>'error', 'details'=>"Please select a user type"]);
			}

			else{
			$factory = new Factory;
			$generator = $factory->getLowStrengthGenerator();
			$token = $generator->generateString(6, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');

			$company= Company::where('id','=' , Auth::user()->company_id)->first()->name;

            if($this->notification->sendMailMandrill(trim($request->input('email')), $this->emailtemplate(trim($request->input('email')),$token,$company,trim($request->input('username'))),'Company Account Creation Email','Nodcomm Company Account Creation ')){
			$password=Hash::make($token);
		    $user = new User;
            $user->name = $request->input('username');
			$user->admin = $request->input('usertype');
			$user->phone = $request->input('phone');
            $user->email = $request->input('email');
			$user->password = $password;
			$user->company_id = Auth::user()->company_id;
            $user->save();

		    $users= User::where('company_id','=' , Auth::user()->company_id)->get();

            //return response(['status'=>'success', 'details'=>$users]);
			return response(['status'=>'success', 'details'=>$users,'user_id'=>$user->id,'company_id'=>Auth::user()->company_id,'email'=>$request->input('email'),'admin'=>$request->input('usertype'),'name'=>$request->input('username'),'password'=>$password]);
			}else{
			return response(['status'=>'success', 'details'=>'Unable to send registration email to the agent.']);
			}
			}
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }

	
	    public function editagent(Request $request){

        try{

			$query= DB::table('users')
            ->where('id', $request->input('id'))
			->where('phone', $request->input('phone'))->count();
			
			$query1= DB::table('users')
            ->where('id', $request->input('id'))
			->where('email', $request->input('email'))->count();
		    if($request->username==''){
				return response(['status'=>'error', 'details'=>"Please enter a name"]);
			}
			else if($request->email==''){
				return response(['status'=>'error', 'details'=>"Please enter an email"]);
			}else if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
				return response(['status'=>'error', 'details'=>"Please enter a valid email"]);
			}else if (User::where('email', '=', $request->input('email'))->count() > 0 && !($query1==1)) {
			return response(['status'=>'error', 'details'=>"This email exists"]);
			}else if (Company::where('email', '=', $request->input('email'))->count() > 0 && !($query1==1)) {
 				return response(['status'=>'error', 'details'=>"This email exists"]);
			}
			else if($request->telno==''){
				return response(['status'=>'error', 'details'=>"Please enter your Telephone No."]);
			}
		    else if (Company::where('phone', '=', $request->input('phone'))->count() > 0 && !($query==1)) {
 				return response(['status'=>'error', 'details'=>"This telephone number exists"]);
			}
 			else if (User::where('phone', '=', $request->input('phone'))->count() > 0 && !($query==1)) {
			return response(['status'=>'error', 'details'=>"This telephone number exists"]);
			}
			else if($request->usertype==''){
				return response(['status'=>'error', 'details'=>"Please select a user type"]);
			}

			else{
            $user = User::find($request->input('id'));
            $user->name = $request->input('username');
			$user->phone = $request->input('phone');
            $user->email = $request->input('email');
			$user->admin = $request->input('usertype');

            $user->save();
		
            $users= User::where('company_id','=' , Auth::user()->company_id)->get();
            return response(['status'=>'success', 'details'=>$users,'user_id'=>$request->input('id'),'email'=>$request->input('email'),'admin'=>$request->input('usertype'),'name'=>$request->input('username')]);
			}
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
	
		    public function disableagent(Request $request){

        try{

            $user = User::find($request->input('id'));
            $user->active =0;

            $user->save();
		
            $users= User::where('company_id','=' , Auth::user()->company_id)->get();

			return response(['status'=>'success', 'details'=>$users,'user_id'=>$request->input('id')]);
			
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
	
	 public function enableagent(Request $request){

        try{

            $user = User::find($request->input('id'));
            $user->active =1;

            $user->save();
		
            $users= User::where('company_id','=' , Auth::user()->company_id)->get();
            
           return response(['status'=>'success', 'details'=>$users,'user_id'=>$request->input('id')]);
			
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }

    public function emailtemplate($email, $password,$company,$agent) {
		if(!empty(Company::where('id','=' , Auth::user()->company_id)->first()->logo)){
		$logo ='/storage/company_logos/'.Company::where('id','=' , Auth::user()->company_id)->first()->logo;
		}else{
		$logo='/images/Nodcomm.png';	
		}
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
                                <td style="text-align: center; padding: 10px; border-bottom:2px solid #037caa; "><img style="width: 80%;" src="' . url($logo). '" alt="Company Logo"/>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px; background-color:#fff; ">
                                    <h3 style="color: #037caa">Account Creation Confirmation</h3> 
                                    <h4>Dear '.$agent.',</h4>
                                    <p>
                                    An account has been created for you on '.$company.'. Login using the following credentials:
                                    </p>
                                 s   <p>
                                     <div><pan><h4 style="display:inline">Email: </h4></span><span>'.$email.' </span></div>
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
                                    <p>'.$company.'</p>
                                </td>
                            </tr>
                            <tr>
                                <td style=" text-align: center; color: #000; padding: 10px;">

                                    © ' . date( "Y" ) . ' ' .$company. ' / Terms & Conditions / Privacy Notice</td>
                            </tr>
                        </table>

                    </body>

                    </html>
                    ';
        return $html;
    }
	
		    public function editprofile(Request $request){

        try{

			$query= DB::table('users')
            ->where('id', $request->input('id'))
			->where('phone', $request->input('phone'))->count();
			
			$query1= DB::table('users')
            ->where('id', $request->input('id'))
			->where('email', $request->input('email'))->count();
		    if($request->username==''){
				return response(['status'=>'error', 'details'=>"Please enter a name"]);
			}
			else if($request->email==''){
				return response(['status'=>'error', 'details'=>"Please enter an email"]);
			}else if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
				return response(['status'=>'error', 'details'=>"Please enter a valid email"]);
			}else if (User::where('email', '=', $request->input('email'))->count() > 0 && !($query1==1)) {
			return response(['status'=>'error', 'details'=>"This email exists"]);
			}else if (Company::where('email', '=', $request->input('email'))->count() > 0 && !($query1==1)) {
 				return response(['status'=>'error', 'details'=>"This email exists"]);
			}
			else if($request->telno==''){
				return response(['status'=>'error', 'details'=>"Please enter your Telephone No."]);
			}
		    else if (Company::where('phone', '=', $request->input('phone'))->count() > 0 && !($query==1)) {
 				return response(['status'=>'error', 'details'=>"This telephone number exists"]);
			}
 			else if (User::where('phone', '=', $request->input('phone'))->count() > 0 && !($query==1)) {
			return response(['status'=>'error', 'details'=>"This telephone number exists"]);
			}
            else if($request->address==''){
                return response(['status'=>'error', 'details'=>"Please enter an address"]);
            }
            else if($request->about==''){
                return response(['status'=>'error', 'details'=>"Please enter a brief description about you"]);
            }
			else{
            $user = User::find($request->input('id'));
            if($request->hasFile('photo')){
				$extension = $request->file('photo')->getClientOriginalExtension();
				if($extension!='png'&&$extension!='PNG'&&$extension!='jpg'&&$extension!='jpeg'){
				   return response(['status'=>'error', 'details'=>$extension."Please upload a valid image"]);
			    }else{
				$image = $request->file('photo');
				$name = Auth::user()->id . '.' . $extension;
				//$destinationPath = public_path('/profile_photos');
                $destinationPath = $_SERVER['DOCUMENT_ROOT'] .'/profile_photos';
				$image->move($destinationPath, $name);
				$user->photo = $name;
				}
            }

            $user->name = $request->input('username');
            $user->email = $request->input('email');
            $user->phone = $request->input('phone');
            $user->address = $request->input('address');
            $user->about = $request->input('about');
            
            $user->save();
            
            return response(['status'=>'success', 'details'=>$user]);
			}
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
	   	public function changepassword()
    {	


			$factory = new Factory;
			$generator = $factory->getLowStrengthGenerator();
		    $code = $generator->generateString(6, '0123456789');
			$replace = array( '+', '-', "[name]", "[verification_code]",);
			$replace_by = array( "", "", Auth::user()->name, $code );

			$msg = Setting::where('config_key','change_password_msg')->first()->config_value;
			$sms_message = str_replace( $replace, $replace_by, $msg );
			
			  if($this->notification->send_sms(str_replace('+','',Auth::user()->phone),$sms_message,'Nodcomm')==true){

			   $user = User::find(Auth::user()->id);
			   $user->confirmed = 0;
			   $user->code = $code;

				$user->save();
				return view('changepassword');

				}else{
				return response(['status'=>'error', 'details'=>'An error occurred, please contact the administrator.']);
				}
			

    }
		   	public function confirmcode(Request $request){

		$User= User::where('code',$request->code);
		if($User->get()->isEmpty()){
			return response(['status'=>'error', 'details'=>"Please use the  code sent to you"]);
		}else{
	   try{
		    if($request->code==''){
				return response(['status'=>'error', 'details'=>"Please enter a code"]);
			}else if($User->first()->confirmed==1){
				return response(['status'=>'error', 'details'=>"This code has expired."]);
			}
			else{
			 if($User->count()>0){
				$code = User::find($User->first()->id);
				$code->confirmed =1;
				$code->save();

				return response(['status'=>'success']);

			}else{
				return response(['status'=>'error', 'details'=>"Please enter the code sent to you"]);
			}

			}
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
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
            ->where('id', Auth::user()->id)
            ->update(['password' => Hash::make(trim($request->password))]);

            return response(['status'=>'success', 'details'=>'password changed']);

			}
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }


	public function superadmins(){
		$users= User::where('company_id','=' ,0)->where('admin','=' ,1)->get();
		return view('addsuperadmin')->with('users', $users);	
	}
	    public function addsuperadmin(Request $request){

        try{
			if(!empty($request->id)){
				 try{
					 $user= User::find($request->id);
				     return response(['status'=>'success', 'details'=>$user]);
				    }catch(Exception $e){
					 return response(['status'=>'error']);
					}

			}
			if($request->username==''){
				return response(['status'=>'error', 'details'=>"Please enter the admin username"]);
			}
			else if($request->email==''){
				return response(['status'=>'error', 'details'=>"Please enter an email"]);
			}else if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
				return response(['status'=>'error', 'details'=>"Please enter a valid email"]);
			}
			else if (User::where('email', '=', $request->input('email'))->count() > 0) {
 				return response(['status'=>'error', 'details'=>"This email exists"]);
			}else if (Company::where('email', '=', $request->input('email'))->count() > 0) {
 				return response(['status'=>'error', 'details'=>"This email exists"]);
			}else if($request->telno==''){
				return response(['status'=>'error', 'details'=>"Please enter the admin mobile number."]);
			}
		    else if (Company::where('phone', '=', $request->input('phone'))->count() > 0) {
 				return response(['status'=>'error', 'details'=>"This mobile number exists"]);
			}
		    else if (User::where('phone', '=', $request->input('phone'))->count() > 0) {
 				return response(['status'=>'error', 'details'=>"This mobile number exists"]);
			}

			else{
			$factory = new Factory;
			$generator = $factory->getLowStrengthGenerator();
			$token = $generator->generateString(6, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');

            if($this->notification->sendMailMandrill(trim($request->input('email')), $this->emailtemplate(trim($request->input('email')),$token,'Nodcomm',trim($request->input('username'))),'Company Account Creation Email','Nodcomm Company Account Creation ')){
			$password = Hash::make($token);
		    $user = new User;
            $user->name =trim($request->input('username'));
			$user->admin = 1;
			$user->phone = $request->input('phone');
            $user->email = $request->input('email');
			$user->password = $password;
			$user->company_id = 0;
            $user->save();

		    $users= User::where('company_id','=' ,0)->where('admin','=' ,1)->get();
			return response(['status'=>'success', 'details'=>$users,'user_id'=>$user->id,'email'=>$request->input('email'),'name'=>$request->input('username'),'password'=>$password]);
			}else{
			return response(['status'=>'success', 'details'=>'Unable to send registration email to the agent.']);
			}
			}
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
	
		    public function editsuperadmin(Request $request){

        try{

			$query= DB::table('users')
            ->where('id', $request->input('id'))
			->where('phone', $request->input('phone'))->count();
			
			$query1= DB::table('users')
            ->where('id', $request->input('id'))
			->where('email', $request->input('email'))->count();
		    if($request->username==''){
				return response(['status'=>'error', 'details'=>"Please enter a name"]);
			}
			else if($request->email==''){
				return response(['status'=>'error', 'details'=>"Please enter an email"]);
			}else if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
				return response(['status'=>'error', 'details'=>"Please enter a valid email"]);
			}else if (User::where('email', '=', $request->input('email'))->count() > 0 && !($query1==1)) {
			return response(['status'=>'error', 'details'=>"This email exists"]);
			}else if (Company::where('email', '=', $request->input('email'))->count() > 0 && !($query1==1)) {
 				return response(['status'=>'error', 'details'=>"This email exists"]);
			}
			else if($request->telno==''){
				return response(['status'=>'error', 'details'=>"Please enter a mobile number."]);
			}
		    else if (Company::where('phone', '=', $request->input('phone'))->count() > 0 && !($query==1)) {
 				return response(['status'=>'error', 'details'=>"This mobile number exists"]);
			}
 			else if (User::where('phone', '=', $request->input('phone'))->count() > 0 && !($query==1)) {
			return response(['status'=>'error', 'details'=>"This mobile number exists"]);
			}


			else{
            $user = User::find($request->input('id'));
            $user->name = $request->input('username');
			$user->phone = $request->input('phone');
            $user->email = $request->input('email');


            $user->save();
		
		    $users= User::where('company_id','=' ,0)->where('admin','=' ,1)->get();
            return response(['status'=>'success', 'details'=>$users,'user_id'=>$request->input('id'),'email'=>$request->input('email'),'name'=>$request->input('username')]);
			}
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
			    public function disablesuperadmin(Request $request){

        try{

            $user = User::find($request->input('id'));
            $user->active =0;

            $user->save();
		
		    $users= User::where('company_id','=' ,0)->where('admin','=' ,1)->get();
            
            return response(['status'=>'success', 'details'=>$users,'user_id'=>$request->input('id')]);
			
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
	
	 public function enablesuperadmin(Request $request){

        try{

            $user = User::find($request->input('id'));
            $user->active =1;

            $user->save();
		
		    $users= User::where('company_id','=' ,0)->where('admin','=' ,1)->get();
            
             return response(['status'=>'success', 'details'=>$users,'user_id'=>$request->input('id')]);
			
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
	public function firebase_users(){
		$users= User::all();
		return response(['status'=>'success', 'details'=>$users]);
	}
		public function firebase_companies(){
		$companies= Company::all();
		return response(['status'=>'success', 'details'=>$companies]);
	}
}
