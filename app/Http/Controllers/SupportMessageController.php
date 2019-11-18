<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Support_Message;
use App\Support;
use App\User;
use App\Company;
use Auth;
class SupportMessageController extends Controller
{
     public function __construct()
    {
    $this->middleware('auth');
    }
	public function supportmessage($id){

		$messages = Support_Message::where('support_id', $id)
    						->orderBy('created_at', 'asc')
    						->get();
		foreach($messages as $message){
		$user=User::find($message->user_id);
		$message->user=$user;
		}
		$support_message=Support::find($id);
		$company=Company::find($support_message->company_id);
		$data = array(
		'support_message'=>$support_message,
		'company'=>$company->name,
		'messages'=>$messages
		);
		if(Auth::user()->company_id==0){
		return view('support_message')->with($data);
		}else{
			
			if(Auth::user()->id==$support_message->user_id){
			
			 return view('support_personal_message')->with($data);
			}else{
			$otheruser=User::find($support_message->user_id);
			$data['user']=$otheruser;
			 return view('support_other_person_message')->with($data);
			}			 
		}
    }
	   public function sendmessage(Request $request){

        try{

			if($request->message==''){
				return response(['status'=>'error', 'details'=>"Please enter a message"]);
			}
			else{

			$support = new Support_Message;
			$support->description = $request->input('message');
			$support->user_id=Auth::user()->id;
			$support->company_id=Auth::user()->company_id;
			$support->support_id=$request->input('id');

			$support->save();

			$user=User::find(Auth::user()->id);
			$support->user=$user->name;
			$support->time=date("D M j Y G:i:s",strtotime($support->created_at));
			return response(['status'=>'success', 'details'=>$support]);
			}
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
}
