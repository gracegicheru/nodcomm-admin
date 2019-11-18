<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Push_sites;
use App\Pushnotification;
use App\PushCampaigns;
use Auth;
use App\Exceptions\Handler;
use RandomLib\Factory;

class PushSitesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

		/*if (Auth::user()->admin && Auth::user()->company_id==0){
    	$sites = Push_sites::all();
		}else{*/
		$sites = Push_sites::where('company_id', Auth::user()->company_id)->get();
		//}

        return view('push_sites')->with('sites', $sites);
    }

    public function addsite(Request $request){
        try{
			$site = Push_sites::where('name',$request->name)->first();

			if($request->name==''){
				return response(['status'=>'error', 'details'=>"Please enter the website name"]);
			}else if(!empty($site)){
				return response(['status'=>'error', 'details'=>"This domain name is already selected. Please choose a new domain name"]);
			}elseif($request->url==''){
				return response(['status'=>'error', 'details'=>"Please enter the website url"]);
			}else{
            $factory = new Factory;

            $generator = $factory->getMediumStrengthGenerator();
            $site_id = $generator->generateInt(101, 99999);
			
			   $code = "<!--Begin NodComm Push Notification Code-->".
               "<script type='text/javascript'>".
               "var NodPush = {x: ".$site_id.", y: ".Auth::user()->id."};".
        	   "var NodPush_lc = document.createElement('script');".
    		   "NodPush_lc.type = 'text/javascript';".
    		   "NodPush_lc.async = true;".
    		   "NodPush_lc.src = '".url('/')."/push/init?x=' + NodPush.x+'&y='+NodPush.y;".
    		   "document.body.appendChild(NodPush_lc);".
               "</script>".
			  '<script type="text/javascript" src="'.url('/assets/js/userip1.js').'"></script>'.
			  '<script src="'.url('/assets/js/ua-parser.min.js').'"></script>'.
               "<!--End NodComm Push Notification  Code-->";

            $site = new Push_sites;
            $site->name = $request->input('name');
            $site->url = $request->input('url');
            $site->site_id = $site_id;
            $site->code = $code;
			$site->company_id = Auth::user()->company_id;

		
            $site->save();

            $sites = Push_sites::where('company_id', Auth::user()->company_id)->get();

            return response(['status'=>'success', 'code'=>$code, 'sites'=>$sites]);
		}
	   }catch(Exception $e){
            return response(['status'=>'error']);
        }    
    }

    public function view_site($id){

		$site = Push_sites::where('name', $id)->first();
        if(is_null($site)){
            return view('view_push_site')->with('site', $site);
        }else{
			$subscribers =Pushnotification::where('website_id', $site->site_id)->get();
			foreach ($subscribers as $visitor) {
				
            $device = json_decode($visitor->device_info);
            if(!empty($device )){
            $visitor->{'browser'} = $device->browser->name . " ver" .$device->browser->major;
            $visitor->{'os'} = $device->os->name . " " . $device->os->version;
			}
            $visitor->{'data_json'} = json_encode($visitor);
			}
			$today_subscribers = Pushnotification::whereDate('created_at', date('Y-m-d'))
                ->get();
		    $campaigns = PushCampaigns::where('site_id', $site->site_id)->get();

			$data = array(
			'site'=>$site,
			'subscribers'=>$subscribers,
			'today_subscribers'=>$today_subscribers,
			'campaigns'=>$campaigns
			);
            return view('view_push_site')->with($data);
        }

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
