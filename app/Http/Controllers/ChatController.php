<?php

namespace App\Http\Controllers;

use stdClass;
use App\Chat;
use App\User;
use App\Visitor;
use App\Pre_chat;
use App\ChatSession;
use App\Site;
use App\VisitorBrowsingHistory;
use RandomLib\Factory;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ChatController extends Controller
{
    public function __construct(){

    }

    public function index(Request $request){
        $site_id = $request->get('siteId');

        $time = time() - 10; //now minus 10secs
        $agents = User::where('last_activity', '>', $time)->get();

        if($agents->isEmpty()){
            $agents_online = false;
        }else{
            $agents_online = true;
        }

        $settings = Pre_chat::all();

        return view('chat/nodcommchat')->with(['site_id'=>$site_id, 'agents_online'=>$agents_online, 'settings'=>$settings[0]]);
    }

    public function chat_init(Request $request){
        $site_id = $request->get('siteId');

        return view('chat/chat_init')->with('site_id', $site_id);
    }

    public function visitor_init(Request $request){
        $device_info = $request->input('device_info');
        $ip = $request->input('ip');
        $device_info = $request->input('device_info');
        $chats = 0;
        $visits = 1;
        $identifier = '';
        $url = $request->input('url');
        $referrer = $request->input('referrer');
        $user_cookie = $request->input('user_cookie');

        //$geolocation = json_decode(file_get_contents("https://ipinfo.io/{$ip}/json"));
        $geolocation = json_decode(@file_get_contents("http://ip-api.com/json/{$ip}"));

        if(!empty($geolocation)){
            $country = json_decode(@file_get_contents("https://restcountries.eu/rest/v2/alpha/{$geolocation->countryCode}"));
        }else{
            $geolocation = new stdClass;
            $geolocation->city = '-';
            $geolocation->regionName = '-';
            $geolocation->country = '-';
        }

        if(empty($country)){
            $country = new stdClass;
            $country->flag = '-';
        }

        if(empty($ip)){
            $ip = 'Unknown';
        }
        

        if($user_cookie == "not_set"){
            $factory = new Factory;

            $generator = $factory->getMediumStrengthGenerator();
            $visitor_id = $generator->generateString(32, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
			$company = Site::where('site_id',$request->input('site_id'))->first()->company_id;
            $visitor = new Visitor;
            $visitor->ip = $ip;
            $visitor->device_info = json_encode($device_info);
            $visitor->chats = $chats;
            $visitor->visits = $visits;
            $visitor->current_page = $url;
            $visitor->city = $geolocation->city;
            $visitor->region = $geolocation->regionName;
            $visitor->flag = $country->flag;
            $visitor->country = $geolocation->country;
            $visitor->identifier = $visitor_id;
            $visitor->referrer = $referrer;
			$visitor->site = $request->input('site_id');
			$visitor->company = $company;
            $visitor->save();

            return response(['status'=>'success', 'identifier'=>$visitor_id,'visitor'=>$visitor]);
        }else{

            try{
                $visitor = Visitor::where('identifier', $user_cookie)->firstOrFail();

                $chats = $visitor->chats;
                $visits = $visitor->visits;

                $visitor->ip = $ip;
                $visitor->device_info = json_encode($device_info);
                $visitor->visits = $visits + 1;
                $visitor->current_page = $url;
                $visitor->city = $geolocation->city;
                $visitor->region = $geolocation->region;
                $visitor->flag = $country->flag;
                $visitor->country = $country->name;
                $visitor->referrer = $referrer;

                $visitor->save();

                return response(['status'=>'success', 'identifier'=>$user_cookie]);

            }catch(ModelNotFoundException $e){
                $factory = new Factory;

                $generator = $factory->getMediumStrengthGenerator();
                $visitor_id = $generator->generateString(32, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');

                $visitor = new Visitor;
                $visitor->ip = $ip;
                $visitor->device_info = json_encode($device_info);
                $visitor->chats = $chats;
                $visitor->visits = $visits;
                $visitor->current_page = $url;
                $visitor->city = $geolocation->city;
                $visitor->region = $geolocation->region;
                $visitor->flag = $country->flag;
                $visitor->country = $country->name;
                $visitor->identifier = $visitor_id;
                $visitor->referrer = $referrer;

                $visitor->save();

                return response(['status'=>'success', 'identifier'=>$visitor_id]);
            }
        }
    }

    public function start_chat(Request $request){
        $name = $request->input('name');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $message = $request->input('message');
        $identifier = $request->input('identifier');

        if($name != "" && $email != "" && $message != "" && $identifier != ""){
            try{
                $visitor = Visitor::where('identifier', $identifier)->firstOrFail();

                $factory = new Factory;

                $generator = $factory->getMediumStrengthGenerator();
                $session_id = $generator->generateString(32, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');

                $visitor->name = $name;
                $visitor->email = $email;
                $visitor->current_session = $session_id;
                $visitor->chats = $visitor->chats + 1;
                $visitor->chat_waiting = 1;
                $visitor->chat_created = date("Y-m-d H:i:s");
                $visitor->assigned_agent = '';

                $visitor->save();

                $chat = new Chat;
                $chat->visitor_identifier = $identifier;
                $chat->session = $session_id;
                $chat->message = $message;
                $chat->from = "V";
                $chat->to = "A";
                $chat->read = 0;

                $chat->save();

                $chat_session = new ChatSession;
                $chat_session->session_id = $session_id;
                $chat_session->visitor_identifier = $identifier;
                $chat_session->name = $name;
                $chat_session->email = $email;

                $chat_session->save();

                return response(['status'=>'success', 'session'=>$session_id]);

            }catch(ModelNotFoundException $e){
                return response(['status'=>'error', 'message'=>'An error occurred']);
            }
        }else{
            return response(['status'=>'error', 'message'=>'Empty fields not allowed']);
        }
    }

    public function last_activity(Request $request){
        $user_identifier = $request->input('user_identifier');
        $page_title = $request->input('page_title');
        $current_page = $request->input('current_page');
        $init = $request->input('init');
        $referrer = $request->input('referrer');

        if(isset($user_identifier) && !empty($user_identifier)){
            try{
                $visitor = Visitor::where('identifier', $user_identifier)->firstOrFail();
                $time = time();
                $visitor->last_activity = $time;
                if($init == "init"){
                    $visitor->referrer = $referrer;
                }

                $visitor->save();

                $this->track_pages($user_identifier, $current_page, $page_title);

                return response(['status'=>'success', 'time'=>$time]);

            }catch(ModelNotFoundException $e){

            }
        }
    }

    public function agent_status(Request $request){
        $user_identifier = $request->input('user_identifier');
        $page_title = $request->input('page_title');
        $current_page = $request->input('current_page');

        if(isset($user_identifier) && !empty($user_identifier)){
            try{
                $visitor = Visitor::where('identifier', $user_identifier)->firstOrFail();

                if(!empty($visitor->assigned_agent) && $visitor->chat_waiting == 0){
                    $visitor = Visitor::where('identifier', $user_identifier)
                                        ->with('visitor_chats')
                                        ->with('agent')
                                        ->get();

                    $time = time();
                    $_visitor = Visitor::where('identifier', $user_identifier)->first();
                    $_visitor->last_activity = $time;

                    $_visitor->save();

                    $this->track_pages($user_identifier, $current_page, $page_title);

                    return response(['status'=>'success', 'data'=>$visitor]);
                }else{
                    $time = time();
                    $_visitor = Visitor::where('identifier', $user_identifier)->first();
                    $_visitor->last_activity = $time;

                    $_visitor->save();

                    $this->track_pages($user_identifier, $current_page, $page_title);
                    
                    return response(['status'=>'no_agent']);
                }

            }catch(ModelNotFoundException $e){

            }
        }else{
            //
        }
    }

    public function message_status(Request $request){
        $user_identifier = $request->input('user_identifier');
        $page_title = $request->input('page_title');
        $current_page = $request->input('current_page');
        //$session_identifier = $request->input('session_identifier');

        if(isset($user_identifier) && !empty($user_identifier)){
            $visitor = Visitor::where('identifier', $user_identifier)
                                ->with('visitor_chats')
                                ->with('agent')
                                ->get();

            $time = time();
            $_visitor = Visitor::where('identifier', $user_identifier)->first();
            $_visitor->last_activity = $time;

            $_visitor->save();

            $this->track_pages($user_identifier, $current_page, $page_title);

            return response(['status'=>'success', 'data'=>$visitor]);
        }else{
            //
        }
    }

    public function send_message(Request $request){
        $user_identifier = $request->input('user_identifier');
        $message = $request->input('message');

        if(isset($user_identifier) && !empty($user_identifier) && isset($message) && !empty($message)){
            $visitor = Visitor::where('identifier', $user_identifier)->first();

            $chat = new Chat;
            $chat->visitor_identifier = $user_identifier;
            $chat->session = $visitor->current_session;
            $chat->message = $message;
            $chat->from = "V";
            $chat->to = "A";
            $chat->read = 0;

            $chat->save();

            return response(['status'=>'success', 'data'=>$chat]);
        }
    }

    public function load_messages(Request $request){
        $user_identifier = $request->input('user_identifier');
        $session_identifier = $request->input('session_identifier');

        if(isset($user_identifier) && !empty($user_identifier) && isset($session_identifier) && !empty($session_identifier)){
            $visitor = Visitor::where('identifier', $user_identifier)
                                ->where('current_session', $session_identifier)
                                ->with('visitor_chats')
                                ->with('agent')
                                ->get();

            $time = time();
            $_visitor = Visitor::where('identifier', $user_identifier)->first();
            $_visitor->last_activity = $time;

            $_visitor->save();

            if(!$visitor->isEmpty()){
                return response(['status'=>'success', 'data'=>$visitor]);
            }elseif(!$visitor->visitor_chats->isEmpty()){
                return response(['status'=>'no_messages']);
            }else{
                return response(['status'=>'no_messages']);
            }      
        }else{
            //
        }
    }

    public function track_pages($visitor_identifier, $current_page, $page_title){
        $time = time();

        $browsing_history = VisitorBrowsingHistory::where('visitor_identifier', $visitor_identifier)
                                                    ->where('page_url', $current_page)
                                                    ->get();

        if($browsing_history->isEmpty()){
            VisitorBrowsingHistory::create([
                'visitor_identifier' => $visitor_identifier,
                'page_url' => $current_page,
                'page_title' => $page_title,
                'start_time' => $time,
                'end_time' => $time
            ]);
        }else{
            $update_browsing = VisitorBrowsingHistory::find($browsing_history[0]->id);
            $update_browsing->end_time = $time;
            $update_browsing->save();
        }
    }
}
