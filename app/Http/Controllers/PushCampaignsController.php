<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\PushCampaigns;
use App\Pushnotification;
use App\Push_sites;
use Auth;
use App\Exceptions\Handler;
use RandomLib\Factory;

class PushCampaignsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
	private $push_notification ;
    public function __construct()
    {
        $this->middleware('auth');
		$this->push_notification = new Pushnotification();
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

		if (Auth::user()->admin && Auth::user()->company_id==0){
    	$campaigns = PushCampaigns::all();
		$sites = Push_sites::all();
		}else{
		$campaigns = PushCampaigns::where('company_id', Auth::user()->company_id)->get();
		$sites = Push_sites::where('company_id', Auth::user()->company_id)->get();
		}

        return view('push.push_campaigns')->with('sites', $sites)->with('campaigns', $campaigns);
    }

    public function send_notification(Request $request){
        try{

			if($request->message_title==''){
				return response(['status'=>'error', 'details'=>"Please enter the compaign title"]);
			}elseif($request->message_text==''){
				return response(['status'=>'error', 'details'=>"Please enter the campaign  content"]);
			}elseif($request->url=='' || $request->site_id==''){
				return response(['status'=>'error', 'details'=>"Please select a website you are creating a campaign for"]);
			}
			else{
			$query = Pushnotification::where('website_id', $request->input('site_id'))->get();
            if(count($query)>0){
			$campaign = new PushCampaigns;
            $campaign->web_push_title = $request->input('message_title');
            $campaign->web_push_text = $request->input('message_text');
			$campaign->web_push_link = $request->input('url');
            $campaign->site_id = $request->input('site_id');
			$campaign->company_id = Auth::user()->company_id;

		
            $campaign->save();
			
			$message = [
					'title' =>  $request->input('message_title'),
					'message' => $request->input('message_text'),
					'icon'=>"/images/push-notification.png",
				];
			$this->push_notification->send_notification($query,$message);
			
            $campaigns = PushCampaigns::where('company_id', Auth::user()->company_id)->get();
			
            return response(['status'=>'success', 'campaigns'=>$campaigns]);
			}else{
				return response(['status'=>'error', 'details'=>"This website has no subscribers."]);
			}
		}
	   }catch(Exception $e){
            return response(['status'=>'error']);
        }    
    }

    public function view_site($id){
        $site = Push_sites::find($id);

        if(is_null($site)){
            return view('view_push_site')->with('site', $site);
        }else{
            return view('view_push_site')->with('site', $site);
        }
        //dd($site);
    }

    public function edit_site(Request $request){

			if($request->site_name==''){
				return response(['status'=>'error', 'details'=>"Please enter the website name"]);
			}elseif($request->site_url==''){
				return response(['status'=>'error', 'details'=>"Please enter the website url"]);
			}else{
				$site_id = $request->input('site_id');
				$site_name = $request->input('site_name');
				$site_url = $request->input('site_url');
				if(isset($site_id) && !empty($site_id) && isset($site_name) && !empty($site_name) && isset($site_url) && !empty($site_url)){

					$site = Push_sites::find($site_id);

					if(is_null($site)){
						echo json_encode(['status'=>'error', 'details'=>'An error occurred when updating the website']);
					}else{
						$site->name = $site_name;
						$site->url = $site_url;

						$site->save();

						echo json_encode(['status'=>'success', 'details'=>'Website updated successfully']);
					}
					
				}else{
					echo json_encode(['status'=>'error', 'details'=>'An error occurred when updating the website. Please try again']);
				}
			}
    }

}
