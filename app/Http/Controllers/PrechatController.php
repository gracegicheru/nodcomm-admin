<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Pre_chat_fields;
use App\Pre_chat;
use Illuminate\Support\Facades\DB;
use Auth;
class PrechatController extends Controller
{
    public function __construct()
    {
    $this->middleware('auth');
    }
    public function index()
    {
//dd($_SERVER['DOCUMENT_ROOT'] .'/avatar');
		/*if (Auth::user()->admin && Auth::user()->company_id==0){
        $prechat= Pre_chat::first();
		$fields= Pre_chat_fields::all();
		}else{*/
		$prechat= Pre_chat::where('company_id', Auth::user()->company_id)->first();
		$fields= Pre_chat_fields::where('company_id', Auth::user()->company_id)->get();
		//}
		$data = array(
		'prechat'=>$prechat,
		'fields'=>$fields
		);
        return view('settings.prechat')->with($data);

    }
	public function addprechatsetting(Request $request){

        try{

			
		    if($request->teamname==''){
				return response(['status'=>'error', 'details'=>"Please enter a team name"]);
			}
			else if($request->onlinemsg==''){
				return response(['status'=>'error', 'details'=>"Please enter an online greeting message"]);
			}
            else if($request->offlinemsg==''){
                return response(['status'=>'error', 'details'=>"Please enter an offline greeting message"]);
            } 
			else{
            $prechat = new Pre_chat;
            if($request->hasFile('photo')){


                $filenamewithext = $request->file('photo')->getClientOriginalName();
                $extension = $request->file('photo')->getClientOriginalExtension();
				
                if($extension!='png'&&$extension!='PNG'&&$extension!='jpg'&&$extension!='jpeg'){
				   return response(['status'=>'error', 'details'=>$extension."Please upload a valid image"]);
			    }

			    $fileNameToStore = 'avatar.'.$extension;
                $destinationPath = $_SERVER['DOCUMENT_ROOT'] .'/avatar';
				$request->file('photo')->move($destinationPath, $fileNameToStore);
				$prechat->agents_avatar = $fileNameToStore;
            }

            $prechat->team_name = $request->input('teamname');
            $prechat->online_greeting_msg = $request->input('onlinemsg');
            $prechat->offline_greeting_msg = $request->input('offlinemsg');
			$prechat->company_id = Auth::user()->company_id;
            
            $prechat->save();

            return response(['status'=>'success', 'details'=>$prechat]);
			}
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
	
		public function updateprechatsetting(Request $request){

        try{

			
		    if($request->teamname==''){
				return response(['status'=>'error', 'details'=>"Please enter a team name"]);
			}
			else if($request->onlinemsg==''){
				return response(['status'=>'error', 'details'=>"Please enter an online greeting message"]);
			}
            else if($request->offlinemsg==''){
                return response(['status'=>'error', 'details'=>"Please enter an offline greeting message"]);
            } 
			else{
			$prechat = Pre_chat::find($request->input('id'));
            if($request->hasFile('photo')){

                $filenamewithext = $request->file('photo')->getClientOriginalName();
                //$filename = pathinfo($filenamewithext, PATHINFO_FILENAME);
                $extension = $request->file('photo')->getClientOriginalExtension();
				
                if($extension!='png'&&$extension!='PNG'&&$extension!='jpg'&&$extension!='jpeg'){
				   return response(['status'=>'error', 'details'=>$extension."Please upload a valid image"]);
			    }

			   $fileNameToStore = 'avatar.'.$extension;
			   
			
                $destinationPath = $_SERVER['DOCUMENT_ROOT'] .'/avatar';
				$request->file('photo')->move($destinationPath, $fileNameToStore);
				$prechat->agents_avatar = $fileNameToStore;
				
            }

            $prechat->team_name = $request->input('teamname');
            $prechat->online_greeting_msg = $request->input('onlinemsg');
            $prechat->offline_greeting_msg = $request->input('offlinemsg');

            
            $prechat->save();
            
            return response(['status'=>'success', 'details'=>$prechat]);
			}
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
		public function addprechatfield(Request $request){

        try{
			if(!empty($request->id)){
				 try{
					 $field= Pre_chat_fields::find($request->id);
				     return response(['status'=>'success', 'details'=>$field]);
				    }catch(Exception $e){
					 return response(['status'=>'error']);
					}

			}
			
		    if($request->fieldname==''){
				return response(['status'=>'error', 'details'=>"Please enter a field name"]);
			}
			else{
            $prechat = new Pre_chat_fields;
            $prechat->name = $request->input('fieldname');
            $prechat->visible = $request->input('visible');
            $prechat->required = $request->input('required');
			$prechat->company_id = Auth::user()->company_id;
            
            $prechat->save();
			$fields= Pre_chat_fields::where('company_id', Auth::user()->company_id)->get();
            return response(['status'=>'success', 'details'=>$fields]);
			}
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
	public function editprechatfield(Request $request){

        try{

		    if($request->fieldname==''){
				return response(['status'=>'error', 'details'=>"Please enter a field name"]);
			}
			else{
			$prechat = Pre_chat_fields::find($request->input('id'));
            $prechat->name = $request->input('fieldname');
            $prechat->visible = $request->input('visible');
            $prechat->required = $request->input('required');

            
            $prechat->save();
			$fields= Pre_chat_fields::where('company_id', Auth::user()->company_id)->get();
            return response(['status'=>'success', 'details'=>$fields]);
			}
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
}
