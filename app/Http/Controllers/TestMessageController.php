<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TestMessage;
use App\Setting;
use App\Website;
use App\User;
use App\Adverts;
use App\Company;
use Auth;
use App\Notification;
use App\SMSPayment;
use App\SMSCredit;
use App\SenderID;
use App\ContactGroup;
class TestMessageController extends Controller
{
	private $notification ;
       public function __construct()
    {
    $this->middleware('auth');
	$this->notification = new Notification();
    }
    public function index()
    {

		if (Auth::user()->admin && Auth::user()->company_id==0){
    	$messages = TestMessage::all();
		foreach($messages as $message){
		if($message->company_id!=0){
		$company=Company::where('id','=',$message->company_id);
		$message->{'company'} = $company->first()->name;
		}else{
		$message->{'company'} = 'Nodcomm';
		}
		}
		}else{
		$messages = TestMessage::where('company_id', Auth::user()->company_id)->where('sent_by', Auth::user()->id)->get();	
		foreach($messages as $message){
		$User=User::where('id','=',$message->sent_by);
		$message->{'company'} = $User->first()->name;
		}
		}
		$date=date("Y-m-d");
		$sender_ids= SenderID::where('company_id',Auth::user()->company_id)
								->where('verified',1)
								->get();
        $contacts= ContactGroup::where('company_id',Auth::user()->company_id)->where('user_id',Auth::user()->id)->get();
		return view('test_messages')->with('contacts',$contacts)->with('sender_ids',$sender_ids)->with('messages', $messages)->with('date', $date);
    }

	/*public function send_test_sms(Request $request){
			$advert = Adverts::first();
			if(!empty($advert)){
			$message = $request->input('message').' '.$advert->message;
			}else{
			$message = $request->input('message').' Powered by Nodcomm.';
			}
			$smsno = str_replace("+","",$request->input('phone'));
			$freemsgsno = Setting::where('config_key','free_messages')->first()->config_value;
			if(TestMessage::where('company_id', Auth::user()->company_id)->count() < $freemsgsno ){

			if($this->notification->send_sms($smsno,$message)==true){
			$sms = new TestMessage;
		    $sms->message = $message;
            $sms->phone = $request->input('phone');
			$sms->company_id =Auth::user()->company_id;
			$sms->sent_by =Auth::user()->id;
			
			$sms->save();
			
			if (Auth::user()->admin && Auth::user()->company_id==0){
			$messages = TestMessage::all();
			foreach($messages as $message){
			if($message->company_id!=0){
			$company=Company::where('id','=',$message->company_id);
			$message->{'company'} = $company->first()->name;
			}else{
			$message->{'company'} = 'Nodcomm';
			}
			}
			}else{
			$messages = TestMessage::where('company_id', Auth::user()->company_id)->where('sent_by', Auth::user()->id)->get();	
			foreach($messages as $message){
			$User=User::where('id','=',$message->sent_by);
			$message->{'company'} = $User->first()->name;
			}
			}
			return response(['status'=>'success','details'=>$messages ]);
			}else{
			return response(['status'=>'error', 'details'=>'An error occurred, please try again.']);
			}
			}else{
			return response(['status'=>'error', 'details'=>'You have sent all your test SMS.']);
			}
	}*/
		public function send_test_sms(Request $request){
			if($request->phone==''){
				return response(['status'=>'error', 'details'=>"Please select a contact group"]);
			}else{
			$myString = str_replace("+","",$request->input('phone'));
			$smsno = explode(',', trim($myString,','));
			$credit = SMSCredit::where('user_id', Auth::user()->id)->first();
			if($request->input('sender_id')){
				$alphanumeric=$request->input('sender_id');
			}else{
				$alphanumeric='Nodcomm';
			}
			if(!empty($credit)){
			if( floatval($credit->credit) > 0 ){
			$sms = new TestMessage;
			$sms->message = $request->input('message');
            $sms->phone = $request->input('phone');
			$sms->company_id =Auth::user()->company_id;
			$sms->sent_by =Auth::user()->id;
			if($this->notification->send_sms($smsno,$request->input('message'),$alphanumeric)==true){
			$creditbal = floatval($credit->credit) - 1;
			$credits = SMSCredit::find($credit->id);
			$credits->credit = $creditbal;
			$credits->save();
			$creditbal = floatval($credit->credit) - 1;
			$credits = SMSCredit::find($credit->id);
			$credits->credit = $creditbal;
			$credits->save();
			$sms->status = 'sent';
			$sms->save();
			if (Auth::user()->admin && Auth::user()->company_id==0){
			$messages = TestMessage::all();
			foreach($messages as $message){
			if($message->company_id!=0){
			$company=Company::where('id','=',$message->company_id);
			$message->{'company'} = $company->first()->name;
			}else{
			$message->{'company'} = 'Nodcomm';
			}
			}
			}else{
			$messages = TestMessage::where('company_id', Auth::user()->company_id)->where('sent_by', Auth::user()->id)->get();	
			foreach($messages as $message){
			$User=User::where('id','=',$message->sent_by);
			$message->{'company'} = $User->first()->name;
			}
			}
			return response(['status'=>'success','details'=>$messages ]);
			}else{
			$sms->status = 'failed';
			$sms->save();
			return response(['status'=>'error', 'details'=>'An error occurred, please try again.']);
			}
			}else{
			return response(['status'=>'error', 'details'=>'You do not have sms credits.']);
			}
			}else{
			return response(['status'=>'error', 'details'=>'You do not have sms credits.']);
			}
			}
	}
		  public function addcontactgroup(Request $request){

        try{
			if($request->contact_name==''){
				return response(['status'=>'error', 'details'=>"Please enter the contact group name"]);
			}
			else if($request->phone==''){
				return response(['status'=>'error', 'details'=>"Please enter a mobile number"]);
			}

			else{
            $contact = new ContactGroup;
            $contact->name = $request->input('contact_name');
            $contact->phones = $request->input('phone');
			$contact->user_id = Auth::user()->id;
			$contact->company_id = Auth::user()->company_id;
			$contact->save();

            
            return response(['status'=>'success']);
			}
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
			  public function editcontactgroup(Request $request){

        try{
			if($request->contact_name==''){
				return response(['status'=>'error', 'details'=>"Please enter the contact group name"]);
			}
			else if($request->phone==''){
				return response(['status'=>'error', 'details'=>"Please enter a mobile number"]);
			}

			else{
			$contact = ContactGroup::find($request->id);
            $contact->name = $request->input('contact_name');
            $contact->phones = $request->input('phone');
			$contact->save();


            return response(['status'=>'success', 'contact'=>$contact]);
			}
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
			 public function contact_groups()
		{
			session(['skip' => 10]);
			$contacts= ContactGroup::where('company_id',Auth::user()->company_id)
									->where('user_id',Auth::user()->id)
									->skip(0)
									->take(10)
									->orderBy('created_at', 'desc')
									->get();

			return view('contact_groups')->with('contacts',$contacts);
		}
		public function deletecontactgroup(Request $request){
            try {
                 ContactGroup::find($request->delId)->delete();
                return response(['status' => 'success',]);

            }catch(Exception $e){
                return response(['status'=>'error']);

            }
        }
}
