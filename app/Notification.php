<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mandrill;
use Auth;
class Notification extends Model
{


    	public function send_sms($phone_number,$message,$alphanumeric  ) {
		$api = Website::where('name', '=', 'nodcomm')->first();
		$username = $api->api_id;
	    $password = $api->api_key;

	    $response = '';
		
	/*	if (Auth::check()) {
		if(Auth::user()->company_id==0){
			$alphanumeric='Nodcomm';
		}else{
		 $sender_id_cost= SenderIDPayment::whereRaw('company_id = ? and verified = ?',[Auth::user()->company_id,1])
					->first();
		if(empty($sender_id_cost)){
			$alphanumeric='Nodcomm';
		}else{
			$alphanumeric=$sender_id_cost->sender_id;
		}
		}
		}
		else{
			$alphanumeric='Nodcomm';
		}*/
	    //get auth token
	    $curl = curl_init();
	    $auth = base64_encode($username.':'.$password);

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.nodcomm.com/v1/auth",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_HTTPHEADER => array(
		    "Authorization: Basic {$auth}",
		    "Cache-Control: no-cache"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  return FALSE;
		} else {
		  $response = json_decode($response);
		}

		$data = [
			'message' => $message,
			'msisdn' => $phone_number,
			//'gateway' => 'africastalking',
			//'alphanumeric' => 'mambo'
			//'gateway' => 'bulksms',
			//'alphanumeric' => 'Nodcomm'
	         'gateway' => 'infobip',
			 'alphanumeric' => $alphanumeric
			 
			
		];

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.nodcomm.com/v1/messages/send",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_POST => 1,
		  CURLOPT_POSTFIELDS => http_build_query($data),
		  CURLOPT_HTTPHEADER => array(
		    "Authorization: Bearer {$response->access_token}",
		    "Cache-Control: no-cache"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		return $response;

		curl_close($curl);

		if ($err) {
		  return FALSE;
		} else {
		  $response = json_decode($response);

		  if($response->status == "success"){

		  	return TRUE;
		  }else{
		  	return FALSE;
		  }
		}
	}
		  public function sendMailMandrill( $email,$html,$text, $subject ) {
        $mandrill_ready = NULL;
        try {
			$mandrill = new Mandrill();

            $mandrill_api_key= Setting::where('config_key','mandrill_api_key')->first();

			$mandrill->init($mandrill_api_key->config_value);


			$mandrill_ready = TRUE;
        } catch ( Mandrill_Exception $e ) {
            $mandrill_ready = FALSE;
        }

        if ( $mandrill_ready ) {
            //Send us some email!
           // $html = $this->emailtemplate( $username, $code );

            $from_email= Setting::where('config_key','from_email')->first();
//added code

            $email1 = array(
                'html' => $html, //Consider using a view file
                'text' => $text,
                'subject' => $subject,
				'from_email' => $from_email->config_value,

                'from_name' => 'Nodcomm Admin',
                'to' => array( array( 'email' => $email ) ) //Check documentation for more details on this one
                //'to' => array(array('email' => 'joe@example.com' ),array('email' => 'joe2@example.com' )) //for multiple emails
            );
            $result = $mandrill->messages_send( $email1 );


            if ( !empty( $result ) ) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }
}
