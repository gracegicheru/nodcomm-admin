<?php

namespace App\Http\Controllers;

use Auth;
use App\Chat;
use App\Visitor;
use App\Site;
use App\User;
use App\Company;
use App\ChatSession;
use App\BannedVisitor;
use App\VisitorBrowsingHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminChatController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
		if (Auth::user()->admin && Auth::user()->company_id==0){
        $visitor = new Visitor;

		$visitors = Site::with('visitors')
					->get();
        $_visitors = $visitors;

        foreach ($visitors as $v) {
			foreach($v->visitors as $visitor){
			
            $device = json_decode($visitor->device_info);

            $visitor->{'browser'} = $device->browser->name . " ver" .$device->browser->major;
            $visitor->{'os'} = $device->os->name . " " . $device->os->version;

            $visitor->{'data_json'} = json_encode($visitor);
			$visitor->{'agent'} = User::find($visitor->assigned_agent);

			}
		}

		}else{
	    $visitors = Site::with('visitors')
					->where('company_id', Auth::user()->company_id)
					->get();


        foreach ($visitors as $v) {
			foreach($v->visitors as $visitor){
			
            $device = json_decode($visitor->device_info);

            $visitor->{'browser'} = $device->browser->name . " ver" .$device->browser->major;
            $visitor->{'os'} = $device->os->name . " " . $device->os->version;

            $visitor->{'data_json'} = json_encode($visitor);
			$visitor->{'agent'} = User::find($visitor->assigned_agent);

			}
		}
		}
		
        $chat = new Chat;
        $time = time() - 10;
        $agent = Auth::user();

        $chats = Chat::join('visitors', 'chats.session', '=', 'visitors.current_session')
                    ->select(DB::raw('count(*) as chat_count, visitor_identifier, session, GROUP_CONCAT(chats.id) _id'))
                    ->where('visitors.last_activity', '>', $time)
                    ->where('visitors.assigned_agent', $agent->id)
                    ->with('visitor')
                    ->with('visitor.agent')
                    ->groupBy('session')
                    ->get();

        foreach ($chats as $chat) {
            $ids = explode(',', $chat->_id);
            $chat->{'messages'} = Chat::find($ids);
            $chat->visitor->device_info = json_decode($chat->visitor->device_info);
        }

        return view('adminchat')->with('visitors', $visitors)->with('chats', $chats);
    }
    public function all_visitors(){


		$visitors = Site::with('visitors')
					->get();
        $_visitors = $visitors;

        foreach ($visitors as $v) {
			
			$v->company = Company::find($v->company_id);
			foreach($v->visitors as $visitor){
			
            $device = json_decode($visitor->device_info);

            $visitor->{'browser'} = $device->browser->name . " ver" .$device->browser->major;
            $visitor->{'os'} = $device->os->name . " " . $device->os->version;

            $visitor->{'data_json'} = json_encode($visitor);
			$visitor->{'agent'} = User::find($visitor->assigned_agent);

			}
		}
//dd(count($visitors));
        return view('all_visitors')->with('visitors', $visitors);
    }
	    public function companyvisitors($id){

		    $sites = Company::with('sites')->where('id',$id)->first();

			foreach($sites->sites as $site){
			$site_visitors = Visitor::where('site',$site->id)->get();

			$site->{'totalvisitors'}=count($site_visitors);
			}


		return view('visitors_per_company')->with('sites', $sites);
    }
    public function online_visitors(){
        $time = time() - 10; //now minus 10secs

        
		if (Auth::user()->admin && Auth::user()->company_id==0){
			$visitors = Visitor::where('last_activity', '>', $time)->get();
		}else{

			$visitors = DB::table('visitors')
					->join('users', 'users.id', '=', 'visitors.assigned_agent')
					->join('sites', 'sites.id', '=', 'visitors.site')
					->where('users.company_id','=', Auth::user()->company_id)
					->where('sites.company_id','=', Auth::user()->company_id)
					->where('visitors.last_activity', '>', $time)
					->get();
		}
        if($visitors->isEmpty()){
            return response(['status'=>'no_visitors']);
        }else{
            foreach ($visitors as $visitor) {
                $device = json_decode($visitor->device_info);

                $visitor->{'browser'} = $device->browser->name . " ver" .$device->browser->major;
                $visitor->{'os'} = $device->os->name . " " . $device->os->version;

                if(empty($visitor->assigned_agent)){
                    $visitor->agent = '-';
                }else{
                    $visitor->agent = User::find($visitor->assigned_agent);
                }
            }

            return response(['status'=>'success', 'data'=>$visitors]);
        }
    }

    public function active_chats(){
        $agent = Auth::user();
        $time = time() - 10;

        $visitors = Visitor::where('last_activity', '>', $time)
                            ->where('agent', $agent->id)
                            ->whereNotNull('current_session')
                            ->with('visitor_chats')
                            ->with('assigned_agent')
                            ->latest('chat_created')
                            ->get();

        if(!$visitors->isEmpty()){
            return response(['status'=>'success', 'data'=>$visitors]);
        }else{
            return response(['status'=>'no_active_chats']);
        }
        // $visitor->visitor_chats
    }

    public function accept_chat(Request $request){
        $agent = Auth::user();

        $id = $request->input('id');

        if(isset($id) && !empty($id)){
            $visitor = Visitor::find($id);
            $active_chat = null;

            if($visitor){
                $visitor->assigned_agent = $agent->id;
                $visitor->chat_waiting = 0;
                $visitor->save();

                $chat_session = ChatSession::where('session_id', $visitor->current_session)->first();
                $chat_session->agent = $agent->id;
                $chat_session->save();

                $chat = new Chat;

                $time = time() - 10;
                $agent = Auth::user();

                $chats = Chat::join('visitors', 'chats.session', '=', 'visitors.current_session')
                            ->select(DB::raw('count(*) as chat_count, visitor_identifier, session, GROUP_CONCAT(chats.id) _id'))
                            ->where('visitors.last_activity', '>', $time)
                            ->where('visitors.assigned_agent', $agent->id)
                            ->with('visitor')
                            ->with('visitor.agent')
                            ->groupBy('session')
                            ->get();

                foreach ($chats as $chat) {
                    if($chat->session == $visitor->current_session){
                        $ids = explode(',', $chat->_id);
                        $chat->{'messages'} = Chat::find($ids);
                        $active_chat = $chat;
                    }
                }

                return response(['status'=>'success', 'data'=>$visitor, 'chats'=>$chats, 'active_chat'=>$active_chat]);
            }else{
                return response(['status'=>'error']);
            }
        }else{
            return response(['status'=>'error']);
        }
    }

    public function check_messages(Request $request){
        $chat = new Chat;

        $time = time() - 10;
        $agent = Auth::user();

        $chats = Chat::join('visitors', 'chats.session', '=', 'visitors.current_session')
                    ->select(DB::raw('count(*) as chat_count, visitor_identifier, session, GROUP_CONCAT(chats.id) _id'))
                    ->where('visitors.last_activity', '>', $time)
                    ->where('visitors.assigned_agent', $agent->id)
                    ->with('visitor')
                    ->with('visitor.agent')
                    ->groupBy('session')
                    ->get();

        foreach ($chats as $chat) {
            $ids = explode(',', $chat->_id);
            $chat->{'messages'} = Chat::find($ids);
        }

        $_time = time();
        $agent->last_activity = $_time;
        $agent->save();

        //dd($chats);
        if(!$chats->isEmpty()){
            return response(['status'=>'success', 'data'=>$chats]);
        }else{
            return response(['status'=>'no_active_chats']);
        }
    }

    public function send_message(Request $request){
        $session = $request->input('session');
        $message = $request->input('message');

        if(isset($message) && !empty($message) && isset($session) && !empty($session)){
            $visitor = Visitor::where('current_session', $session)->first();

            $chat = new Chat;
            $chat->message = $message;
            $chat->visitor_identifier = $visitor->identifier;
            $chat->session = $session;
            $chat->from = 'A';
            $chat->to = 'V';
            $chat->read = 0;

            $chat->save();

            return response(['status'=>'success', 'data'=>$chat]);
        }
    }

    public function ban_visitor(Request $request){
        $visitor_identifier = $request->input('visitor_identifier');

        if(isset($visitor_identifier) && !empty($visitor_identifier)){
            $visitor = Visitor::where('identifier', $visitor_identifier)->first();

            $banned_visitor = new BannedVisitor;

            $banned_visitor->visitor_identifier = $visitor->identifier;
            $banned_visitor->visitor_ip = $visitor->ip;
            $banned_visitor->visitor_email = $visitor->email;

            $banned_visitor->save();

            return response(['status'=>'success']);
        }
    }

    public function get_chat_messages(Request $request){
        $session = $request->input('session');

        if(isset($session) && !empty($session)){
            $chat = new Chat;

            $agent = Auth::user();

            $chats = Chat::join('visitors', 'chats.session', '=', 'visitors.current_session')
                        ->select(DB::raw('chats.*'))
                        ->where('chats.session', $session)
                        ->where('visitors.assigned_agent', $agent->id)
                        ->with('visitor')
                        ->with('visitor.agent')
                        ->get();

            //dd($chats);
            return response(['status'=>'success', 'data'=>$chats]);
        }else{
            return response(['status'=>'error', 'details'=>'An unknown error occurred. Please try again']);
        }
    }

    public function user_navigation(Request $request){
        $visitor_identifier = $request->input('identifier');

        if(isset($visitor_identifier) && !empty($visitor_identifier)){
            $visitor = Visitor::where('current_session', $visitor_identifier)
                                ->first();

            $visitor_browsing = VisitorBrowsingHistory::where('visitor_identifier', $visitor->identifier)
                                                        ->orderBy('start_time', 'asc')
                                                        ->get();

            foreach ($visitor_browsing as $row) {
                $seconds = $row->end_time - $row->start_time;
                $H = floor($seconds / 3600);
                $i = ($seconds / 60) % 60;
                $s = $seconds % 60;

                $time = '';
                if($H > 0){
                    $time .= $H . 'hrs ';
                }
                if($i > 0){
                    $time .= $i . 'mins ';
                }if($s > 0){
                    $time .= $s . 'sec';
                }

                $row->{"time"} = $time;
            }

            return response(['status'=>'success', 'data'=>$visitor_browsing]);
        }
    }

    public function chat_history(Request $request){
        $session = $request->input('session');

        if(isset($session) && !empty($session)){
            $visitor = Visitor::where('current_session', $session)
                                ->first();
            $chat_sessions = ChatSession::where('visitor_identifier', $visitor->identifier)
                                        ->where('session_id', '!=', $session)
                                        ->with('messages')
                                        ->orderBy('created_at')
                                        ->get();

            foreach ($chat_sessions as $chat_session) {
                $date = $chat_session->messages[0]->created_at;
                $chat_session->messages[0]->{'message_time'} = $date->format('d/m/Y H:i a');
            }

            
            return response(['status'=>'success', 'data'=>$chat_sessions]);
        }
    }

    public function archived_chat_messages(Request $request){
        $session = $request->input('session');

        if(isset($session) && !empty($session)){
            $chat = new Chat;

            $agent = Auth::user();

            // $chats = Chat::join('visitors', 'chats.session', '=', 'visitors.current_session')
            //             ->select(DB::raw('chats.*'))
            //             ->where('chats.session', $session)
            //             ->where('visitors.assigned_agent', $agent->id)
            //             ->with('visitor')
            //             ->with('visitor.agent')
            //             ->get();

            $chats = ChatSession::where('session_id', $session)
                                ->with('messages')
                                ->with('agent')
                                ->get();

            //dd($chats);
            return response(['status'=>'success', 'data'=>$chats]);
        }else{
            return response(['status'=>'error', 'details'=>'An unknown error occurred. Please try again']);
        }
    }
	

	public function view_onqueue_visitors()
    {
			$visitors = DB::table('sites')
				  ->join('visitors', 'visitors.site', '=', 'sites.id')
				  ->whereNull('assigned_agent')
				  ->where('sites.company_id', Auth::user()->company_id)
				  ->get();
			$agents = User::where('company_id', Auth::user()->company_id)->get();
			foreach ($visitors as $visitor) {
            $device = json_decode($visitor->device_info);


            $visitor->{'browser'} = $device->browser->name . " ver" .$device->browser->major;
            $visitor->{'os'} = $device->os->name . " " . $device->os->version;

            $visitor->{'data_json'} = json_encode($visitor);
        }
			$data = array(
			'visitors'=>$visitors,
			'agents'=>$agents
			);
			
			return view('visitors_on_queue')->with($data);
	}
	
		public function assignagent(Request $request){

        try{
			if(Auth::user()->admin==1){
			if($request->agent_id==''){
				return response(['status'=>'error', 'details'=>"Please select an agent"]);
			}
			else{
            $visitor = Visitor::find($request->input('id'));
            $visitor->assigned_agent = $request->input('agent_id');


            $visitor->save();
		
			$visitors = DB::table('sites')
				  ->join('visitors', 'visitors.site', '=', 'sites.id')
				  ->whereNull('assigned_agent')
				  ->where('sites.company_id', Auth::user()->company_id)
				  ->get();
			foreach ($visitors as $row) {
            $device = json_decode($row->device_info);


            $row->{'browser'} = $device->browser->name . " ver" .$device->browser->major;
            $row->{'os'} = $device->os->name . " " . $device->os->version;

        }
           
           
			}
		}else{
		    $visitor = Visitor::find($request->input('vid'));
            $visitor->assigned_agent = Auth::user()->id;


            $visitor->save();
		
			$visitors = DB::table('sites')
				  ->join('visitors', 'visitors.site', '=', 'sites.id')
				  ->whereNull('assigned_agent')
				  ->where('sites.company_id', Auth::user()->company_id)
				  ->get();
			foreach ($visitors as $row) {
            $device = json_decode($row->device_info);


            $row->{'browser'} = $device->browser->name . " ver" .$device->browser->major;
            $row->{'os'} = $device->os->name . " " . $device->os->version;

        }
		}
		return response(['status'=>'success', 'details'=>$visitors]);
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
}
