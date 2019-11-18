<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\AddSiteRequest;
use App\Site;
use Auth;
use App\Visitor;
use App\Exceptions\Handler;
use RandomLib\Factory;

class SitesController extends Controller
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

		if (Auth::user()->admin && Auth::user()->company_id==0){
    	$sites = Site::all();
		}else{
		$sites = Site::where('company_id', Auth::user()->company_id)->get();
		}

        return view('sites')->with('sites', $sites)->with('disabled',1);
    }
	    public function companysites($id){

		$sites= Site::where('company_id','=' , $id)->get();

		$data = array(
		'sites'=>$sites
		);

		return view('company_sites')->with('sites', $sites);
    }
    public function addsite(AddSiteRequest $request){
        try{
            $factory = new Factory;

            $generator = $factory->getMediumStrengthGenerator();
            $site_id = $generator->generateInt(101, 99999);

        	$code = "<!--Begin NodComm Chat Code-->".
               "<script type='text/javascript'>".
               "var NodChat = {site_id: ".$site_id."};".
        	   "var NodChat_lc = document.createElement('script');".
    		   "NodChat_lc.type = 'text/javascript';".
    		   "NodChat_lc.async = true;".
    		  // "NodChat_lc.src = '".url('/')."/chat/init?siteId=' + NodChat.site_id;".
    		   "NodChat_lc.src = 'https://chat.nodcomm.com/chat/init?siteId=' + NodChat.site_id;".
			   "document.body.appendChild(NodChat_lc);".
               "</script>".
               "<!--End NodComm Live Chat Code-->";

            $site = new Site;
            $site->name = $request->input('name');
            $site->url = $request->input('url');
            $site->site_id = $site_id;
            $site->code = $code;
			$site->company_id = Auth::user()->company_id;
			$site->gcode=$request->input('gcode');
		
            $site->save();

            $sites = Site::where('company_id', Auth::user()->company_id)->get();

            return response(['status'=>'success','name'=>$request->input('name'),'url'=>$request->input('url'),'site_id'=>$site_id,'gcode'=>$request->input('gcode'),'company_id'=>Auth::user()->company_id, 'code'=>$code, 'sites'=>$sites]);
        }catch(Exception $e){
            return response(['status'=>'error']);
        }    
    }

    public function view_site($id){
        $site = Site::find($id);

        if(is_null($site)){
            return view('view_site')->with('site', $site);
        }else{
            return view('view_site')->with('site', $site);
        }
        //dd($site);
    }

    public function edit_site(Request $request){
        $site_id = $request->input('site_id');
        $site_name = $request->input('site_name');
        $site_url = $request->input('site_url');

        if(isset($site_id) && !empty($site_id) && isset($site_name) && !empty($site_name) && isset($site_url) && !empty($site_url)){

            $site = Site::find($site_id);

            if(is_null($site)){
                echo json_encode(['status'=>'error', 'details'=>'An error occurred when updating the website']);
            }else{
                $site->name = $site_name;
                $site->url = $site_url;

                $site->save();
				
                echo json_encode(['status'=>'success','site_id'=>$site->site_id,'name'=>$site_name,'url'=>$site_url, 'details'=>'Website updated successfully']);
            }
            
        }else{
            echo json_encode(['status'=>'error', 'details'=>'An error occurred when updating the website. Please try again']);
        }
    }
		   	public function view_site_visitors($id)
    {
			$visitors = Site::find($id);
			foreach ($visitors->visitors as $visitor) {
            $device = json_decode($visitor->device_info);
            // $country = json_decode(file_get_contents("https://restcountries.eu/rest/v2/alpha/{$geolocation->country}"));

            $visitor->{'browser'} = $device->browser->name . " ver" .$device->browser->major;
            $visitor->{'os'} = $device->os->name . " " . $device->os->version;

            $visitor->{'data_json'} = json_encode($visitor);
        }
			$data = array(
			'visitors'=>$visitors
			);
			
			return view('site_visitors')->with($data);
	}
		public function firebase_sites(){
		$sites= Site::all();
		return response(['status'=>'success', 'details'=>$sites]);
	}
}
