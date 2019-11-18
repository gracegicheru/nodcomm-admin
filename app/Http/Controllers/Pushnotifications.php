<?php

namespace App\Http\Controllers;
use stdClass;
use Auth;
use Illuminate\Http\Request;
use Minishlink\WebPush\WebPush;
use App\Pushnotification;
class Pushnotifications extends Controller
{
		 public function __construct()
		{
		
		}
		public function push_init(Request $request){
        $company_id = $request->get('y');
		$site_id = $request->get('x');

        return view('push.push_init')->with('site_id', $site_id)->with('company_id', $company_id);
		}
		public function add_subscription(Request $request){

        try{
			
			$post_body = file_get_contents('php://input');

			$post_body = json_decode($post_body);
			$ip=$post_body->ip;
			$geolocation = json_decode(@file_get_contents("http://ip-api.com/json/{$ip}"));

			if(!empty($geolocation) && $geolocation->status!='fail'){
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
			

			$subscription = new Pushnotification;
			$subscription->endpoint = $post_body->subscription->endpoint;
			$subscription->expiration_time = $post_body->subscription->expirationTime;
			$subscription->p256dh = $post_body->subscription->keys->p256dh;
			$subscription->auth = $post_body->subscription->keys->auth;
			$subscription->company_id =$post_body->company_id;
			$subscription->website_id =$post_body->site_id;
			$subscription->ip=$ip;
			$subscription->city = $geolocation->city;
            $subscription->region = $geolocation->regionName;
            $subscription->flag = $country->flag;
            $subscription->country = $geolocation->country;
			$subscription->device_info = $post_body->device_info;

			$subscription->save();

			
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
		public function push_close(){
		session(['push_ui_close' =>true]);
	}
		/*public function send_notification(){
	    $endpoints = [];

		//$query = $this->db->get_where("push_notifications_subscriptions", ['user_type'=>1])->result();
		$query = Pushnotification::all();
		if(!empty($query)){
			foreach ($query as $row) {
				$endpoints[] = [
						'endpoint' => $row->endpoint,
						'p256dh' => $row->p256dh,
						'auth' => $row->auth
				];
			}

			//print_r($endpoints); return;

			$auth = array(
			    //'GCM' => 'MY_GCM_API_KEY', // deprecated and optional, it's here only for compatibility reasons
			    'VAPID' => array(
			      //  'subject' => 'mailto:admin@writenod.com',
					'subject' => 'mailto:brendah.k@mambo.co.ke',
			        'publicKey' => 'BH5yhWUwomgwwXJdpS5xuzHLLDMcHyJT3rpNErsxA-xrZ6LTnUANvaxj6MrP94E_V-ov-LggGr4kWhxv14IaLIA',
			        'privateKey' => 'K-vS_yDpSC0iBYs1yDo65mL0MMZEb6d9Ss3BL_ilAnY'
			    ),
			);

			$webPush = new WebPush($auth);

			//$notifications = [];

			foreach ($endpoints as $endpoint) {
				// $notifications[] = [
				// 	'endpoint' => $endpoint->endpoint,
    //     			'payload' => $message,
    //     			'userAuthToken' => $endpoint->auth
				// ];
				$data = [
					'title' => "Nodcomm Promotion",
					'message' => "Hello, we are happy to introduce a new coupon called Eureka. The coupon will be effective from today. Regards Nodcomm Team",
					'icon'=>"/images/push-notification.png",
				];

				$webPush->sendNotification(
			        $endpoint["endpoint"],
			       // $message,
				   json_encode($data),
			        $endpoint["p256dh"], // optional (defaults null)
			        $endpoint["auth"]
			    );

			    var_dump($webPush->flush());
			}
		}
		}*/
}
