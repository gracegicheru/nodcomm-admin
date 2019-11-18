<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Post_chat_field;
use App\PostChatSetting;
use Auth;
class PostchatController extends Controller
{
        public function __construct()
    {
    $this->middleware('auth');
    }
    public function index()
    {

	   /* if (Auth::user()->admin && Auth::user()->company_id==0){
        $postchat= PostChatSetting::first();
		$fields= Post_chat_field::all();
		}else{*/
		$postchat= PostChatSetting::where('company_id', Auth::user()->company_id)->first();
		$fields= Post_chat_field::where('company_id', Auth::user()->company_id)->get();
		//}
		
		$data = array(
		'postchat'=>$postchat,
		'fields'=>$fields
		);
        return view('settings.postchat')->with($data);

    }
		public function addpostchatsetting(Request $request){

        try{
			 if($request->greetingmsg==''){
				return response(['status'=>'error', 'details'=>"Please enter a greeting message"]);
			}

			else{
            $postchat = new PostChatSetting;
            $postchat->greeting_msg = $request->input('greetingmsg');
			$postchat->company_id = Auth::user()->company_id;
            $postchat->save();

            return response(['status'=>'success', 'details'=>$postchat]);
			}
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
		public function updatepostchatsetting(Request $request){

        try{
			 if($request->greetingmsg==''){
				return response(['status'=>'error', 'details'=>"Please enter a greeting message"]);
			}

			else{
			$postchat = PostChatSetting::find($request->input('id'));
            $postchat->greeting_msg = $request->input('greetingmsg');

            $postchat->save();

            return response(['status'=>'success', 'details'=>$postchat]);
			}
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
	public function addpostchatfield(Request $request){

        try{
			if(!empty($request->id)){
				 try{
					 $field= Post_chat_field::find($request->id);
				     return response(['status'=>'success', 'details'=>$field]);
				    }catch(Exception $e){
					 return response(['status'=>'error']);
					}

			}
			
		    if($request->fieldname==''){
				return response(['status'=>'error', 'details'=>"Please enter a field name"]);
			}
			else{
            $postchat = new Post_chat_field;
            $postchat->name = $request->input('fieldname');
            $postchat->visible = $request->input('visible');
            $postchat->required = $request->input('required');
			$postchat->company_id = Auth::user()->company_id;
            
            $postchat->save();
			$fields= Post_chat_field::where('company_id', Auth::user()->company_id)->get();
            return response(['status'=>'success', 'details'=>$fields]);
			}
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
	public function editpostchatfield(Request $request){

        try{

		    if($request->fieldname==''){
				return response(['status'=>'error', 'details'=>"Please enter a field name"]);
			}
			else{
			$postchat = Post_chat_field::find($request->input('id'));
            $postchat->name = $request->input('fieldname');
            $postchat->visible = $request->input('visible');
            $postchat->required = $request->input('required');

            
            $postchat->save();
			$fields= Post_chat_field::where('company_id', Auth::user()->company_id)->get();
            return response(['status'=>'success', 'details'=>$fields]);
			}
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
}
