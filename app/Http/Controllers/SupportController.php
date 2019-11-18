<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Support;
use App\User;
use App\Company;
use Auth;
class SupportController extends Controller
{
     public function __construct()
    {
    $this->middleware('auth');
    }
	    public function index()
    {
		if (Auth::user()->admin && Auth::user()->company_id!=0){
			$messages = Support::where('company_id', Auth::user()->company_id)
								->where('user_id', Auth::user()->id)
								->get();
		        foreach($messages as $message){
				$User=User::where('id','=',$message->user_id);
				$message->{'user'} = $User->first()->name;
				}
		}elseif(Auth::user()->admin==0){
		   $messages = Support::where('company_id', Auth::user()->company_id)
					  ->where('user_id', Auth::user()->id)
					  ->get();
			foreach($messages as $message){
			$User=User::where('id','=',$message->user_id);
			$message->{'user'} = $User->first()->name;
			}
		}else{
			$messages = Support::all();
			 foreach($messages as $message){
			$User=User::where('id','=',$message->user_id);
			$message->{'user'} = $User->first()->name;
			
			$company=Company::where('id','=',$message->company_id);
			$message->{'company'} = $company->first()->name;
			}
		}


       return view('support')->with('messages', $messages);
//		->with('disabled',1)
    }
			    public function sendmessage(Request $request){

        try{

			if($request->message==''){
				return response(['status'=>'error', 'details'=>"Please write a brief description of your problem"]);
			}
			else{


			$support = new Support;
			$support->support_description = $request->input('message');
			$support->user_id=Auth::user()->id;
			$support->company_id=Auth::user()->company_id;
			$support->solved=0;

			$support->save();

			if (Auth::user()->admin){
				$messages = Support::where('company_id', Auth::user()->company_id)->get();
			}else{
			   $messages = Support::where('company_id', Auth::user()->company_id)
						  ->where('user_id', Auth::user()->id)
						  ->get();
			}
			 foreach($messages as $message){
				$User=User::where('id','=',$message->user_id);
				$message->{'user'} = $User->first()->name;
			}
			return response(['status'=>'success', 'details'=>$messages]);
			}
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
		 public function marksolved(Request $request){

        try{

            $support = Support::find($request->input('id'));
            $support->solved =1;

            $support->save();
		
			$messages = Support::all();
			 foreach($messages as $message){
			$User=User::where('id','=',$message->user_id);
			$message->{'user'} = $User->first()->name;
			
			$company=Company::where('id','=',$message->company_id);
			$message->{'company'} = $company->first()->name;
			}
            
            return response(['status'=>'success', 'details'=>$messages]);
			
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
			 public function markunsolved(Request $request){

        try{

            $support = Support::find($request->input('id'));
            $support->solved =0;

            $support->save();
		
			$messages = Support::all();
			 foreach($messages as $message){
			$User=User::where('id','=',$message->user_id);
			$message->{'user'} = $User->first()->name;
			
			$company=Company::where('id','=',$message->company_id);
			$message->{'company'} = $company->first()->name;
			}
            
            return response(['status'=>'success', 'details'=>$messages]);
			
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }		  
}
