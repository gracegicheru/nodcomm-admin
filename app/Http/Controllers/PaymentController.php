<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;
use App\Company;
use Auth;
use RandomLib\Factory;
use Session;
use App\CURL_Util;
use App\Setting;
use App\SMSPayment;
use App\MpesaSMSPayment;
use App\MpesaSenderIDPayment;
use App\SMSCredit;
use App\SenderIDPayment;
use App\User;
use App\SenderIDPaymentwithCredits;
use PDF;
use App\Notification;
use App\SenderID;
use App\PaypalSMSPayment;
ini_set('max_execution_time', 180);
class PaymentController extends Controller
{
	public function __construct()
    {
    $this->middleware('auth');
	$this->notification = new Notification();
    }

	public function pay(Request $request){
		$cart = Session::get('shopping_cart');

	if(!empty($cart['TOKEN']) && !empty($cart['PAYMENTINFO_0_TRANSACTIONID']) && $cart['ACK'] == 'Success')
	{

			$payment = new Payment;
		    $payment->txn_id = $cart['PAYMENTINFO_0_TRANSACTIONID'];
            $payment->payment_gross = $cart['PAYMENTINFO_0_AMT'];
			$payment->currency_code =$cart['PAYMENTINFO_0_CURRENCYCODE'];
			$payment->payment_status =$cart['PAYMENTINFO_0_PAYMENTSTATUS'];
			$payment->payment_method =$cart['PAYMENTINFO_0_PAYMENTTYPE'];
			$payment->payment_date = $cart['PAYMENTINFO_0_ORDERTIME'];
            $payment->payer_id =$cart['PAYMENTINFO_0_SECUREMERCHANTACCOUNTID'];
			$payment->cart =$cart['TOKEN'];
			$payment->customer_email =$cart['PAYMENTINFO_0_SECUREMERCHANTACCOUNTID'];
			
			$payment->save();
			$company = Company::find(Auth::user()->company_id);
			$company->paid =1;
			$company->save();	
	
	}
		}
	public
	function createPayment(Request $request) {
			$factory = new Factory;
			$generator = $factory->getLowStrengthGenerator();
			$number  = $generator->generateString(4, '123456789');
			$pp_username = 'xanton94-facilitator_api1.gmail.com'; 
			$pp_password = '92MRPRF2QRL9AW69'; 
			$pp_signature = 'AFcWxV21C7fd0v3bYYYRCpSSRl31AmFGKjy2F8Kdx2uiAREun-ep-1Ed'; 

			//$pp_username = Setting::where('config_key','paypal_username')->first()->config_value;
			//$pp_password = Setting::where('config_key','paypal_password')->first()->config_value;
			//$pp_signature = Setting::where('config_key','paypal_signature')->first()->config_value;
			$pp_logo = Setting::where('config_key','paypal_logo')->first()->config_value;
			$pp_bg_color = Setting::where('config_key','paypal_bg_color')->first()->config_value;
			$paypal_service = Setting::where('config_key','paypal_service')->first()->config_value;
		
		//echo $_POST['curr'];
		$company = Company::where('id',Auth::user()->company_id)->first();
		$mydata = array(
			'USER' => $pp_username,
			'PWD' => $pp_password,
			'SIGNATURE' => $pp_signature,
			'METHOD' => 'SetExpressCheckout',
			'VERSION' => 124.0,
			'PAYMENTREQUEST_0_AMT' => $request->input('amount'),
			'PAYMENTREQUEST_0_CURRENCYCODE' => 'USD',
			'PAYMENTREQUEST_0_PAYMENTACTION' => 'SALE',
			'PAYMENTREQUEST_0_SELLERPAYPALACCOUNTID' => 'admin@amexwrite.com',
			'PAYMENTREQUEST_0_DESC' => $company->name,
			'PAYMENTREQUEST_0_INVNUM' => $company->name,
			'cancelUrl' => url('/dashboard'),
			'returnUrl' => url('/dashboard'),
			'PAYMENTREQUEST_0_ITEMAMT' => $request->input('amount'), // ammount 

			'L_PAYMENTREQUEST_0_NAME0' =>  $company->fname.' '. $company->lname,
			'L_PAYMENTREQUEST_0_NUMBER0' => $number, // order id
			'L_PAYMENTREQUEST_0_QTY0' => 1,
			'L_PAYMENTREQUEST_0_AMT0' => $request->input('amount'), // amount
			'L_PAYMENTREQUEST_0_DESC0' => $company->name
		);


		session(['amt' => $request->input('amount')]);
		session(['number' => $number]);


		$postdata = http_build_query( $mydata );
		//$url = 'https://api-3t.paypal.com/nvp';
		$url = 'https://api-3t.sandbox.paypal.com/nvp';
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $postdata );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		$response = curl_exec( $ch );
		curl_close( $ch );
		if ( $response ) {



			$res = explode( '&', $response );
			/*$response_array would be something like
			[
			"TOKEN=EC%2d0VF85491NF796042N",
			"TIMESTAMP=2014%2d06%2d26T17%3a03%3a34Z",
			"CORRELATIONID=8b60fba0145f7",
			"ACK=Success",
			"VERSION=109%2e0",
			"BUILD=11624049"
			]*/

			//Cover string format to key value pair
			$response_pair = array();
			foreach ( $res as $val_string ) {
				$response_val_pair = explode( "=", $val_string );
				$response_pair[ $response_val_pair[ 0 ] ] = urldecode( $response_val_pair[ 1 ] );

			}
			//echo $response_pair['ACK'];
			if ( $response_pair[ 'ACK' ] == 'Success' ) {

				$ch = curl_init( $url );

				$params = array(
					'method' => 'GetExpressCheckoutDetails',
					'token' => $response_pair[ 'TOKEN' ],
					'version' => 124.0,
					'user' => $pp_username,
					'pwd' => $pp_password,
					'signature' => $pp_signature,
					'PAYMENTREQUEST_0_AMT' => $request->input('amount'),
					'PAYMENTREQUEST_0_CURRENCYCODE' => 'USD',
					'PAYMENTREQUEST_0_PAYMENTACTION' => 'SALE',
					'PAYMENTREQUEST_0_SELLERPAYPALACCOUNTID' => 'admin@amexwrite.com',
					'PAYMENTREQUEST_0_DESC' => $company->name,
					'PAYMENTREQUEST_0_INVNUM' => $company->name,
					'cancelUrl' => url('/dashboard'),
					'returnUrl' => url('/dashboard'),
				);

				curl_setopt( $ch, CURLOPT_POST, true );
				curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $params ) );
				curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
				curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 1 );
				curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 2 );

				$response2 = curl_exec( $ch );
				curl_close( $ch );


				$response_array = explode( '&', $response2 );
				$response_pair2 = array();
				foreach ( $response_array as $val_string2 ) {
					$response_val_pair2 = explode( "=", $val_string2 );
					$response_pair2[ $response_val_pair2[ 0 ] ] = urldecode( $response_val_pair2[ 1 ] );

				}

				if ( $response_pair2[ 'ACK' ] == 'Success' ) {
					echo '{"TOKEN":"' . $response_pair2[ 'TOKEN' ] . '"}';
					session(['expr_check_dets' => $response_pair2]);
				} else {
					echo $response_pair2[ 'ACK' ];
				}

				//echo "{'token':$token[1]}";
			} else {
				echo 'error2';
			}

		} else {
			echo 'error';
		}


		//include_once('Checkout.php');
		//$pay = new Checkout();
		//echo json_encode($pay->createPayment());
	}




	public
	function completePayment(Request $request) {
			$company = Company::where('id',Auth::user()->company_id)->first();
			//$pp_username = Setting::where('config_key','paypal_username')->first()->config_value;
			//$pp_password = Setting::where('config_key','paypal_password')->first()->config_value;
			//$pp_signature = Setting::where('config_key','paypal_signature')->first()->config_value;
			$pp_username = 'xanton94-facilitator_api1.gmail.com'; 
			$pp_password = '92MRPRF2QRL9AW69'; 
			$pp_signature = 'AFcWxV21C7fd0v3bYYYRCpSSRl31AmFGKjy2F8Kdx2uiAREun-ep-1Ed'; 
			$pp_logo = Setting::where('config_key','paypal_logo')->first()->config_value;
			$pp_bg_color = Setting::where('config_key','paypal_bg_color')->first()->config_value;
			$paypal_service = Setting::where('config_key','paypal_service')->first()->config_value;
		
		//$ch = new CURL_Util( 'https://api-3t.paypal.com/nvp', array(
		$ch = new CURL_Util( 'https://api-3t.sandbox.paypal.com/nvp', array(
			'USER' => $pp_username,
			'PWD' => $pp_password,
			'SIGNATURE' => $pp_signature,
			'METHOD' => 'SetExpressCheckout',
			'VERSION' => 124.0,
			'TOKEN' => $_POST[ 'paymentToken' ],
			'PAYERID' => $_POST[ 'payerId' ],
			'cancelUrl' => url('/dashboard'),
			'returnUrl' => url('/dashboard'),
			'PAYMENTREQUEST_0_AMT' => Session::get('amt'),
			"PAYMENTREQUEST_0_NUMBER" => Session::get('number'),
			'PAYMENTREQUEST_0_PAYMENTACTION' => 'Sale',
			'PAYMENTREQUEST_0_SELLERPAYPALACCOUNTID' => 'admin@amexwrite.com',
			'PAYMENTREQUEST_0_DESC' => $company->name,
			'PAYMENTREQUEST_0_INVNUM' => $company->name,
			'PAYMENTREQUEST_0_CURRENCYCODE' => 'USD',
			'PAYMENTREQUEST_0_ITEMAMT' => Session::get('amt'), // ammount 

			'L_PAYMENTREQUEST_0_NAME0' => $company->fname.' '.$company->lname,
			'L_PAYMENTREQUEST_0_NUMBER0' => Session::get('number'), // order id
			'L_PAYMENTREQUEST_0_QTY0' => 1,
			'L_PAYMENTREQUEST_0_AMT0' => Session::get('amt'), // amount
			'L_PAYMENTREQUEST_0_DESC0' => $company->name
		) );

		$response = $ch->exec();
		$redirect_url = '';

		if ( $response[ 'ACK' ] == 'Success' ) {
			$post_values = array(

				"METHOD" => "DoExpressCheckoutPayment",
				"VERSION" => 124.0,
				"USER" => $pp_username,
				"PWD" => $pp_password,
				"SIGNATURE" => $pp_signature,
				"PAYMENTREQUEST_0_PAYMENTACTION" => "Sale",

				'TOKEN' => $_POST[ 'paymentToken' ],
				'PAYERID' => $_POST[ 'payerId' ],
				"PAYMENTREQUEST_0_AMT" =>Session::get('amt'),
				"PAYMENTREQUEST_0_NUMBER" => Session::get('number'),
				'cancelUrl' => url('/dashboard'),
				'returnUrl' => url('/dashboard'),
				'PAYMENTREQUEST_0_SELLERPAYPALACCOUNTID' => 'admin@amexwrite.com',
				'PAYMENTREQUEST_0_DESC' => $company->name,
				'PAYMENTREQUEST_0_INVNUM' =>$company->name,
				'PAYMENTREQUEST_0_CURRENCYCODE' =>'USD',
				'PAYMENTREQUEST_0_ITEMAMT' => Session::get('amt')
			);

			//$request = curl_init(); // initiate curl object
			//curl_setopt($ch,CURLOPT_URL ,'https://api-3t.sandbox.paypal.com/nvp');
			//curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
			//curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
			//curl_setopt($request, CURLOPT_POSTFIELDS, $post_values); // use HTTP POST to send form data
			//curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response.
			//$post_response = curl_exec($request); // execute curl post and store results in $post_response
			//curl_close ($post_response);

			$chs = curl_init();
			//curl_setopt( $chs, CURLOPT_URL, 'https://api-3t.paypal.com/nvp' );
			curl_setopt( $chs, CURLOPT_URL, 'https://api-3t.sandbox.paypal.com/nvp' );
			curl_setopt( $chs, CURLOPT_VERBOSE, 1 );
			curl_setopt( $chs, CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt( $chs, CURLOPT_SSL_VERIFYHOST, false );
			curl_setopt( $chs, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt( $chs, CURLOPT_HTTPGET, true );
			curl_setopt( $chs, CURLOPT_POSTFIELDS, http_build_query( $post_values ) );
			$post_response = curl_exec( $chs );
		//	print_r($post_response);

			$response_array = explode( "&", $post_response );
			$final_response_val_pair_array = array();
			foreach ( $response_array as $val_string ) {
				$response_val_pair = explode( "=", $val_string );
				$final_response_val_pair_array[ $response_val_pair[ 0 ] ] = urldecode( $response_val_pair[ 1 ] );
			}

			if ( $final_response_val_pair_array[ 'ACK' ] == 'Success' ) {

				/*
				Every thing good, save the order to db and unset cart data in $_SEESION. Something like:
				$order = new Orders(); ... $order->save(); $_SESSION["cart"];
				Then redirect the user to a thankyou page
				*/

				// Set example cart data into session									
				$paid = Company::find($company->id);
				$paid->paid =1;
				$paid->save();
				session(['shopping_cart' => $final_response_val_pair_array]);
				$redirect_url =  url('/dashboard');


			} else {
				//error handling for the third/final apis call, DoExpressCheckoutPayment
				$msg = "error_code=" . $final_response_val_pair_array[ 'L_ERRORCODE0' ];
				$msg .= "&message=" . $final_response_val_pair_array[ 'L_LONGMESSAGE0' ];
				//$final_response_val_pair_array['L_SHORTMESSAGE0'];
			   $redirect_url = url('/dashboard');

			}


		} else {
			//error handling for the third/final apis call, DoExpressCheckoutPayment
			$msg = "error_code=" . $response[ 'L_ERRORCODE0' ];
			$msg .= "&message=" . $response[ 'L_LONGMESSAGE0' ];
			//$final_response_val_pair_array['L_SHORTMESSAGE0'];
		$redirect_url = url('/dashboard');


		}

		echo '{"redirect":"' . $redirect_url . '"}';
	}
	
		function generateWalletToken(){
		$curl = curl_init();
		$username = "s2JsmtRUEiksSOCC5Z5YebK9cgDpRd7Q";
		$password = "X3y0fEa20hZzmtUe";
		
		//$username = "a4fshyOTDdZdjZj1uXut2O2kUnO8CHni";
		//$password = "9acHtiqSfc1xbDm6";

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.mambowallet.com/v1/oauth/token/?grant_type=client_credentials",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_HTTPHEADER => array(
			"Authorization: Basic ".base64_encode("$username:$password")
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  return "";// "cURL Error #:" . $err;
		} else {
		  $feedback = json_decode($response);
		 //var_dump($feedback);
		  return $feedback->access_token;
		}
	}
	function paymentamount(Request $request) {
			if($request->amount==''){
				return response(['status'=>'error', 'details'=>"Please select a credit category"]);
			}else{
			if(Session::has('amount_payed'))
			{
				Session::forget('amount_payed');
				session(['amount_payed' => $request->amount]);				
			}else{
				session(['amount_payed' => $request->amount]);
			}
				
				//return response(['status'=>'success','amount_payed'=>$request->amount]);
				return response(['status'=>'success','details'=>url('/purchase/credit')]);
			}
		
	}
		function paymentamount1(Request $request) {
			if($request->amount==''){
				return response(['status'=>'error', 'details'=>"Please select a credit category"]);
			}else{
			if(Session::has('amount_payed'))
			{
				Session::forget('amount_payed');
				session(['amount_payed' => $request->amount]);				
			}else{
				session(['amount_payed' => $request->amount]);
			}
			$cost = Setting::where('config_key','sender_id_cost')->first()->config_value;
			$SMSCredit = SMSCredit::where('user_id', Auth::user()->id)->first();
			if(!empty($SMSCredit)){
				$credits = $SMSCredit->credit;
				$total = floatval($credits) + floatval($request->amount);
			}else{
				$total = floatval($request->amount);
			}	
			if($total<$cost){
				return response(['status'=>'error', 'details'=>"Your credits are still insufficient to buy a sender id"]);
			}
			session(['redirect' => 1]);
			return response(['status'=>'success','details'=>url('/sms/senderID')]);
			}
		
	}
	function smspayment(Request $request) {
		$p_token=$request->token;
		$curl = curl_init();
		$token = $this->generateWalletToken();
		$amount = Session::get('amount_payed');
		$sms_credit_amount = Setting::where('config_key','sms_credit_amount')->first()->config_value;
		//$credit =  ($amount/$sms_credit_amount) * 100;
		$credit = $amount;
		$factory = new Factory;
		$generator = $factory->getLowStrengthGenerator();
		$code = "mp_".$generator->generateString(16, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
		/**************** pay with card ****************/
		if(isset($_POST["token"]) && !empty($_POST["token"]) && isset($_POST["txn_ref"]) && !empty($_POST["txn_ref"])){

		$postData = json_encode(array("token"=>$p_token,
		  "amount"=>Session::get('amount_payed') * 100, 		  
		  "currency"=>'KES', //'USD'
		  "remarks"=>"Payment for SMS Credit "
		  ));
		  

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.mambowallet.com/v1/card/requestpay/",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => $postData,
		  CURLOPT_HTTPHEADER => array(
			"Authorization: Bearer ".$token,
			"Content-Type: application/json"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);
		$r_data = [];
		if ($err) {

		  Session::forget('amount_payed');
		  
		  $r_data = array('status'=> False,"redirect"=> url('/purchase/credits'),"error"=>$err);
		} else {
			$response_data = json_decode($response);

		    if (isset($response_data->Results) && !empty($response_data->Results)){
				if ($response_data->Results->ResultCode == 0){
				// add correct page redirection and save data to the transactions
				// my payment reaches here a successfull one  
				session(['mw_transaction' => [$response_data->Transaction, $amount]]);
				$payment = new SMSPayment;
				$payment->amount = $amount;
				$payment->charge = Session::get('mw_transaction')[0]->transaction->charge;
				$payment->currency = Session::get('mw_transaction')[0]->transaction->currency;
				$payment->reference = Session::get('mw_transaction')[0]->transaction->reference;
				$payment->time = Session::get('mw_transaction')[0]->transaction->time;
				$payment->identifier = Session::get('mw_transaction')[0]->transaction->identifier;
				$payment->card_id = Session::get('mw_transaction')[0]->transaction->id;
				$payment->expiry = Session::get('mw_transaction')[0]->card->expiry;
				$payment->type = Session::get('mw_transaction')[0]->card->type;
				$payment->card = Session::get('mw_transaction')[0]->card->card;
				$payment->credit = $credit;
				$payment->user_id = Auth::user()->id;
				$payment->company_id = Auth::user()->company_id;
				$payment->save();

				$SMSCredit = SMSCredit::where('user_id', Auth::user()->id)->first();
				
				if(empty($SMSCredit)){
				$credits = new SMSCredit;
				$credits->credit = $credit;
				$credits->user_id = Auth::user()->id;
				$credits->company_id = Auth::user()->company_id;
				$credits->save();
				}else{
				$finalcredit = $credit + floatval($SMSCredit->credit);
				$SMSCredit->credit = $finalcredit;
				$SMSCredit->save();
				}
				Session::forget('amount_payed');
				/*if($this->notification->sendMailMandrill(Auth::user()->email, $this->emailtemplate(Auth::user()->name,Session::get('mw_transaction')[0]->transaction->reference,Auth::user()->phone,Auth::user()->email,Auth::user()->address,$amount,'Card'),'Credits Purchase','Credits Purchase')){
					//success
					$r_data = array("status"=>True,"redirect"=>url('/purchase/credits'));
					}else{
					//return response(['status'=>'error', 'details'=>'An error occured while sending your credits purchase email.Please contact the administrator']);
					$r_data = array("status"=> False,"redirect"=> url('/purchase/credits'),"feedback"=>$response_data);
					}*/
				try{
					$this->notification->sendMailMandrill(Auth::user()->email, $this->emailtemplate(Auth::user()->name,Session::get('mw_transaction')[0]->transaction->reference,Auth::user()->phone,Auth::user()->email,Auth::user()->address,$amount,'Card'),'Credits Purchase','Credits Purchase');
				}catch(Exception $e){
					return response(['status'=>False]);
				}
				$r_data = array("status"=>True,"redirect"=>url('/purchase/credits'));
				}else{
				    Session::forget('mw_transaction');
					$r_data = array("status"=> False,"redirect"=> url('/purchase/credits'),"feedback"=>$response_data);
				}
			}else{
				Session::forget('mw_transaction');
				$r_data = array("status"=> False,"redirect"=> url('/purchase/credits'),"feedback"=>$response_data);
			}
           
		}
		echo json_encode($r_data );
	}
	/**************** pay with card ****************/
			/**************** pay with mpesa ****************/
		if(isset($_POST["action"]) && !empty($_POST["action"]) && isset($_POST["phone_number"]) && !empty($_POST["phone_number"]) && isset($_POST["account"]) && !empty($_POST["account"]) && isset($_POST["txn_ref"]) && !empty($_POST["txn_ref"])){
			$account = $_POST["account"];
		    $phone_number = $_POST["phone_number"];
		    $narration = $_POST["description"];
		    $user_ip = $_POST["userip"];
		    $deviceinfo = '';
		    $money = $amount;
			//$mpesacredit =  ($money/$sms_credit_amount);
			$mpesacredit = $amount;
		    $txn_ref = $_POST["txn_ref"];
			session(['phone_number' => $phone_number]);
			session(['user_ip' => $user_ip]);
			session(['deviceinfo' => $deviceinfo]);
			session(['money' => $money]);
			session(['mpesacredit' => $mpesacredit]);
			session(['txn_ref' => $txn_ref]);
		     $lnk = "https://dashboard.mambowallet.com/";


		    $r_data = [];

		    $username = "X3y0fEa20hZzmtUe"; //consumer_key
			$password = "s2JsmtRUEiksSOCC5Z5YebK9cgDpRd7Q"; //consumer_secret

		    $post = [
		        'account' => $account,
		        'number' => $phone_number,
		        'naration' => $narration,
		        'userIp' => $user_ip,
		        'deviceinfo' => $deviceinfo,
		        'cash' => $money,
		        'api_key' => $username,
		        'api_secret' => $password
		    ];

		    $curl = curl_init();
		    curl_setopt_array($curl, array(
		      CURLOPT_URL => $lnk."initiatepayment/",
		      CURLOPT_RETURNTRANSFER => true,
		      CURLOPT_ENCODING => "",
		      CURLOPT_MAXREDIRS => 10,
		      CURLOPT_TIMEOUT => 30,
		      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		      CURLOPT_CUSTOMREQUEST => "POST",
		      CURLOPT_POSTFIELDS => json_encode($post),
		    ));

		    $response = curl_exec($curl);
		    $err = curl_error($curl);

		    curl_close($curl);

		    if($err){
		        $r_data = array('status'=> False,"error"=>$err);
		    }else{
		        $res = json_decode($response);
		        if($res->status == "ok"){
		            $r_data = array('status'=> True, 'key'=>$res->CheckoutRequestID);
		        }else{
		            $r_data = array('status'=> False,"error"=>$res->details);
		        }
		    }

		    echo json_encode($r_data);
		}
		/**************** pay with mpesa ****************/


		/**************** complete pay with mpesa ****************/
		if(isset($_POST["key"]) && !empty($_POST["key"]) && isset($_POST["txn_ref"]) && !empty($_POST["txn_ref"])){
		    $post = [
		        'token' => $_POST["key"],
		    ];

		    $lnk = "https://dashboard.mambowallet.com/";

		    $curl = curl_init();
		    curl_setopt_array($curl, array(
		      CURLOPT_URL => $lnk."completepay/",
		      CURLOPT_RETURNTRANSFER => true,
		      CURLOPT_ENCODING => "",
		      CURLOPT_MAXREDIRS => 10,
		      CURLOPT_TIMEOUT => 30,
		      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		      CURLOPT_CUSTOMREQUEST => "POST",
		      CURLOPT_POSTFIELDS => json_encode($post)
		    ));

		    $response = curl_exec($curl);
		    $err = curl_error($curl);

		    curl_close($curl);
			
		    if($err){
		        $r_data = array('status'=> False,"error"=>$err);
		    }else{
				
		        $res = json_decode($response);
		        if($res->status == "ok"){
		            if($res->state == "complete"){
		                //mark invoice paid

						$payment = new MpesaSMSPayment;
						$payment->amount = Session::get('money');
						$payment->phone_number = Session::get('phone_number');
						$payment->currency = 'KES';
						//$payment->reference = Session::get('txn_ref');
						$payment->reference = $code;
						$payment->time = time();
						$payment->deviceinfo = Session::get('deviceinfo');
						$payment->user_ip =  Session::get('user_ip');
						$payment->credit = Session::get('mpesacredit');
						$payment->user_id = Auth::user()->id;
						$payment->company_id = Auth::user()->company_id;
						$payment->save();
						

						
						$SMSCredit = SMSCredit::where('user_id', Auth::user()->id)->first();
						if(empty($SMSCredit)){
						$credits = new SMSCredit;
						$credits->credit = $credit;
						$credits->user_id = Auth::user()->id;
						$credits->company_id = Auth::user()->company_id;
						$credits->save();
						}else{
						$finalcredit = $credit + floatval($SMSCredit->credit);
						$SMSCredit->credit = $finalcredit;
						$SMSCredit->save();
						}
						Session::forget('amount_payed');
		                $redirect_url = url('/purchase/credits');

		                
		          		/*if($this->notification->sendMailMandrill(Auth::user()->email, $this->emailtemplate(Auth::user()->name,$code,Auth::user()->phone,Auth::user()->email,Auth::user()->address,$amount,'Mpesa'),'Credits Purchase','Credits Purchase')){
						//success
						$r_data = array('status'=> "complete", "redirect"=>$redirect_url);
						}else{
						//return response(['status'=>'error', 'details'=>'An error occured while sending your credits purchase email.Please contact the administrator']);
						$r_data = array('status'=> "error");
						}*/
					try{
						$this->notification->sendMailMandrill(Auth::user()->email, $this->emailtemplate(Auth::user()->name,$code,Auth::user()->phone,Auth::user()->email,Auth::user()->address,$amount,'Mpesa'),'Credits Purchase','Credits Purchase');
					}catch(Exception $e){
						return response(['status'=>"error"]);
					}
					$r_data = array('status'=> "complete", "redirect"=>$redirect_url);
				  }elseif($res->state == "incomplete"){
		                $r_data = array('status'=> "incomplete", "details"=>$res->info);
		            }elseif($res->state == "stalled"){
		                $r_data = array('status'=> "incomplete", "details"=>$res->info);
		            }
		        }else{
		            $r_data = array('status'=> "error");
		        }
		    }

		    echo json_encode($r_data);
		}
		/**************** complete pay with mpesa ****************/

		/**************** verify pay with mpesa ****************/
		if(isset($_POST["action"]) && !empty($_POST["action"]) && isset($_POST["account"]) && !empty($_POST["account"])){
			if($_POST["action"] == "verify"){
				$post = [
			        'token' => $_POST["account"],
			    ];

			    $lnk = "https://dashboard.mambowallet.com/";

			    $curl = curl_init();
			    curl_setopt_array($curl, array(
			      CURLOPT_URL => $lnk."verifypay/",
			      CURLOPT_RETURNTRANSFER => true,
			      CURLOPT_ENCODING => "",
			      CURLOPT_MAXREDIRS => 10,
			      CURLOPT_TIMEOUT => 30,
			      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			      CURLOPT_CUSTOMREQUEST => "POST",
			      CURLOPT_POSTFIELDS => json_encode($post)
			    ));

			    $response = curl_exec($curl);
			    $err = curl_error($curl);

			    curl_close($curl);

			    if($err){
			        $r_data = array('status'=> False,"error"=>$err);
			    }else{
			        $res = json_decode($response);
			        if($res->status == "ok"){
			            if($res->state == "completed"){
			            	//mark invoice paid here
							$payment = new MpesaSMSPayment;
							$payment->amount = Session::get('money');
							$payment->phone_number = Session::get('phone_number');
							$payment->currency = 'KES';
							//$payment->reference = Session::get('txn_ref');
							$payment->reference = $code;
							$payment->time = time();
							$payment->deviceinfo = Session::get('deviceinfo');
							$payment->user_ip =  Session::get('user_ip');
							$payment->credit = Session::get('mpesacredit');
							$payment->user_id = Auth::user()->id;
							$payment->company_id = Auth::user()->company_id;
							$payment->save();
							
							

							$SMSCredit = SMSCredit::where('user_id', Auth::user()->id)->first();
							if(empty($SMSCredit)){
							$credits = new SMSCredit;
							$credits->credit = $credit;
							$credits->user_id = Auth::user()->id;
							$credits->company_id = Auth::user()->company_id;
							$credits->save();
							}else{
							$finalcredit = $credit + floatval($SMSCredit->credit);
							$SMSCredit->credit = $finalcredit;
							$SMSCredit->save();
							}
							Session::forget('amount_payed');
		                
			            	$redirect_url = url('/purchase/credits');

			                $r_data = array('status'=> True, "redirect"=>$redirect_url);
						  /*  if($this->notification->sendMailMandrill(Auth::user()->email, $this->emailtemplate(Auth::user()->name,$code,Auth::user()->phone,Auth::user()->email,Auth::user()->address,$amount,'Mpesa'),'Credits Purchase','Credits Purchase')){
							//success
							$r_data = array('status'=> "complete", "redirect"=>$redirect_url);
							}else{
							//return response(['status'=>'error', 'details'=>'An error occured while sending your credits purchase email.Please contact the administrator']);
							$r_data = array('status'=> "error");
							}*/
							
						  try{
							$this->notification->sendMailMandrill(Auth::user()->email, $this->emailtemplate(Auth::user()->name,$code,Auth::user()->phone,Auth::user()->email,Auth::user()->address,$amount,'Mpesa'),'Credits Purchase','Credits Purchase');
							}catch(Exception $e){
								return response(['status'=>"error"]);
							}
							$r_data = array('status'=> "complete", "redirect"=>$redirect_url);
			            }else{
			                $r_data = array('status'=> False,"details"=>"Verification failed. Please ensure you have paid before verifying");
			            }
			        }else{
			            $r_data = array('status'=> False,"details"=>"Verification failed. Please ensure you have paid before verifying");
			        }
			    }

			    echo json_encode($r_data);
			}
		}

		/**************** verify pay with mpesa ****************/
	}
		function smspayment1(Request $request) {
		$p_token=$request->token;
		$curl = curl_init();
		$token = $this->generateWalletToken();
		$amount = Session::get('amount_payed');
		$sms_credit_amount = Setting::where('config_key','sms_credit_amount')->first()->config_value;
		//$credit =  ($amount/$sms_credit_amount) * 100;
		$credit = $amount;
		$factory = new Factory;
		$generator = $factory->getLowStrengthGenerator();
		$code = "mp_".$generator->generateString(16, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
		/**************** pay with card ****************/
		if(isset($_POST["token"]) && !empty($_POST["token"]) && isset($_POST["txn_ref"]) && !empty($_POST["txn_ref"])){

		$postData = json_encode(array("token"=>$p_token,
		  "amount"=>Session::get('amount_payed') * 100, 		  
		  "currency"=>'KES', //'USD'
		  "remarks"=>"Payment for SMS Credit "
		  ));
		  

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.mambowallet.com/v1/card/requestpay/",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => $postData,
		  CURLOPT_HTTPHEADER => array(
			"Authorization: Bearer ".$token,
			"Content-Type: application/json"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);
		$r_data = [];
		if ($err) {

		  Session::forget('amount_payed');
		  
		  $r_data = array('status'=> False,"redirect"=> url('/sms/senderID'),"error"=>$err);
		} else {
			$response_data = json_decode($response);

		    if (isset($response_data->Results) && !empty($response_data->Results)){
				if ($response_data->Results->ResultCode == 0){
				// add correct page redirection and save data to the transactions
				// my payment reaches here a successfull one  
				session(['mw_transaction' => [$response_data->Transaction, $amount]]);
				$payment = new SMSPayment;
				$payment->amount = $amount;
				$payment->charge = Session::get('mw_transaction')[0]->transaction->charge;
				$payment->currency = Session::get('mw_transaction')[0]->transaction->currency;
				$payment->reference = Session::get('mw_transaction')[0]->transaction->reference;
				$payment->time = Session::get('mw_transaction')[0]->transaction->time;
				$payment->identifier = Session::get('mw_transaction')[0]->transaction->identifier;
				$payment->card_id = Session::get('mw_transaction')[0]->transaction->id;
				$payment->expiry = Session::get('mw_transaction')[0]->card->expiry;
				$payment->type = Session::get('mw_transaction')[0]->card->type;
				$payment->card = Session::get('mw_transaction')[0]->card->card;
				$payment->credit = $credit;
				$payment->user_id = Auth::user()->id;
				$payment->company_id = Auth::user()->company_id;
				$payment->save();
	
				
				$SMSCredit = SMSCredit::where('user_id', Auth::user()->id)->first();
				if(empty($SMSCredit)){
				$credits = new SMSCredit;
				$credits->credit = $credit;
				$credits->user_id = Auth::user()->id;
				$credits->company_id = Auth::user()->company_id;
				$credits->save();
				}else{
				$finalcredit = $credit + floatval($SMSCredit->credit);
				$SMSCredit->credit = $finalcredit;
				$SMSCredit->save();
				}
				session(['sender_id_credits' => 'paid']);
				Session::forget('amount_payed');
				/* if($this->notification->sendMailMandrill(Auth::user()->email, $this->emailtemplate(Auth::user()->name,Session::get('mw_transaction')[0]->transaction->reference,Auth::user()->phone,Auth::user()->email,Auth::user()->address,$amount,'Card'),'Credits Purchase','Credits Purchase')){
					//success
					$r_data = array("status"=>True,"redirect"=>url('/sms/senderID'));
					}else{
					//return response(['status'=>'error', 'details'=>'An error occured while sending your credits purchase email.Please contact the administrator']);
					$r_data = array("status"=> False,"redirect"=> url('/sms/senderID'),"feedback"=>$response_data);
					}*/
					try{
						$this->notification->sendMailMandrill(Auth::user()->email, $this->emailtemplate(Auth::user()->name,Session::get('mw_transaction')[0]->transaction->reference,Auth::user()->phone,Auth::user()->email,Auth::user()->address,$amount,'Card'),'Credits Purchase','Credits Purchase');
					}catch(Exception $e){
						return response(['status'=>False]);
					}
				$r_data = array("status"=>True,"redirect"=>url('/sms/senderID'));
				}else{
				    Session::forget('mw_transaction');
					$r_data = array("status"=> False,"redirect"=> url('/sms/senderID'),"feedback"=>$response_data);
				}
			}else{
				Session::forget('mw_transaction');
				$r_data = array("status"=> False,"redirect"=> url('/sms/senderID'),"feedback"=>$response_data);
			}
           
		}
		echo json_encode($r_data );
	}
	/**************** pay with card ****************/
			/**************** pay with mpesa ****************/
		if(isset($_POST["action"]) && !empty($_POST["action"]) && isset($_POST["phone_number"]) && !empty($_POST["phone_number"]) && isset($_POST["account"]) && !empty($_POST["account"]) && isset($_POST["txn_ref"]) && !empty($_POST["txn_ref"])){
			$account = $_POST["account"];
		    $phone_number = $_POST["phone_number"];
		    $narration = $_POST["description"];
		    $user_ip = $_POST["userip"];
		    $deviceinfo = '';
		    $money = $amount;
			//$mpesacredit =  ($money/$sms_credit_amount);
			$mpesacredit = $amount;
		    $txn_ref = $_POST["txn_ref"];
			session(['phone_number' => $phone_number]);
			session(['user_ip' => $user_ip]);
			session(['deviceinfo' => $deviceinfo]);
			session(['money' => $money]);
			session(['mpesacredit' => $mpesacredit]);
			session(['txn_ref' => $txn_ref]);
		     $lnk = "https://dashboard.mambowallet.com/";


		    $r_data = [];

		    $username = "X3y0fEa20hZzmtUe"; //consumer_key
			$password = "s2JsmtRUEiksSOCC5Z5YebK9cgDpRd7Q"; //consumer_secret

		    $post = [
		        'account' => $account,
		        'number' => $phone_number,
		        'naration' => $narration,
		        'userIp' => $user_ip,
		        'deviceinfo' => $deviceinfo,
		        'cash' => $money,
		        'api_key' => $username,
		        'api_secret' => $password
		    ];

		    $curl = curl_init();
		    curl_setopt_array($curl, array(
		      CURLOPT_URL => $lnk."initiatepayment/",
		      CURLOPT_RETURNTRANSFER => true,
		      CURLOPT_ENCODING => "",
		      CURLOPT_MAXREDIRS => 10,
		      CURLOPT_TIMEOUT => 30,
		      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		      CURLOPT_CUSTOMREQUEST => "POST",
		      CURLOPT_POSTFIELDS => json_encode($post),
		    ));

		    $response = curl_exec($curl);
		    $err = curl_error($curl);

		    curl_close($curl);

		    if($err){
		        $r_data = array('status'=> False,"error"=>$err);
		    }else{
		        $res = json_decode($response);
		        if($res->status == "ok"){
		            $r_data = array('status'=> True, 'key'=>$res->CheckoutRequestID);
		        }else{
		            $r_data = array('status'=> False,"error"=>$res->details);
		        }
		    }

		    echo json_encode($r_data);
		}
		/**************** pay with mpesa ****************/


		/**************** complete pay with mpesa ****************/
		if(isset($_POST["key"]) && !empty($_POST["key"]) && isset($_POST["txn_ref"]) && !empty($_POST["txn_ref"])){
		    $post = [
		        'token' => $_POST["key"],
		    ];

		    $lnk = "https://dashboard.mambowallet.com/";

		    $curl = curl_init();
		    curl_setopt_array($curl, array(
		      CURLOPT_URL => $lnk."completepay/",
		      CURLOPT_RETURNTRANSFER => true,
		      CURLOPT_ENCODING => "",
		      CURLOPT_MAXREDIRS => 10,
		      CURLOPT_TIMEOUT => 30,
		      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		      CURLOPT_CUSTOMREQUEST => "POST",
		      CURLOPT_POSTFIELDS => json_encode($post)
		    ));

		    $response = curl_exec($curl);
		    $err = curl_error($curl);

		    curl_close($curl);
			
		    if($err){
		        $r_data = array('status'=> False,"error"=>$err);
		    }else{
				
		        $res = json_decode($response);
		        if($res->status == "ok"){
		            if($res->state == "complete"){
		                //mark invoice paid

						$payment = new MpesaSMSPayment;
						$payment->amount = Session::get('money');
						$payment->phone_number = Session::get('phone_number');
						$payment->currency = 'KES';
						//$payment->reference = Session::get('txn_ref');
						$payment->reference = $code;
						$payment->time = time();
						$payment->deviceinfo = Session::get('deviceinfo');
						$payment->user_ip =  Session::get('user_ip');
						$payment->credit = Session::get('mpesacredit');
						$payment->user_id = Auth::user()->id;
						$payment->company_id = Auth::user()->company_id;
						$payment->save();
						

						
						$SMSCredit = SMSCredit::where('user_id', Auth::user()->id)->first();
						if(empty($SMSCredit)){
						$credits = new SMSCredit;
						$credits->credit = $credit;
						$credits->user_id = Auth::user()->id;
						$credits->company_id = Auth::user()->company_id;
						$credits->save();
						}else{
						$finalcredit = $credit + floatval($SMSCredit->credit);
						$SMSCredit->credit = $finalcredit;
						$SMSCredit->save();
						}
						session(['sender_id_credits' => 'paid']);
						Session::forget('amount_payed');
		                $redirect_url = url('/sms/senderID');

		                
		          		/*if($this->notification->sendMailMandrill(Auth::user()->email, $this->emailtemplate(Auth::user()->name,$code,Auth::user()->phone,Auth::user()->email,Auth::user()->address,$amount,'Mpesa'),'Credits Purchase','Credits Purchase')){
						//success
						$r_data = array('status'=> "complete", "redirect"=>$redirect_url);
						}else{
						//return response(['status'=>'error', 'details'=>'An error occured while sending your credits purchase email.Please contact the administrator']);
						$r_data = array('status'=> "error");
						}*/
						try{
							$this->notification->sendMailMandrill(Auth::user()->email, $this->emailtemplate(Auth::user()->name,$code,Auth::user()->phone,Auth::user()->email,Auth::user()->address,$amount,'Mpesa'),'Credits Purchase','Credits Purchase');
						}catch(Exception $e){
							return response(['status'=>"error"]);
						}
					   $r_data = array('status'=> "complete", "redirect"=>$redirect_url);
				  }elseif($res->state == "incomplete"){
		                $r_data = array('status'=> "incomplete", "details"=>$res->info);
		            }elseif($res->state == "stalled"){
		                $r_data = array('status'=> "incomplete", "details"=>$res->info);
		            }
		        }else{
		            $r_data = array('status'=> "error");
		        }
		    }

		    echo json_encode($r_data);
		}
		/**************** complete pay with mpesa ****************/

		/**************** verify pay with mpesa ****************/
		if(isset($_POST["action"]) && !empty($_POST["action"]) && isset($_POST["account"]) && !empty($_POST["account"])){
			if($_POST["action"] == "verify"){
				$post = [
			        'token' => $_POST["account"],
			    ];

			    $lnk = "https://dashboard.mambowallet.com/";

			    $curl = curl_init();
			    curl_setopt_array($curl, array(
			      CURLOPT_URL => $lnk."verifypay/",
			      CURLOPT_RETURNTRANSFER => true,
			      CURLOPT_ENCODING => "",
			      CURLOPT_MAXREDIRS => 10,
			      CURLOPT_TIMEOUT => 30,
			      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			      CURLOPT_CUSTOMREQUEST => "POST",
			      CURLOPT_POSTFIELDS => json_encode($post)
			    ));

			    $response = curl_exec($curl);
			    $err = curl_error($curl);

			    curl_close($curl);

			    if($err){
			        $r_data = array('status'=> False,"error"=>$err);
			    }else{
			        $res = json_decode($response);
			        if($res->status == "ok"){
			            if($res->state == "completed"){
			            	//mark invoice paid here
							$payment = new MpesaSMSPayment;
							$payment->amount = Session::get('money');
							$payment->phone_number = Session::get('phone_number');
							$payment->currency = 'KES';
							//$payment->reference = Session::get('txn_ref');
							$payment->reference = $code;
							$payment->time = time();
							$payment->deviceinfo = Session::get('deviceinfo');
							$payment->user_ip =  Session::get('user_ip');
							$payment->credit = Session::get('mpesacredit');
							$payment->user_id = Auth::user()->id;
							$payment->company_id = Auth::user()->company_id;
							$payment->save();
							
							
							$SMSCredit = SMSCredit::where('user_id', Auth::user()->id)->first();
							if(empty($SMSCredit)){
							$credits = new SMSCredit;
							$credits->credit = $credit;
							$credits->user_id = Auth::user()->id;
							$credits->company_id = Auth::user()->company_id;
							$credits->save();
							}else{
							$finalcredit = $credit + floatval($SMSCredit->credit);
							$SMSCredit->credit = $finalcredit;
							$SMSCredit->save();
							}
							session(['sender_id_credits' => 'paid']);
							Session::forget('amount_payed');
		                
			            	$redirect_url = url('/sms/senderID');

			                $r_data = array('status'=> True, "redirect"=>$redirect_url);
						   /* if($this->notification->sendMailMandrill(Auth::user()->email, $this->emailtemplate(Auth::user()->name,$code,Auth::user()->phone,Auth::user()->email,Auth::user()->address,$amount,'Mpesa'),'Credits Purchase','Credits Purchase')){
							//success
							$r_data = array('status'=> "complete", "redirect"=>$redirect_url);
							}else{
							//return response(['status'=>'error', 'details'=>'An error occured while sending your credits purchase email.Please contact the administrator']);
							$r_data = array('status'=> "error");
							}*/
							try{
								$this->notification->sendMailMandrill(Auth::user()->email, $this->emailtemplate(Auth::user()->name,$code,Auth::user()->phone,Auth::user()->email,Auth::user()->address,$amount,'Mpesa'),'Credits Purchase','Credits Purchase');
							}catch(Exception $e){
								return response(['status'=>"error"]);
							}
						   $r_data = array('status'=> "complete", "redirect"=>$redirect_url);
			            }else{
			                $r_data = array('status'=> False,"details"=>"Verification failed. Please ensure you have paid before verifying");
			            }
			        }else{
			            $r_data = array('status'=> False,"details"=>"Verification failed. Please ensure you have paid before verifying");
			        }
			    }

			    echo json_encode($r_data);
			}
		}

		/**************** verify pay with mpesa ****************/
	}
			function smspayment2(Request $request) {
		$p_token=$request->token;
		$curl = curl_init();
		$token = $this->generateWalletToken();
		$amount = Session::get('amount_payed');
		$sms_credit_amount = Setting::where('config_key','sms_credit_amount')->first()->config_value;
		//$credit =  ($amount/$sms_credit_amount) * 100;
		$credit = $amount;
		$factory = new Factory;
		$generator = $factory->getLowStrengthGenerator();
		$code = "mp_".$generator->generateString(16, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
		/**************** pay with card ****************/
		if(isset($_POST["token"]) && !empty($_POST["token"]) && isset($_POST["txn_ref"]) && !empty($_POST["txn_ref"])){

		$postData = json_encode(array("token"=>$p_token,
		  "amount"=>Session::get('amount_payed') * 100, 		  
		  "currency"=>'KES', //'USD'
		  "remarks"=>"Payment for SMS Credit "
		  ));
		  

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.mambowallet.com/v1/card/requestpay/",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => $postData,
		  CURLOPT_HTTPHEADER => array(
			"Authorization: Bearer ".$token,
			"Content-Type: application/json"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);
		$r_data = [];
		if ($err) {

		  Session::forget('amount_payed');
		  
		  $r_data = array('status'=> False,"redirect"=> url('/sms/senderID'.Session::get('sender_id_id')),"error"=>$err);
		} else {
			$response_data = json_decode($response);

		    if (isset($response_data->Results) && !empty($response_data->Results)){
				if ($response_data->Results->ResultCode == 0){
				// add correct page redirection and save data to the transactions
				// my payment reaches here a successfull one  
				session(['mw_transaction' => [$response_data->Transaction, $amount]]);
				$payment = new SMSPayment;
				$payment->amount = $amount;
				$payment->charge = Session::get('mw_transaction')[0]->transaction->charge;
				$payment->currency = Session::get('mw_transaction')[0]->transaction->currency;
				$payment->reference = Session::get('mw_transaction')[0]->transaction->reference;
				$payment->time = Session::get('mw_transaction')[0]->transaction->time;
				$payment->identifier = Session::get('mw_transaction')[0]->transaction->identifier;
				$payment->card_id = Session::get('mw_transaction')[0]->transaction->id;
				$payment->expiry = Session::get('mw_transaction')[0]->card->expiry;
				$payment->type = Session::get('mw_transaction')[0]->card->type;
				$payment->card = Session::get('mw_transaction')[0]->card->card;
				$payment->credit = $credit;
				$payment->user_id = Auth::user()->id;
				$payment->company_id = Auth::user()->company_id;
				$payment->save();
				

				
				$SMSCredit = SMSCredit::where('user_id', Auth::user()->id)->first();
				if(empty($SMSCredit)){
				$credits = new SMSCredit;
				$credits->credit = $credit;
				$credits->user_id = Auth::user()->id;
				$credits->company_id = Auth::user()->company_id;
				$credits->save();
				}else{
				$finalcredit = $credit + floatval($SMSCredit->credit);
				$SMSCredit->credit = $finalcredit;
				$SMSCredit->save();
				}
				session(['sender_id_credits' => 'paid']);
				Session::forget('amount_payed');
				/* if($this->notification->sendMailMandrill(Auth::user()->email, $this->emailtemplate(Auth::user()->name,Session::get('mw_transaction')[0]->transaction->reference,Auth::user()->phone,Auth::user()->email,Auth::user()->address,$amount,'Card'),'Credits Purchase','Credits Purchase')){
					//success
					$r_data = array("status"=>True,"redirect"=>url('/sms/senderID'));
					}else{
					//return response(['status'=>'error', 'details'=>'An error occured while sending your credits purchase email.Please contact the administrator']);
					$r_data = array("status"=> False,"redirect"=> url('/sms/senderID'),"feedback"=>$response_data);
					}*/
					try{
						$this->notification->sendMailMandrill(Auth::user()->email, $this->emailtemplate(Auth::user()->name,Session::get('mw_transaction')[0]->transaction->reference,Auth::user()->phone,Auth::user()->email,Auth::user()->address,$amount,'Card'),'Credits Purchase','Credits Purchase');
					}catch(Exception $e){
						return response(['status'=>False]);
					}
				$r_data = array("status"=>True,"redirect"=>url('/sms/senderID'.Session::get('sender_id_id')));
				}else{
				    Session::forget('mw_transaction');
					$r_data = array("status"=> False,"redirect"=> url('/sms/senderID'.Session::get('sender_id_id')),"feedback"=>$response_data);
				}
			}else{
				Session::forget('mw_transaction');
				$r_data = array("status"=> False,"redirect"=> url('/sms/senderID'.Session::get('sender_id_id')),"feedback"=>$response_data);
			}
           
		}
		echo json_encode($r_data );
	}
	/**************** pay with card ****************/
			/**************** pay with mpesa ****************/
		if(isset($_POST["action"]) && !empty($_POST["action"]) && isset($_POST["phone_number"]) && !empty($_POST["phone_number"]) && isset($_POST["account"]) && !empty($_POST["account"]) && isset($_POST["txn_ref"]) && !empty($_POST["txn_ref"])){
			$account = $_POST["account"];
		    $phone_number = $_POST["phone_number"];
		    $narration = $_POST["description"];
		    $user_ip = $_POST["userip"];
		    $deviceinfo = '';
		    $money = $amount;
			//$mpesacredit =  ($money/$sms_credit_amount);
			$mpesacredit = $amount;
		    $txn_ref = $_POST["txn_ref"];
			session(['phone_number' => $phone_number]);
			session(['user_ip' => $user_ip]);
			session(['deviceinfo' => $deviceinfo]);
			session(['money' => $money]);
			session(['mpesacredit' => $mpesacredit]);
			session(['txn_ref' => $txn_ref]);
		     $lnk = "https://dashboard.mambowallet.com/";


		    $r_data = [];

		    $username = "X3y0fEa20hZzmtUe"; //consumer_key
			$password = "s2JsmtRUEiksSOCC5Z5YebK9cgDpRd7Q"; //consumer_secret

		    $post = [
		        'account' => $account,
		        'number' => $phone_number,
		        'naration' => $narration,
		        'userIp' => $user_ip,
		        'deviceinfo' => $deviceinfo,
		        'cash' => $money,
		        'api_key' => $username,
		        'api_secret' => $password
		    ];

		    $curl = curl_init();
		    curl_setopt_array($curl, array(
		      CURLOPT_URL => $lnk."initiatepayment/",
		      CURLOPT_RETURNTRANSFER => true,
		      CURLOPT_ENCODING => "",
		      CURLOPT_MAXREDIRS => 10,
		      CURLOPT_TIMEOUT => 30,
		      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		      CURLOPT_CUSTOMREQUEST => "POST",
		      CURLOPT_POSTFIELDS => json_encode($post),
		    ));

		    $response = curl_exec($curl);
		    $err = curl_error($curl);

		    curl_close($curl);

		    if($err){
		        $r_data = array('status'=> False,"error"=>$err);
		    }else{
		        $res = json_decode($response);
		        if($res->status == "ok"){
		            $r_data = array('status'=> True, 'key'=>$res->CheckoutRequestID);
		        }else{
		            $r_data = array('status'=> False,"error"=>$res->details);
		        }
		    }

		    echo json_encode($r_data);
		}
		/**************** pay with mpesa ****************/


		/**************** complete pay with mpesa ****************/
		if(isset($_POST["key"]) && !empty($_POST["key"]) && isset($_POST["txn_ref"]) && !empty($_POST["txn_ref"])){
		    $post = [
		        'token' => $_POST["key"],
		    ];

		    $lnk = "https://dashboard.mambowallet.com/";

		    $curl = curl_init();
		    curl_setopt_array($curl, array(
		      CURLOPT_URL => $lnk."completepay/",
		      CURLOPT_RETURNTRANSFER => true,
		      CURLOPT_ENCODING => "",
		      CURLOPT_MAXREDIRS => 10,
		      CURLOPT_TIMEOUT => 30,
		      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		      CURLOPT_CUSTOMREQUEST => "POST",
		      CURLOPT_POSTFIELDS => json_encode($post)
		    ));

		    $response = curl_exec($curl);
		    $err = curl_error($curl);

		    curl_close($curl);
			
		    if($err){
		        $r_data = array('status'=> False,"error"=>$err);
		    }else{
				
		        $res = json_decode($response);
		        if($res->status == "ok"){
		            if($res->state == "complete"){
		                //mark invoice paid

						$payment = new MpesaSMSPayment;
						$payment->amount = Session::get('money');
						$payment->phone_number = Session::get('phone_number');
						$payment->currency = 'KES';
						//$payment->reference = Session::get('txn_ref');
						$payment->reference = $code;
						$payment->time = time();
						$payment->deviceinfo = Session::get('deviceinfo');
						$payment->user_ip =  Session::get('user_ip');
						$payment->credit = Session::get('mpesacredit');
						$payment->user_id = Auth::user()->id;
						$payment->company_id = Auth::user()->company_id;
						$payment->save();
					
						$SMSCredit = SMSCredit::where('user_id', Auth::user()->id)->first();
						if(empty($SMSCredit)){
						$credits = new SMSCredit;
						$credits->credit = $credit;
						$credits->user_id = Auth::user()->id;
						$credits->company_id = Auth::user()->company_id;
						$credits->save();
						}else{
						$finalcredit = $credit + floatval($SMSCredit->credit);
						$SMSCredit->credit = $finalcredit;
						$SMSCredit->save();
						}
						session(['sender_id_credits' => 'paid']);
						Session::forget('amount_payed');
		                $redirect_url = url('/sms/senderID'.Session::get('sender_id_id'));

		                
		          		/*if($this->notification->sendMailMandrill(Auth::user()->email, $this->emailtemplate(Auth::user()->name,$code,Auth::user()->phone,Auth::user()->email,Auth::user()->address,$amount,'Mpesa'),'Credits Purchase','Credits Purchase')){
						//success
						$r_data = array('status'=> "complete", "redirect"=>$redirect_url);
						}else{
						//return response(['status'=>'error', 'details'=>'An error occured while sending your credits purchase email.Please contact the administrator']);
						$r_data = array('status'=> "error");
						}*/
						try{
							$this->notification->sendMailMandrill(Auth::user()->email, $this->emailtemplate(Auth::user()->name,$code,Auth::user()->phone,Auth::user()->email,Auth::user()->address,$amount,'Mpesa'),'Credits Purchase','Credits Purchase');
						}catch(Exception $e){
							return response(['status'=>"error"]);
						}
					   $r_data = array('status'=> "complete", "redirect"=>$redirect_url);
				  }elseif($res->state == "incomplete"){
		                $r_data = array('status'=> "incomplete", "details"=>$res->info);
		            }elseif($res->state == "stalled"){
		                $r_data = array('status'=> "incomplete", "details"=>$res->info);
		            }
		        }else{
		            $r_data = array('status'=> "error");
		        }
		    }

		    echo json_encode($r_data);
		}
		/**************** complete pay with mpesa ****************/

		/**************** verify pay with mpesa ****************/
		if(isset($_POST["action"]) && !empty($_POST["action"]) && isset($_POST["account"]) && !empty($_POST["account"])){
			if($_POST["action"] == "verify"){
				$post = [
			        'token' => $_POST["account"],
			    ];

			    $lnk = "https://dashboard.mambowallet.com/";

			    $curl = curl_init();
			    curl_setopt_array($curl, array(
			      CURLOPT_URL => $lnk."verifypay/",
			      CURLOPT_RETURNTRANSFER => true,
			      CURLOPT_ENCODING => "",
			      CURLOPT_MAXREDIRS => 10,
			      CURLOPT_TIMEOUT => 30,
			      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			      CURLOPT_CUSTOMREQUEST => "POST",
			      CURLOPT_POSTFIELDS => json_encode($post)
			    ));

			    $response = curl_exec($curl);
			    $err = curl_error($curl);

			    curl_close($curl);

			    if($err){
			        $r_data = array('status'=> False,"error"=>$err);
			    }else{
			        $res = json_decode($response);
			        if($res->status == "ok"){
			            if($res->state == "completed"){
			            	//mark invoice paid here
							$payment = new MpesaSMSPayment;
							$payment->amount = Session::get('money');
							$payment->phone_number = Session::get('phone_number');
							$payment->currency = 'KES';
							//$payment->reference = Session::get('txn_ref');
							$payment->reference = $code;
							$payment->time = time();
							$payment->deviceinfo = Session::get('deviceinfo');
							$payment->user_ip =  Session::get('user_ip');
							$payment->credit = Session::get('mpesacredit');
							$payment->user_id = Auth::user()->id;
							$payment->company_id = Auth::user()->company_id;
							$payment->save();

							
							$SMSCredit = SMSCredit::where('user_id', Auth::user()->id)->first();
						   if(empty($SMSCredit)){
							$credits = new SMSCredit;
							$credits->credit = $credit;
							$credits->user_id = Auth::user()->id;
							$credits->company_id = Auth::user()->company_id;
							$credits->save();
							}else{
							$finalcredit = $credit + floatval($SMSCredit->credit);
							$SMSCredit->credit = $finalcredit;
							$SMSCredit->save();
							}
							session(['sender_id_credits' => 'paid']);
							Session::forget('amount_payed');
		                
			            	$redirect_url = url('/sms/senderID'.Session::get('sender_id_id'));

			                $r_data = array('status'=> True, "redirect"=>$redirect_url);
						   /* if($this->notification->sendMailMandrill(Auth::user()->email, $this->emailtemplate(Auth::user()->name,$code,Auth::user()->phone,Auth::user()->email,Auth::user()->address,$amount,'Mpesa'),'Credits Purchase','Credits Purchase')){
							//success
							$r_data = array('status'=> "complete", "redirect"=>$redirect_url);
							}else{
							//return response(['status'=>'error', 'details'=>'An error occured while sending your credits purchase email.Please contact the administrator']);
							$r_data = array('status'=> "error");
							}*/
							try{
								$this->notification->sendMailMandrill(Auth::user()->email, $this->emailtemplate(Auth::user()->name,$code,Auth::user()->phone,Auth::user()->email,Auth::user()->address,$amount,'Mpesa'),'Credits Purchase','Credits Purchase');
							}catch(Exception $e){
								return response(['status'=>"error"]);
							}
						   $r_data = array('status'=> "complete", "redirect"=>$redirect_url);
			            }else{
			                $r_data = array('status'=> False,"details"=>"Verification failed. Please ensure you have paid before verifying");
			            }
			        }else{
			            $r_data = array('status'=> False,"details"=>"Verification failed. Please ensure you have paid before verifying");
			        }
			    }

			    echo json_encode($r_data);
			}
		}

		/**************** verify pay with mpesa ****************/
	}
		function sender_id_file(Request $request) {

	    if($request->file==''){
		 return response(['status'=>'error', 'details'=>"Please upload your sender id authorization document"]);
		}else{

		if($request->hasFile('file')){
				$extension = $request->file('file')->getClientOriginalExtension();
				if($extension!='doc'&&$extension!='docx'&&$extension!='pdf'){
				   return response(['status'=>'error', 'details'=>"Please upload a valid either a word or pdf document"]);
			    }else{
				$image = $request->file('file');
				$name = Session::get('sender_id').'_'.time().'.'. $extension;
                $destinationPath = $_SERVER['DOCUMENT_ROOT'] .'/authoriation_documents';
				$image->move($destinationPath, $name);
				session(['authoriation_document' => $name]);
				$sender_id = SenderID::find(Session::get('sender_id_id'));
				$sender_id->step = 3;
				$sender_id->save();
				session(['sender_id_step' => 3]);
				return response(['status'=>'success']);
				}
        }else{
			return response(['status'=>'error', 'details'=>"Please upload your sender id authoriation document"]);
		}

		}
	}
		function sender_id_payment(Request $request) {
		$sender_id = Session::get('sender_id');
		$authoriation_document = Session::get('authoriation_document');
		$p_token=$request->token;
		$curl = curl_init();
		$token = $this->generateWalletToken();
		$amount = Setting::where('config_key','sender_id_cost')->first()->config_value;;
		$adminemail = Setting::where('config_key','payment_email')->first()->config_value;
		$factory = new Factory;
		$generator = $factory->getLowStrengthGenerator();
		$code = "mp_".$generator->generateString(16, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
		/**************** pay with card ****************/
		if(isset($_POST["token"]) && !empty($_POST["token"]) && isset($_POST["txn_ref"]) && !empty($_POST["txn_ref"])){
		$postData = json_encode(array("token"=>$p_token,
		  "amount"=>$amount * 100, 		  
		  "currency"=>'KES', //'USD'
		  "remarks"=>"Payment for Sender ID "
		  ));
		  

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.mambowallet.com/v1/card/requestpay/",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => $postData,
		  CURLOPT_HTTPHEADER => array(
			"Authorization: Bearer ".$token,
			"Content-Type: application/json"
		  ),
		));
		
		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);
		$r_data = [];
		if ($err) {

		 $r_data = array('status'=> False,"redirect"=> url('/sms/sender-id'),"error"=>$err);
		// $r_data = array("status"=> False,"redirect"=> "","feedback"=>$response_data);
		} else {
			$response_data = json_decode($response);

		    if (isset($response_data->Results) && !empty($response_data->Results)){
				if ($response_data->Results->ResultCode == 0){
				// add correct page redirection and save data to the transactions
				// my payment reaches here a successfull one  
				session(['Senderid_transaction' => [$response_data->Transaction, $amount]]);
				$payment = SenderIDPayment::find(Session::get('sender_id_id'));
				$payment->amount = $amount;
				$payment->charge = Session::get('Senderid_transaction')[0]->transaction->charge;
				$payment->currency = Session::get('Senderid_transaction')[0]->transaction->currency;
				$payment->reference = Session::get('Senderid_transaction')[0]->transaction->reference;
				$payment->time = Session::get('Senderid_transaction')[0]->transaction->time;
				$payment->identifier = Session::get('Senderid_transaction')[0]->transaction->identifier;
				$payment->card_id = Session::get('Senderid_transaction')[0]->transaction->id;
				$payment->expiry = Session::get('Senderid_transaction')[0]->card->expiry;
				$payment->type = Session::get('Senderid_transaction')[0]->card->type;
				$payment->card = Session::get('Senderid_transaction')[0]->card->card;
				$payment->authoriation_document = $authoriation_document;
				$payment->save();
				session(['sender_id_paid' => 'paid']);
				$r_data = array("status"=>True,"redirect"=>url('/sms/senderID'));
				//$this->notification->sendMailMandrill(Auth::user()->email, $this->emailtemplate(Auth::user()->name,Session::get('Senderid_transaction')[0]->transaction->reference,Auth::user()->phone,Auth::user()->email,Auth::user()->address,$amount),'Sender ID Purchase','Sender ID');
				//$this->notification->sendMailMandrill(Auth::user()->email, $this->emailtemplate(Auth::user()->name,Session::get('Senderid_transaction')[0]->transaction->reference,Auth::user()->phone,Auth::user()->email,Auth::user()->address,$amount,'Card'),'Sender ID Purchase','Sender ID Purchase')
					/*if($this->notification->sendMailMandrill(Auth::user()->email, $this->emailtemplate(Auth::user()->name,Session::get('mw_transaction')[0]->transaction->reference,Auth::user()->phone,Auth::user()->email,Auth::user()->address,$amount),'Credits Purchase','Credits Purchase')){
					//success
					$r_data = array("status"=>True,"redirect"=>url('/buy-credit'));
					}else{
					//return response(['status'=>'error', 'details'=>'An error occured while sending your credits purchase email.Please contact the administrator']);
					$r_data = array("status"=> False,"redirect"=> url('/buy-credit'),"feedback"=>$response_data);
					}*/
				//return redirect()->route('sender_id1')->with('debugMsg',$debugMsg);;
				//$r_data = array("status"=>True,"redirect"=>url('/sms/senderID')->with('paid','paid'));
				//$r_data = array("status"=> True,"redirect"=> "","feedback"=>$response_data);
				Session::forget('sender_id');
				Session::forget('sender_id_id');
				Session::forget('authoriation_document');
				}else{
				    Session::forget('Senderid_transaction');
					//$r_data = array("status"=> False,"redirect"=> url('/sms/sender-id'),"feedback"=>$response_data->Results->ResultDesc);
					$r_data = array("status"=> False,"redirect"=> url('/sms/sender-idt'),"feedback"=>$response_data);
					//$r_data = array("status"=> False,"redirect"=> "","feedback"=>$response_data);
				}
			}else{
				Session::forget('Senderid_transaction');
				//$r_data = array("status"=> False,"redirect"=> url('/sms/sender-id'),"feedback"=>$response_data->Results->ResultDesc);
				$r_data = array("status"=> False,"redirect"=> url('/sms/sender-id'),"feedback"=>$response_data);
				//$r_data = array("status"=> False,"redirect"=> "","feedback"=>$response_data);
			}
           
		}
		echo json_encode($r_data );
			}
	/**************** pay with card ****************/
				/**************** pay with mpesa ****************/
		if(isset($_POST["action"]) && !empty($_POST["action"]) && isset($_POST["phone_number"]) && !empty($_POST["phone_number"]) && isset($_POST["account"]) && !empty($_POST["account"]) && isset($_POST["txn_ref"]) && !empty($_POST["txn_ref"])){
			$account = $_POST["account"];
		    $phone_number = $_POST["phone_number"];
		    $narration = $_POST["description"];
		    $user_ip = $_POST["userip"];
		    $deviceinfo = '';
		    $money = $amount;
			//$mpesacredit =  ($money/$sms_credit_amount);
			$mpesacredit = $amount;
		    $txn_ref = $_POST["txn_ref"];
			session(['phone_number' => $phone_number]);
			session(['user_ip' => $user_ip]);
			session(['deviceinfo' => $deviceinfo]);
			session(['money' => $money]);
			session(['mpesacredit' => $mpesacredit]);
			session(['txn_ref' => $txn_ref]);
		     $lnk = "https://dashboard.mambowallet.com/";


		    $r_data = [];

		    //$username = "X3y0fEa20hZzmtUe"; //consumer_key
			//$password = "s2JsmtRUEiksSOCC5Z5YebK9cgDpRd7Q"; //consumer_secret
			
			$username = "HT0Cmd2OCtMVPILy"; //consumer_key
			$password = "XVtwnMAMCO7gXf2AMLIeAwc"; //consumer_secret

		    $post = [
		        'account' => $account,
		        'number' => $phone_number,
		        'naration' => $narration,
		        'userIp' => $user_ip,
		        'deviceinfo' => $deviceinfo,
		        'cash' => $money,
		        'api_key' => $username,
		        'api_secret' => $password
		    ];

		    $curl = curl_init();
		    curl_setopt_array($curl, array(
		      CURLOPT_URL => $lnk."initiatepayment/",
		      CURLOPT_RETURNTRANSFER => true,
		      CURLOPT_ENCODING => "",
		      CURLOPT_MAXREDIRS => 10,
		      CURLOPT_TIMEOUT => 30,
		      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		      CURLOPT_CUSTOMREQUEST => "POST",
		      CURLOPT_POSTFIELDS => json_encode($post),
		    ));

		    $response = curl_exec($curl);
		    $err = curl_error($curl);

		    curl_close($curl);

		    if($err){
		        $r_data = array('status'=> False,"error"=>$err);
		    }else{
		        $res = json_decode($response);
		        if($res->status == "ok"){
		            $r_data = array('status'=> True, 'key'=>$res->CheckoutRequestID);
		        }else{
		            $r_data = array('status'=> False,"error"=>$res->details);
		        }
		    }

		    echo json_encode($r_data);
		}
		/**************** pay with mpesa ****************/


		/**************** complete pay with mpesa ****************/
		if(isset($_POST["key"]) && !empty($_POST["key"]) && isset($_POST["txn_ref"]) && !empty($_POST["txn_ref"])){
		    $post = [
		        'token' => $_POST["key"],
		    ];

		    $lnk = "https://dashboard.mambowallet.com/";

		    $curl = curl_init();
		    curl_setopt_array($curl, array(
		      CURLOPT_URL => $lnk."completepay/",
		      CURLOPT_RETURNTRANSFER => true,
		      CURLOPT_ENCODING => "",
		      CURLOPT_MAXREDIRS => 10,
		      CURLOPT_TIMEOUT => 30,
		      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		      CURLOPT_CUSTOMREQUEST => "POST",
		      CURLOPT_POSTFIELDS => json_encode($post)
		    ));

		    $response = curl_exec($curl);
		    $err = curl_error($curl);

		    curl_close($curl);
			
		    if($err){
		        $r_data = array('status'=> False,"error"=>$err);
		    }else{
				
		        $res = json_decode($response);
		        if($res->status == "ok"){
		            if($res->state == "complete"){
		                //mark invoice paid

						$payment = new MpesaSenderIDPayment;
						$payment->amount = Session::get('money');
						$payment->phone_number = Session::get('phone_number');
						$payment->currency = 'KES';
						//$payment->reference = Session::get('txn_ref');
						$payment->reference = $code;
						$payment->time = time();
						$payment->deviceinfo = Session::get('deviceinfo');
						$payment->user_ip =  Session::get('user_ip');
						$payment->credit = Session::get('mpesacredit');
						$payment->user_id = Auth::user()->id;
						$payment->company_id = Auth::user()->company_id;
						$payment->save();

						Session::forget('amount_payed');
						session(['sender_id_paid' => 'paid']);
		                $redirect_url = url('/sms/senderID');
						//$redirect_url ="";
		                $r_data = array('status'=> "complete", "redirect"=>$redirect_url);
		          		/*if($this->notification->sendMailMandrill(Auth::user()->email, $this->emailtemplate(Auth::user()->name,$code,Auth::user()->phone,Auth::user()->email,Auth::user()->address,$amount),'Credits Purchase','Credits Purchase')){
						//success
						$r_data = array('status'=> "complete", "redirect"=>$redirect_url);
						}else{
						//return response(['status'=>'error', 'details'=>'An error occured while sending your credits purchase email.Please contact the administrator']);
						$r_data = array('status'=> "error");
						}*/
				  }elseif($res->state == "incomplete"){
		                $r_data = array('status'=> "incomplete", "details"=>$res->info);
		            }elseif($res->state == "stalled"){
		                $r_data = array('status'=> "incomplete", "details"=>$res->info);
		            }
		        }else{
		            $r_data = array('status'=> "error");
		        }
		    }

		    echo json_encode($r_data);
		}
		/**************** complete pay with mpesa ****************/

		/**************** verify pay with mpesa ****************/
		if(isset($_POST["action"]) && !empty($_POST["action"]) && isset($_POST["account"]) && !empty($_POST["account"])){
			if($_POST["action"] == "verify"){
				$post = [
			        'token' => $_POST["account"],
			    ];

			    $lnk = "https://dashboard.mambowallet.com/";

			    $curl = curl_init();
			    curl_setopt_array($curl, array(
			      CURLOPT_URL => $lnk."verifypay/",
			      CURLOPT_RETURNTRANSFER => true,
			      CURLOPT_ENCODING => "",
			      CURLOPT_MAXREDIRS => 10,
			      CURLOPT_TIMEOUT => 30,
			      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			      CURLOPT_CUSTOMREQUEST => "POST",
			      CURLOPT_POSTFIELDS => json_encode($post)
			    ));

			    $response = curl_exec($curl);
			    $err = curl_error($curl);

			    curl_close($curl);

			    if($err){
			        $r_data = array('status'=> False,"error"=>$err);
			    }else{
			        $res = json_decode($response);
			        if($res->status == "ok"){
			            if($res->state == "completed"){
			            	//mark invoice paid here
							$payment = new MpesaSenderIDPayment;
							$payment->amount = Session::get('money');
							$payment->phone_number = Session::get('phone_number');
							$payment->currency = 'KES';
							//$payment->reference = Session::get('txn_ref');
							$payment->reference = $code;
							$payment->time = time();
							$payment->deviceinfo = Session::get('deviceinfo');
							$payment->user_ip =  Session::get('user_ip');
							$payment->credit = Session::get('mpesacredit');
							$payment->user_id = Auth::user()->id;
							$payment->company_id = Auth::user()->company_id;
							$payment->save();
			
							//Session::forget('amount_payed');
		                
			            	//$redirect_url = url('/buy-credit');
							session(['sender_id_paid' => 'paid']);
							$redirect_url = url('/sms/senderID');
			                $r_data = array('status'=> True, "redirect"=>$redirect_url);
			            }else{
			                $r_data = array('status'=> False,"details"=>"Verification failed. Please ensure you have paid before verifying");
			            }
			        }else{
			            $r_data = array('status'=> False,"details"=>"Verification failed. Please ensure you have paid before verifying");
			        }
			    }

			    echo json_encode($r_data);
			}
		}

		/**************** verify pay with mpesa ****************/
	}
		    public function sender_id_form(Request $request){

        try{
			$senderid = SenderID::where('sender_id', $request->sender_id)
    						->get();
			if($request->sender_id==''){
				return response(['status'=>'error', 'details'=>"Please enter the sender ID"]);
			}
			else if(count($senderid) > 0){
				return response(['status'=>'error', 'details'=>"The sender ID is already selected. Please choose a new sender ID"]);
			}else if($request->sender_id==''){
				return response(['status'=>'error', 'details'=>"Please enter the sender ID"]);
			}
			else if($request->message==''){
				return response(['status'=>'error', 'details'=>"Please enter a description foe sender ID usage"]);
			}

			else{
				$logo= Company::where('id',Auth::user()->company_id)->first()->logo;
				$payment = new SenderID;
				$payment->sender_id = $request->sender_id;
				$payment->usage = $request->message;
				$payment->user_id = Auth::user()->id;
				$payment->logo = $logo;
				$payment->step = 1;
				$payment->company_id = Auth::user()->company_id;
				$payment->save();
			    session(['sender_id' => $request->sender_id]);
				session(['sender_id_id' => $payment->id]);
				session(['sender_id_step' => 1]);
				return response(['status'=>'success','sender_id'=>$request->sender_id,'usage'=>$request->message]);

			}
		
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
		    public function sender_id()
		{
			$paypal_client_ID = Setting::where('config_key','paypal_client_ID')->first()->config_value;
			$paypal_mode = Setting::where('config_key','paypal_mode')->first()->config_value;
	        $amount = Setting::where('config_key','company_payable_amount')->first()->config_value;
			$company= Company::where('id',Auth::user()->company_id)->first();
			$cost = Setting::where('config_key','sender_id_cost')->first()->config_value;
			$SMSCredit = SMSCredit::where('user_id', Auth::user()->id)->first();
			if(!empty($SMSCredit)){
				$credits = $SMSCredit->credit;
				if($credits>=$cost){
					$use_credit = 'yes';
				}else{
					$use_credit = 'no';
				}
			}else{
				$credits = 0;
				$use_credit = 'no';
			}
			if(Session::has('sender_id_paid')){
				$paid = "yes";
				Session::forget('sender_id_paid');
			}else{
				$paid = "no";
			}
			if(Session::has('sender_id_credits')){
				$credit_paid = "yes";
				Session::forget('sender_id_credits');
			}else{
				$credit_paid = "no";
			}
			
			$credit_diff = $cost - $credits;
			if($credit_diff <= 200 ){
			$mincredittopurchase = 200; 
			}else if($credit_diff >= 200 && $credit_diff <= 500 ){
			$mincredittopurchase = 500; 
			}else if($credit_diff >= 500 && $credit_diff <= 1000 ){
			$mincredittopurchase = 1000; 
			}else if($credit_diff >= 1000 && $credit_diff <= 3000 ){
			$mincredittopurchase = 3000; 
			}else if($credit_diff >= 3000 && $credit_diff <= 5000 ){
			$mincredittopurchase = 5000; 
			}else if($credit_diff >= 5000 && $credit_diff <= 10000 ){
			$mincredittopurchase = 10000; 
			}else if($credit_diff >= 10000 && $credit_diff <= 20000 ){
			$mincredittopurchase = 20000; 
			}else{
			$mincredittopurchase = 10000; 
			}
			session(['sender_id_step' => 0]);
		   if(Session::has('redirect')){
			   Session::forget('redirect');
				$redirect = "yes";
			}else{
				Session::forget('sender_id_id');
				$redirect = "no";
			}
			$data = array(
			'paypal_client_ID'=>$paypal_client_ID,
			'amount'=>$amount,
			'paypal_mode'=>$paypal_mode,
			'redirect'=>$redirect,
			'credit_paid'=>$credit_paid,
			'cost'=>$cost,
			'credits'=>$credits,
			'company'=>$company,
			'paid'=>$paid,
			'use_credit'=>$use_credit,
			'mincredittopurchase'=>$mincredittopurchase,
			);	
			
			return view('sender_id')->with($data);
		}
			public function complete_sender_id($id)
		{
			$paypal_client_ID = Setting::where('config_key','paypal_client_ID')->first()->config_value;
			$paypal_mode = Setting::where('config_key','paypal_mode')->first()->config_value;
	        $amount = Setting::where('config_key','company_payable_amount')->first()->config_value;
			$company= Company::where('id',Auth::user()->company_id)->first();
			$cost = Setting::where('config_key','sender_id_cost')->first()->config_value;
			$SMSCredit = SMSCredit::where('user_id', Auth::user()->id)->first();
			$senderid= SenderID::find($id);
			if(!empty($SMSCredit)){
				$credits = $SMSCredit->credit;
				if($credits>=$cost){
					$use_credit = 'yes';
				}else{
					$use_credit = 'no';
				}
			}else{
				$credits = 0;
				$use_credit = 'no';
			}
		/*	if(Session::has('sender_id_paid')){
				$paid = "yes";
				Session::forget('sender_id_paid');
			}else{
				$paid = "no";
			}
			if(Session::has('sender_id_credits')){
				$credit_paid = "yes";
				Session::forget('sender_id_credits');
			}else{
				$credit_paid = "no";
			}*/
			
			$credit_diff = $cost - $credits;
			if($credit_diff <= 200 ){
			$mincredittopurchase = 200; 
			}else if($credit_diff >= 200 && $credit_diff <= 500 ){
			$mincredittopurchase = 500; 
			}else if($credit_diff >= 500 && $credit_diff <= 1000 ){
			$mincredittopurchase = 1000; 
			}else if($credit_diff >= 1000 && $credit_diff <= 3000 ){
			$mincredittopurchase = 3000; 
			}else if($credit_diff >= 3000 && $credit_diff <= 5000 ){
			$mincredittopurchase = 5000; 
			}else if($credit_diff >= 5000 && $credit_diff <= 10000 ){
			$mincredittopurchase = 10000; 
			}else if($credit_diff >= 10000 && $credit_diff <= 20000 ){
			$mincredittopurchase = 20000; 
			}else{
			$mincredittopurchase = 10000; 
			}
			session(['sender_id_step' => 0]);
		  /* if(Session::has('redirect')){
			   Session::forget('redirect');
				$redirect = "yes";
			}else{
				Session::forget('sender_id_id');
				$redirect = "no";
			}*/
			$data = array(
			'paypal_client_ID'=>$paypal_client_ID,
			'amount'=>$amount,
			'paypal_mode'=>$paypal_mode,
			//'redirect'=>$redirect,
			//'credit_paid'=>$credit_paid,
			'cost'=>$cost,
			'credits'=>$credits,
			'company'=>$company,
			'senderid'=>$senderid,
		//	'paid'=>$paid,
			'use_credit'=>$use_credit,
			'mincredittopurchase'=>$mincredittopurchase,
			);	
			session(['sender_id_id' => $id]);
			session(['sender_id' => $senderid->sender_id]);
			return view('complete_sender_id')->with($data);
		}
				 /*   public function sender_id()
		{
			$payments = SenderIDPayment::where('user_id', Auth::user()->id)->first();
			$logo= Company::where('id',Auth::user()->company_id)->first()->logo;
			$cost = Setting::where('config_key','sender_id_cost')->first()->config_value;
			if(empty($payments)){
			return view('sender_id')->with('cost',$cost)->with('logo',$logo);
			}else{
				if(Session::has('sender_id_paid')){
				return view('sender_id')->with('cost',$cost)->with('logo',$logo);
				}else{
				return redirect()->route('sender_id1');
				}
			}
	
		}*/
	    public function sender_id1()
		{
			$cost = Setting::where('config_key','sender_id_cost')->first()->config_value;
			$payments = SenderIDPayment::where('user_id', Auth::user()->id)->first();
			if( Session::has('sender_id')){
				$sender_id = Session::get('sender_id');
			}else{
			  if(!empty($payments)){
				$sender_id = $payments->sender_id;
			  }
			}
			if(empty($payments)){
			return redirect()->route('sender_id');
			}else{
			return view('sender_id1')->with('cost',$cost)->with('payment',$payments)->with('sender_id',$sender_id);
			
			}
		}
		 public function sms_credits()
		{
			$credits = SMSCredit::all();
			foreach($credits as $credit){
				if($credit->company_id==0){
				$credit->{'company'} = 'Nodcomm';
				}else{
				$credit->{'company'} = Company::where('id','=',$credit->company_id)->first()->name;
					
				}
				$credit->{'user'} = User::where('id','=',$credit->user_id)->first();
			}
			return view('sms_credits')->with('credits',$credits);
		}
			public function user_sms_credits($id)
		{
			$payments = SMSPayment::where('user_id', $id)->get();
			$user = User::where('id','=',$id)->first();
			return view('user_sms_credits')->with('user',$user)->with('payments',$payments);
		}
		
		public function sender_ids()
		{
			session(['skip' => 10]);
			$credits = SenderID::skip(0)
							->take(10)
    						->orderBy('created_at', 'desc')
    						->get();	
			foreach($credits as $credit){
				if($credit->company_id==0){
				$credit->{'company'} = 'Nodcomm';
				}else{
				$credit->{'company'} = Company::where('id','=',$credit->company_id)->first()->name;
					
				}
				$credit->{'user'} = User::where('id','=',$credit->user_id)->first();
			}
			return view('sender_ids')->with('payments',$credits);
		}
		public function load_more_senderids(Request $request){
		if(Session::has('skip')){
		$skip = Session::get('skip');
		session(['skip' => (10 + $skip)]);
		}else{
		$skip =10;
		session(['skip' => 10]);
		}

		$payments = SenderID::skip($skip)
							->take(10)
    						->orderBy('created_at', 'desc')
							->get();
		foreach($payments as $credit){
				if($credit->company_id==0){
				$credit->{'company'} = 'Nodcomm';
				}else{
				$credit->{'company'} = Company::where('id','=',$credit->company_id)->first()->name;
					
				}
				$credit->{'user'} = User::where('id','=',$credit->user_id)->first();
			}
    	if($payments->isEmpty()){
    		return response(['status'=>'no_data']);
    	}else{

    		return response(['status'=>'success', 'payments'=>$payments]);
    	}
	 }
		 public function company_sender_ids()
		{
			session(['skip' => 10]);
			$credits = SenderID::where('company_id', Auth::user()->company_id)
							->skip(0)
							->take(10)
    						->orderBy('created_at', 'desc')
    						->get();
			foreach($credits as $credit){
				$credit->{'user'} = User::where('id','=',$credit->user_id)->first();
			}
			return view('company_senderids')->with('payments',$credits);
		}
		public function load_more_company_senderids(Request $request){
		if(Session::has('skip')){
		$skip = Session::get('skip');
		session(['skip' => (10 + $skip)]);
		}else{
		$skip =10;
		session(['skip' => 10]);
		}

		$payments = SenderID::where('company_id', Auth::user()->company_id)
							->skip($skip)
							->take(10)
    						->orderBy('created_at', 'desc')
							->get();
    	if($payments->isEmpty()){
    		return response(['status'=>'no_data']);
    	}else{

    		return response(['status'=>'success', 'payments'=>$payments]);
    	}
	 }
		 public function downloadPDF(){
		  $payment = SenderID::where('id', Session::get('sender_id_id'))->first();
		  if(empty($payment->company_name)){
		  $payment->company = Company::where('id', Auth::user()->company_id)->first();
		  $payment->new='no';	
		 }else{
			$payment->company = $payment; 
			$payment->new='yes';	
		  }
		  $pdf = PDF::loadView('sender_id_pdf', compact('payment'));
		  return $pdf->download('authorisation_docoment.pdf');

		}
		public function previewPDF(){
		  $payment = SenderID::where('id', Session::get('sender_id_id'))->first();
		  $payment->company = Company::where('id', Auth::user()->company_id)->first();
		 // return view('sender_id_preview')->with('payment', $payment);	
		  $pdf = PDF::loadView('sender_id_pdf', compact('payment'));
		   return $pdf->stream("authorisation_docoment.pdf");
		}
			function cmp($a, $b){
				$ad = strtotime($a['created_at']);
				$bd = strtotime($b['created_at']);
				return ($ad-$bd);
			}
			function my_sort($c,$d)
			{
				if ($c['created_at'] == $d['created_at']) 
				{
				   return 0;
				}
				return (strtotime($c['created_at']) > strtotime($d['created_at'])) ? -1 : 1;
			}	
		public function buy_credit()
		{
			$cpayments = SMSPayment::where('user_id', Auth::user()->id)->get();
			foreach($cpayments as $cpayment){
				$cpayment->method ='Card';
			}
			$mpayments = MpesaSMSPayment::where('user_id', Auth::user()->id)->get();
			foreach($mpayments as $mpayment){
				$mpayment->method ='Mpesa';
			}
			$ppayments = PaypalSMSPayment::where('user_id', Auth::user()->id)->get();
			foreach($ppayments as $ppayment){
				$ppayment->method ='Paypal';
			}
			$all = $cpayments->merge($mpayments)->merge($ppayments)->sortByDesc('created_at');
			$all = array_reverse(array_sort($all, function ($value) {
			  return $value['created_at'];
			}));
			$paypal_client_ID = Setting::where('config_key','paypal_client_ID')->first()->config_value;
			$paypal_mode = Setting::where('config_key','paypal_mode')->first()->config_value;
			$amount = Setting::where('config_key','company_payable_amount')->first()->config_value;
			$data = array(
			'payments'=>$all
			);
			return view('buy_credit')->with($data);
			
		}
	
	    public function buy_credit1()
		{
			if( Session::has('amount_payed')){
			$cpayments = SMSPayment::where('user_id', Auth::user()->id)->get();
			foreach($cpayments as $cpayment){
				$cpayment->method ='Card';
			}
			$mpayments = MpesaSMSPayment::where('user_id', Auth::user()->id)->get();
			foreach($mpayments as $mpayment){
				$mpayment->method ='Mpesa';
			}
			$ppayments = PaypalSMSPayment::where('user_id', Auth::user()->id)->get();
			foreach($ppayments as $ppayment){
				$ppayment->method ='Paypal';
			}
			$all = $cpayments->merge($mpayments)->merge($ppayments)->sortByDesc('created_at');
			$all = array_reverse(array_sort($all, function ($value) {
			  return $value['created_at'];
			}));
			$paypal_client_ID = Setting::where('config_key','paypal_client_ID')->first()->config_value;
			$paypal_mode = Setting::where('config_key','paypal_mode')->first()->config_value;
			$amount = Setting::where('config_key','company_payable_amount')->first()->config_value;
			$data = array(
			'payments'=>$all,
			'paypal_client_ID'=>$paypal_client_ID,
			'amount'=>Session::get('amount_payed'),
			'paypal_mode'=>$paypal_mode
			);
			return view('buy_credit1')->with($data);
			//return view('buy_credit1')->with('amount',Session::get('amount_payed'))->with('payments', $all);
			}else{
			return redirect()->route('buy_credit');
			}
		}
	 public function unverifysenderid(Request $request){

        try{

            $sender_id = SenderID::find($request->input('id'));
            $sender_id->verified =0;

            $sender_id->save();
		
            session(['skip' => 10]);
			$credits = SenderID::skip(0)
							->take(10)
    						->orderBy('created_at', 'desc')
    						->get();	
			foreach($credits as $credit){
				if($credit->company_id==0){
				$credit->{'company'} = 'Nodcomm';
				}else{
				$credit->{'company'} = Company::where('id','=',$credit->company_id)->first()->name;
					
				}
				$credit->{'user'} = User::where('id','=',$credit->user_id)->first();
			}
            
            return response(['status'=>'success', 'details'=>$credits]);
			
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
		 public function verifysenderid(Request $request){

        try{

            $sender_id = SenderID::find($request->input('id'));
            $sender_id->verified =1;

            $sender_id->save();

            session(['skip' => 10]);
			$credits = SenderID::skip(0)
							->take(10)
    						->orderBy('created_at', 'desc')
    						->get();	
			foreach($credits as $credit){
				if($credit->company_id==0){
				$credit->{'company'} = 'Nodcomm';
				}else{
				$credit->{'company'} = Company::where('id','=',$credit->company_id)->first()->name;
					
				}
				$credit->{'user'} = User::where('id','=',$credit->user_id)->first();
			}
            return response(['status'=>'success', 'details'=>$credits]);
			
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
	public function credit_receipt(){
		return view('sender_id2');
	}
				public function emailtemplate($username, $transactionid,$phone,$email,$address,$credits,$method) {
			$html = '
				<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
				<meta name="format-detection" content="telephone=no"> 
				<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;">
				<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
				<body style="padding:0; margin:0"></body>
					<div style="word-wrap:break-word">
					<div><div><div>
					<div style="margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px"></div><div><table bgcolor="#ebedee" cellpadding="0" cellspacing="0" border="0" width="100%" style="font-family:Helvetica;letter-spacing:normal;text-indent:0px;text-transform:none;word-spacing:0px;background-color:rgb(235,237,238)"><tbody><tr><td><table cellpadding="0" cellspacing="0" width="735" align="center" border="0"><tbody><tr><td height="80"></td></tr><tr><td align="center"><a href="https://www.nodcomm.com/" border="0" target="_blank"><img width="35%" border="0" src="'.url('/images/Nodcomm.png').'"></a></td></tr><tr><td height="80"></td></tr></tbody></table></td></tr><tr><td><table bgcolor="white" cellpadding="0" cellspacing="0" width="735" align="center" border="0"><tbody><tr><td height="80"></td></tr></tbody></table></td></tr><tr><td><table bgcolor="white" cellpadding="0" cellspacing="0" width="735" align="center" border="0"><tbody><tr><td width="75"></td><td width="585"><a href="https://www.nodcomm.com/" border="0" style="display:inline-block;float:left;border:0px;outline:rgb(0,0,0)" target="_blank"><img border="0" src="'.url('/favicon.png').'" ></a><a href="'.url('/purchase/credits').'" style="float:right;display:inline-block;font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;color:rgb(165,171,175);text-decoration:underline;font-size:14px;line-height:20px" target="_blank">Return to your account</a></td><td width="75"></td></tr></tbody></table></td></tr><tr><td><table bgcolor="white" cellpadding="0" cellspacing="0" width="735" align="center" border="0"><tbody><tr><td width="100%" height="15"></td></tr></tbody></table></td></tr><tr><td><table bgcolor="white" cellpadding="0" cellspacing="0" width="735" align="center" border="0"><tbody><tr><td width="75"></td><td width="585" height="1" bgcolor="#ebedee" style="height:1px"></td><td width="75"></td></tr></tbody></table></td></tr><tr><td><table bgcolor="white" cellpadding="0" cellspacing="0" width="735" align="center" border="0"><tbody><tr><td width="100%" height="70"></td></tr></tbody></table></td></tr><tr><td><table bgcolor="white" cellpadding="0" cellspacing="0" width="735" align="center" border="0"><tbody><tr><td width="75"></td><td style="font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;font-weight:bold;letter-spacing:-2px;font-size:34px;color:rgb(35,31,32);text-align:center">Thank you for purchasing!</td><td width="75"></td></tr><tr><td width="75"></td><td height="50"></td><td width="75"></td></tr><tr><td width="75"></td><td><p style="display:inline-block;font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;color:rgb(165,171,175);text-decoration:none;font-size:14px;line-height:10px">Transaction:'.$transactionid.'</p><table border="0" cellpadding="25" cellspacing="0" width="100%" style="border:5px solid rgb(235,237,238)"><tbody>
					<tr>
					<th align="left" style="border:0px;font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;font-size:16px;color:rgb(139,146,150);letter-spacing:-1px;padding-bottom:0px!important">Product</th>
					<th align="left" style="border:0px;font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;font-size:16px;color:rgb(139,146,150);letter-spacing:-1px;padding-bottom:0px!important">Quantity</th>
					<th align="left" style="border:0px;font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;font-size:16px;color:rgb(139,146,150);letter-spacing:-1px;padding-bottom:0px!important">Price</th>
					<th align="left" style="border:0px;font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;font-size:16px;color:rgb(139,146,150);letter-spacing:-1px;padding-bottom:0px!important">Payment Method</th>
					</tr>
					<tr>
					<td style="border-width:0px 0px 1px;border-bottom-style:solid;border-bottom-color:rgb(235,237,238);padding-top:40px;padding-bottom:40px"><h2 style="font-weight:bold;margin:0px;font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;font-size:24px;letter-spacing:-1px">Credits<br><small></small></h2></td>
					<td style="border-width:0px 0px 1px;border-bottom-style:solid;border-bottom-color:rgb(235,237,238);padding-top:40px;padding-bottom:40px;font-weight:bold;margin:0px 0px 8px;font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;font-size:24px">'.$credits.'</td>
					<td style="border-width:0px 0px 1px;border-bottom-style:solid;border-bottom-color:rgb(235,237,238);padding-top:40px;padding-bottom:40px;font-weight:bold;margin:0px 0px 8px;font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;font-size:24px"><span>Kshs '.$credits.'</span></td>
					<td style="border-width:0px 0px 1px;border-bottom-style:solid;border-bottom-color:rgb(235,237,238);padding-top:40px;padding-bottom:40px;font-weight:bold;margin:0px 0px 8px;font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;font-size:24px"><span>'.$method.'</span></td>
					</tr>
					<tr>
					<td width="50%" style="border:0px;padding-top:40px;padding-bottom:40px"></td><td width="35%" style="border:0px;padding-top:40px;padding-bottom:40px;font-weight:bold;margin:0px 0px 8px;line-height:35px;font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;font-size:14px;color:rgb(139,146,150)">Total:<br></td><td width="15%" style="line-height:35px;border:0px;padding-top:40px;padding-bottom:40px;font-weight:bold;margin:0px 0px 8px;font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;font-size:15px">Kshs '.$credits.'<br></td></tr></tbody></table></td>
					<td width="75"></td></tr><tr>
					<td height="65"></td>
					<td height="65"></td>
					<td height="65"></td>
					</tr>
					</tbody></table></td></tr>
					<tr><td>
					<table cellspacing="0" cellpadding="0" border="0" width="735" align="center"><tbody><tr><td height="75"></td></tr><tr><td width="100%" align="center" style="font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;font-size:14px;color:rgb(165,171,175)">Copyright © '.date( "Y" ).'<span>&nbsp;</span><a href="https://www.nodcomm.com/" style="display:inline-block;color:rgb(105,113,118);text-decoration:none" target="_blank">Nodcomm</a>. All Rights Reserved.</td></tr><tr><td height="10"></td></tr><tr><td height="75"></td></tr></tbody></table></td></tr></tbody></table></div></div></div></div></div>
	';
			return $html;
		}
	    public function emailtemplate1($username, $transactionid,$phone,$email,$address,$credits) {
        $html = '<!DOCTYPE html>
				<html>
				<head></head><body style="font-family: Helvetica,sans-serif;padding: 0;margin: 0;-webkit-font-smoothing: antialiased;color: #616161;">
				<table class="wrapper" style="margin: 0;background: #fff;border: 0;width: 100%;text-align: center;">
				<tbody>
				<tr>
				<td class="content-wrap" style="border: 0;width: 600px;text-align: center;background: #f5f5f5;">
				<table class="content" style="margin: 0 auto;border: 0;width: 600px;text-align: center;">
				<tbody>
				<tr>
				<td class="em-spacer-1" style="height: 26px;"></td>
				</tr>
				<tr>
				<td class="em-spacer-1" style="height: 26px;"></td>
				</tr>
				<tr>
				<td class="box" style="background: #fff;padding: 0 25px;">
				<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin: 0 auto;">
				<tbody><tr>
				<td align="center">
				<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin: 0 auto;">
				<tbody><tr>
				<td align="center" class="em_hero_td">
				<a href="https://casper.com/?utm_source=casper%20support&amp;utm_campaign=order%20confirmation&amp;utm_medium=email&amp;utm_content=thank%20you%20for%20your%20order" target="_blank">
				<img src=" ' .url('/images/Nodcomm.png').'" style="width: 100%;height: auto;">
				</a>
				</td>
				</tr>
				<tr>
				<td align="center">
				<h1 class="hero-primary" style="text-transform: uppercase;font-size: 28px;color: #283375;margin-top: 9px;">Credit Purchase</h1>
				</td>
				</tr>
				<tr class="lead-wrap" style="text-align: center;width: 100%;">
				<td class="lead" style="font-family: Helvetica,sans-serif;text-align: center;border-collapse: collapse;font-size: 18px;letter-spacing: .045em;line-height: 24px;mso-line-height-rule: exactly;">
				'.$username.', we’ve received your payment of Kshs '.$credits.' for credits. <br>'.$credits.' credits have been added to your account.
				</td>
				</tr>
				<tr>
				<td class="em-spacer-1" style="height: 26px;"></td>
				</tr>
				<tr>
				<td class="order-link-wrap" style="text-align: center;font-size: 14px;">
				<strong>
				Purchase:<a href="#" style="color: #0047be;" target="_blank">'.$transactionid.'</a>
				<span class="pipe">|</span>
				Purchase Date : '.date('d/m/Y').'
				</strong>
				</td>
				</tr>
				<tr>
				<td class="em-spacer-1" style="height: 26px;"></td>
				</tr>
				<tr>
				<td class="em-spacer-2" style="height: 52px;"></td>
				</tr>
				</tbody></table>
				</td>
				</tr>
				<tr>
				<td class="em-spacer-1" style="height: 26px;"></td>
				</tr>
				<tr>
				<td class="box box-ext order-summary-box" style="background: #fff;padding: 0 25px;text-align: center;">
				<table class="two-col ledger" style="margin: 0 auto;font-size: 14px;line-height: 22px;width: 546px;text-align: left;">
				<tbody>
				<tr>
				<td class="em-spacer-1" style="height: 26px;"></td>
				</tr>
				<tr>
				<td>
				<table align="left" class="column column-1" style="margin: 0 auto;width: 270px;">
				<tbody>
				<tr>
				<td>
				<strong class="title" style="text-transform: uppercase;display: block;margin-bottom: 5px;">
				Billing Address </strong>
				'.$username.'<br>
				'.$address.'
				<br>
				'.$phone.'
				<br>
				'.$email.'</td>
				</tr>
				</tbody>
				</td>
				</tr>
				<tr>
				<td class="em-spacer-1" style="height: 26px;"></td>
				</tr>
				</tbody>
				</table>
				<table class="order-summary" style="margin: 0 auto;text-align: left;width: 546px;border-top: 2px solid #eee;">
				<tbody>
				<tr>
				<td class="em-spacer-0" style="height: 20px;"></td>
				</tr>
				<tr class="line-item">
				<td class="line-item product-thumb-column" style="width: 80px;">
				<img alt="Queen" class="product-thumb" height="80" width="80" src="'.url('/images/credit.jpg').'" style="width: 80px;height: 80px;">
				<div class="row-spacer" style="height: 8px;"></div>
				</td>
				<td class="line-item product-info-column" style="width: 200px;">
				<div class="title" style="margin-bottom: 5px;">
				The Cost    </div>
				
				<div class="sub" style="font-size: 13px;margin-bottom: 3px;">
				Credits: '.$credits.'
				</div>
				</td>
				<td class="line-item product-price-column" style="width: 100px;text-align: right;vertical-align: top;">
				<div class="sub price" style="font-size: 13px;margin-bottom: 3px;margin-top: 18px;">
				Kshs '.$credits.'    </div>
				</td>
				</tr>
				<tr>
				<td class="em-spacer-0" style="height: 20px;"></td>
				</tr>
				 <tr>
				 <td class="divider" colspan="3" style="border-bottom: 2px solid #eee;"></td>
				 </tr>
				 <tr>
				 <td class="em-spacer-1" style="height: 26px;"></td>
				  </tr>


                                                    <tr class="total-row total" style="font-size: 14px;">
                            <td class="copy" colspan="2" style="text-align: right;padding-top: 10px;">
                              <strong>
Total                              </strong>
                            </td>
                            <td class="value" style="text-align: right;padding-top: 10px;">
                              <strong>
Kshs '.$credits.'                             </strong>
                            </td>
                          </tr>
                        <tr>
                          <td class="em-spacer-0" style="height: 20px;"></td>
                        </tr>
                        <tr>
                          <td class="divider" colspan="3" style="border-bottom: 2px solid #eee;"></td>
                        </tr>
   
                      </tbody>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td class="em-spacer-1" style="height: 26px;"></td>
                </tr>
                <tr>
                  <td class="box box-ext cx-info-box" style="background: #fff;padding: 0 25px;text-align: center;color: #2a3376;">
                    <table class="info-cta" style="margin: 0 auto;">
                      <tbody>
                        <tr>
                          <td class="em-spacer-5" style="height: 32px;text-align: center;"></td>
                        </tr>
                        <tr>
                          <td class="title" style="text-align: center;font-weight: 700;text-transform: uppercase;font-size: 19px;padding-bottom: 18px;">
Questions? We are on call.</td>
                        </tr>
                        <tr>
                          <td class="info" style="text-align: center;">
Monday to Friday 9am - 9pm ET                          </td>
                        </tr>
                          <tr>
                            <td class="info" style="text-align: center;">
Saturday to Sunday 10am - 6pm ET                            </td>
                          </tr>
                        <tr>
                          <td class="links" style="text-align: center;padding-top: 20px;">
                            <img src="https://operator-production.herokuapp.com/images/mailer/icon-bubble.jpg" class="icon-bubble" style="width: 28px;margin-bottom: -9px;margin-right: 3px;">

+254720671538                            <span class="pipe">
                              &nbsp;|&nbsp;
                            </span>
                            <img src="https://operator-production.herokuapp.com/images/mailer/icon-email.jpg" class="icon-email" style="margin-bottom: -6px;margin-right: 1px;width: 28px;">

info@writenod.com                       </td>
                        </tr>
                        <tr>
                          <td class="em-spacer-5" style="height: 32px;text-align: center;"></td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>

                <tr>
                  <td class="em-spacer-1" style="height: 26px;"></td>
                </tr>
                  <tr>
  <td class="box box-ext referral-box" style="background: #00237d;padding: 0 25px;text-align: center;color: #fff;font-family: Helvetica">
    <table class="referral-info" style="margin: 0 auto;">
      <tbody><tr>
        <td class="em-spacer-1" style="height: 26px;text-align: center;"></td>
      </tr>
      <tr align="center">
        <td class="friends-img-wrap" style="padding-bottom: 8px;text-align: center;">
          <a href="https://casper.com/anon/friends?utm_campaign=order+confirmation&amp;utm_content=thank+you+for+your+order&amp;utm_medium=email&amp;utm_source=casper+support" target="_blank" style="color: #fff;">
            <img src="https://operator-production.herokuapp.com/images/mailer/friends.jpg" width="68">
          </a>
        </td>
      </tr>

      <tr>
        <td class="info" style="text-align: center;">
Refer friends, earn rewards.        </td>
      </tr>
      <tr>
        <td class="em-spacer-0" style="height: 20px;text-align: center;"></td>
      </tr>
      <tr>
        <td class="link" style="text-align: center;">
          <a href="https://casper.com/anon/friends?utm_campaign=order+confirmation&amp;utm_content=thank+you+for+your+order&amp;utm_medium=email&amp;utm_source=casper+support" target="_blank" style="color: #fff;">Learn More</a>
        </td>
      </tr>
      <tr>
        <td class="em-spacer-1" style="height: 26px;text-align: center;"></td>
      </tr>
    </tbody></table>
  </td>
</tr>


</tbody></table><table style="margin: 0 auto;">
  <tbody><tr>
    <td class="em-spacer-2" style="height: 52px;"></td>
  </tr>
  <tr>
    <td class="footer footer-1" style="color: #999;font-size: 13px;">
+254720671538     <span class="pipe">
        &nbsp;|&nbsp;
      </span>
      info@writenod.com</td>
  </tr>
  <tr>
    <td class="em-spacer-0" style="height: 20px;"></td>
  </tr>
  </tbody></table></td></tr></tbody></table>


             <!-- class content -->
          
        
   

</body>
</html>
                    
				';
        return $html;
    }
	public function pay_senderid_with_credits(Request $request){
		$authoriation_document = Session::get('authoriation_document');
		
		$cost=floatval($request->cost);	
		$credits=floatval($request->credits);	
		$balcredits = $credits - $cost;
		$SMSCredit = SMSCredit::where('user_id', Auth::user()->id)->first();
		$SMSCredit->credit = $balcredits;
		$SMSCredit->save();

	    $sender_id = SenderID::find(Session::get('sender_id_id'));
	   	$sender_id->time = time();
		$sender_id->credit = $cost;
		$sender_id->authoriation_document = $authoriation_document;
		$sender_id->step = 4;
		$sender_id->save();
		session(['sender_id_paid' => 'paid']);
		session(['sender_id_step' => 4]);

		try{
			$company = Company::where('id', Auth::user()->company_id)->first()->name;
			$EMAIL = Setting::where('config_key','payment_email')->first()->config_value;
			$this->notification->sendMailMandrill($EMAIL, $this->adminemailtemplate(Auth::user()->name,$company,Session::get('sender_id')),'Sender ID Purchase Notification','Sender ID Purchase Notification');
			}catch(Exception $e){
					//return response(['status'=>"error"]);
		}
		Session::forget('sender_id_id');
		Session::forget('sender_id');
		Session::forget('authoriation_document');
		return response(['status'=>'success']);
		
	}
	    public function senderidcompany(Request $request){

        try{
			if($request->username==''){
				return response(['status'=>'error', 'details'=>"Please enter the company name"]);
			}
			else if($request->email==''){
				return response(['status'=>'error', 'details'=>"Please enter the company email"]);
			}else if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
				return response(['status'=>'error', 'details'=>"Please enter a valid email"]);
			}
		   else if($request->address==''){
				return response(['status'=>'error', 'details'=>"Please enter the company address"]);
			}
			else if($request->telno==''){
				return response(['status'=>'error', 'details'=>"Please enter the company mobile number."]);
			}
		    else if($request->file==''){
			 return response(['status'=>'error', 'details'=>"Please upload your company logo"]);
			}

			else{
				if($request->hasFile('file')){
				$extension = $request->file('file')->getClientOriginalExtension();
				if($extension!='png'&&$extension!='PNG'&&$extension!='jpg'&&$extension!='jpeg'){
				   return response(['status'=>'error', 'details'=>"Please upload a valid logo"]);
			    }else{
				$image = $request->file('file');
				$name = preg_replace('/\s+/', '_', $request->username) .'_'.time(). '.' . $extension;
                $destinationPath = $_SERVER['DOCUMENT_ROOT'] .'/logos';
				$image->move($destinationPath, $name);
				$sender_id = SenderID::find(Session::get('sender_id_id'));
				$sender_id->company_name = $request->username;
				$sender_id->address = $request->address;
				$sender_id->email = $request->email;
				$sender_id->phone = $request->phone;
				$sender_id->logo = $name;
				$sender_id->save();
				return response(['status'=>'success', 'details'=>$sender_id]);
				}
				}else{
					return response(['status'=>'error', 'details'=>"Please upload your company logo"]);
				}
			}
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
			 public function get_sender_id(){

        try{

            $sender_id = SenderID::find(Session::get('sender_id_id'));
            return response(['status'=>'success', 'details'=>$sender_id]);
			
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
		    public function editsenderid(Request $request){

        try{
			if($request->username==''){
				return response(['status'=>'error', 'details'=>"Please enter the company name"]);
			}
			else if($request->email==''){
				return response(['status'=>'error', 'details'=>"Please enter the company email"]);
			}else if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
				return response(['status'=>'error', 'details'=>"Please enter a valid email"]);
			}
		   else if($request->address==''){
				return response(['status'=>'error', 'details'=>"Please enter the company address"]);
			}
			else if($request->telno==''){
				return response(['status'=>'error', 'details'=>"Please enter the company mobile number."]);
			}else if($request->sender_id==''){
				return response(['status'=>'error', 'details'=>"Please enter the company sender ID"]);
			}
			else if($request->sender_id_desc==''){
				return response(['status'=>'error', 'details'=>"Please enter the sender  ID usage."]);
			}


			else{
				$sender_id = SenderID::find(Session::get('sender_id_id'));
				if($request->hasFile('file')){
				$extension = $request->file('file')->getClientOriginalExtension();
				if($extension!='png'&&$extension!='PNG'&&$extension!='jpg'&&$extension!='jpeg'){
				   return response(['status'=>'error', 'details'=>"Please upload a valid logo"]);
			    }else{
				$image = $request->file('file');
				$name = preg_replace('/\s+/', '_', $request->username) .'_'.time(). '.' . $extension;
                $destinationPath = $_SERVER['DOCUMENT_ROOT'] .'/logos';
				$image->move($destinationPath, $name);
			
				$sender_id->logo = $name;
			
				}
				}
				$sender_id->company_name = $request->username;
				$sender_id->address = $request->address;
				$sender_id->email = $request->email;
				$sender_id->phone = $request->phone;
				$sender_id->sender_id = $request->sender_id;
				$sender_id->usage = $request->sender_id_desc;
				$sender_id->save();
				return response(['status'=>'success', 'details'=>$sender_id]);
			}
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
	
	public
	function createSenderIDPayment(Request $request) {
			$factory = new Factory;
			$generator = $factory->getLowStrengthGenerator();
			$number  = $generator->generateString(4, '123456789');
			$pp_username = 'xanton94-facilitator_api1.gmail.com'; 
			$pp_password = '92MRPRF2QRL9AW69'; 
			$pp_signature = 'AFcWxV21C7fd0v3bYYYRCpSSRl31AmFGKjy2F8Kdx2uiAREun-ep-1Ed'; 

			//$pp_username = Setting::where('config_key','paypal_username')->first()->config_value;
			//$pp_password = Setting::where('config_key','paypal_password')->first()->config_value;
			//$pp_signature = Setting::where('config_key','paypal_signature')->first()->config_value;
			$pp_logo = Setting::where('config_key','paypal_logo')->first()->config_value;
			$pp_bg_color = Setting::where('config_key','paypal_bg_color')->first()->config_value;
			$paypal_service = Setting::where('config_key','paypal_service')->first()->config_value;
		
		//echo $_POST['curr'];
		$company = Company::where('id',Auth::user()->company_id)->first();
		$mydata = array(
			'USER' => $pp_username,
			'PWD' => $pp_password,
			'SIGNATURE' => $pp_signature,
			'METHOD' => 'SetExpressCheckout',
			'VERSION' => 124.0,
			'PAYMENTREQUEST_0_AMT' => $request->input('amount'),
			'PAYMENTREQUEST_0_CURRENCYCODE' => 'USD',
			'PAYMENTREQUEST_0_PAYMENTACTION' => 'SALE',
			'PAYMENTREQUEST_0_SELLERPAYPALACCOUNTID' => 'admin@amexwrite.com',
			'PAYMENTREQUEST_0_DESC' => $company->name,
			'PAYMENTREQUEST_0_INVNUM' => $company->name,
			'cancelUrl' => url('/sms/senderID'),
			'returnUrl' => url('/sms/senderID'),
			'PAYMENTREQUEST_0_ITEMAMT' => $request->input('amount'), // ammount 

			'L_PAYMENTREQUEST_0_NAME0' =>  $company->fname.' '. $company->lname,
			'L_PAYMENTREQUEST_0_NUMBER0' => $number, // order id
			'L_PAYMENTREQUEST_0_QTY0' => 1,
			'L_PAYMENTREQUEST_0_AMT0' => $request->input('amount'), // amount
			'L_PAYMENTREQUEST_0_DESC0' => $company->name
		);


		session(['amt' => $request->input('amount')]);
		session(['number' => $number]);


		$postdata = http_build_query( $mydata );
		//$url = 'https://api-3t.paypal.com/nvp';
		$url = 'https://api-3t.sandbox.paypal.com/nvp';
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $postdata );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		$response = curl_exec( $ch );
		curl_close( $ch );
		if ( $response ) {



			$res = explode( '&', $response );
			/*$response_array would be something like
			[
			"TOKEN=EC%2d0VF85491NF796042N",
			"TIMESTAMP=2014%2d06%2d26T17%3a03%3a34Z",
			"CORRELATIONID=8b60fba0145f7",
			"ACK=Success",
			"VERSION=109%2e0",
			"BUILD=11624049"
			]*/

			//Cover string format to key value pair
			$response_pair = array();
			foreach ( $res as $val_string ) {
				$response_val_pair = explode( "=", $val_string );
				$response_pair[ $response_val_pair[ 0 ] ] = urldecode( $response_val_pair[ 1 ] );

			}
			//echo $response_pair['ACK'];
			if ( $response_pair[ 'ACK' ] == 'Success' ) {

				$ch = curl_init( $url );

				$params = array(
					'method' => 'GetExpressCheckoutDetails',
					'token' => $response_pair[ 'TOKEN' ],
					'version' => 124.0,
					'user' => $pp_username,
					'pwd' => $pp_password,
					'signature' => $pp_signature,
					'PAYMENTREQUEST_0_AMT' => $request->input('amount'),
					'PAYMENTREQUEST_0_CURRENCYCODE' => 'USD',
					'PAYMENTREQUEST_0_PAYMENTACTION' => 'SALE',
					'PAYMENTREQUEST_0_SELLERPAYPALACCOUNTID' => 'admin@amexwrite.com',
					'PAYMENTREQUEST_0_DESC' => $company->name,
					'PAYMENTREQUEST_0_INVNUM' => $company->name,
					'cancelUrl' => url('/sms/senderID'),
					'returnUrl' => url('/sms/senderID'),
				);

				curl_setopt( $ch, CURLOPT_POST, true );
				curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $params ) );
				curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
				curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 1 );
				curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 2 );

				$response2 = curl_exec( $ch );
				curl_close( $ch );


				$response_array = explode( '&', $response2 );
				$response_pair2 = array();
				foreach ( $response_array as $val_string2 ) {
					$response_val_pair2 = explode( "=", $val_string2 );
					$response_pair2[ $response_val_pair2[ 0 ] ] = urldecode( $response_val_pair2[ 1 ] );

				}

				if ( $response_pair2[ 'ACK' ] == 'Success' ) {
					echo '{"TOKEN":"' . $response_pair2[ 'TOKEN' ] . '"}';
					session(['expr_check_dets' => $response_pair2]);
				} else {
					echo $response_pair2[ 'ACK' ];
				}

				//echo "{'token':$token[1]}";
			} else {
				echo 'error2';
			}

		} else {
			echo 'error';
		}


		//include_once('Checkout.php');
		//$pay = new Checkout();
		//echo json_encode($pay->createPayment());
	}

	public
	function completeSenderIDPayment(Request $request) {
			$company = Company::where('id',Auth::user()->company_id)->first();
			//$pp_username = Setting::where('config_key','paypal_username')->first()->config_value;
			//$pp_password = Setting::where('config_key','paypal_password')->first()->config_value;
			//$pp_signature = Setting::where('config_key','paypal_signature')->first()->config_value;
			$pp_username = 'xanton94-facilitator_api1.gmail.com'; 
			$pp_password = '92MRPRF2QRL9AW69'; 
			$pp_signature = 'AFcWxV21C7fd0v3bYYYRCpSSRl31AmFGKjy2F8Kdx2uiAREun-ep-1Ed'; 
			$pp_logo = Setting::where('config_key','paypal_logo')->first()->config_value;
			$pp_bg_color = Setting::where('config_key','paypal_bg_color')->first()->config_value;
			$paypal_service = Setting::where('config_key','paypal_service')->first()->config_value;
		
		//$ch = new CURL_Util( 'https://api-3t.paypal.com/nvp', array(
		$ch = new CURL_Util( 'https://api-3t.sandbox.paypal.com/nvp', array(
			'USER' => $pp_username,
			'PWD' => $pp_password,
			'SIGNATURE' => $pp_signature,
			'METHOD' => 'SetExpressCheckout',
			'VERSION' => 124.0,
			'TOKEN' => $_POST[ 'paymentToken' ],
			'PAYERID' => $_POST[ 'payerId' ],
			'cancelUrl' => url('/sms/senderID'),
			'returnUrl' => url('/sms/senderID'),
			'PAYMENTREQUEST_0_AMT' => Session::get('amt'),
			"PAYMENTREQUEST_0_NUMBER" => Session::get('number'),
			'PAYMENTREQUEST_0_PAYMENTACTION' => 'Sale',
			'PAYMENTREQUEST_0_SELLERPAYPALACCOUNTID' => 'admin@amexwrite.com',
			'PAYMENTREQUEST_0_DESC' => $company->name,
			'PAYMENTREQUEST_0_INVNUM' => $company->name,
			'PAYMENTREQUEST_0_CURRENCYCODE' => 'USD',
			'PAYMENTREQUEST_0_ITEMAMT' => Session::get('amt'), // ammount 

			'L_PAYMENTREQUEST_0_NAME0' => $company->fname.' '.$company->lname,
			'L_PAYMENTREQUEST_0_NUMBER0' => Session::get('number'), // order id
			'L_PAYMENTREQUEST_0_QTY0' => 1,
			'L_PAYMENTREQUEST_0_AMT0' => Session::get('amt'), // amount
			'L_PAYMENTREQUEST_0_DESC0' => $company->name
		) );

		$response = $ch->exec();
		$redirect_url = '';

		if ( $response[ 'ACK' ] == 'Success' ) {
			$post_values = array(

				"METHOD" => "DoExpressCheckoutPayment",
				"VERSION" => 124.0,
				"USER" => $pp_username,
				"PWD" => $pp_password,
				"SIGNATURE" => $pp_signature,
				"PAYMENTREQUEST_0_PAYMENTACTION" => "Sale",

				'TOKEN' => $_POST[ 'paymentToken' ],
				'PAYERID' => $_POST[ 'payerId' ],
				"PAYMENTREQUEST_0_AMT" =>Session::get('amt'),
				"PAYMENTREQUEST_0_NUMBER" => Session::get('number'),
				'cancelUrl' => url('/sms/senderID'),
				'returnUrl' => url('/sms/senderID'),
				'PAYMENTREQUEST_0_SELLERPAYPALACCOUNTID' => 'admin@amexwrite.com',
				'PAYMENTREQUEST_0_DESC' => $company->name,
				'PAYMENTREQUEST_0_INVNUM' =>$company->name,
				'PAYMENTREQUEST_0_CURRENCYCODE' =>'USD',
				'PAYMENTREQUEST_0_ITEMAMT' => Session::get('amt')
			);

			//$request = curl_init(); // initiate curl object
			//curl_setopt($ch,CURLOPT_URL ,'https://api-3t.sandbox.paypal.com/nvp');
			//curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
			//curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
			//curl_setopt($request, CURLOPT_POSTFIELDS, $post_values); // use HTTP POST to send form data
			//curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response.
			//$post_response = curl_exec($request); // execute curl post and store results in $post_response
			//curl_close ($post_response);

			$chs = curl_init();
			//curl_setopt( $chs, CURLOPT_URL, 'https://api-3t.paypal.com/nvp' );
			curl_setopt( $chs, CURLOPT_URL, 'https://api-3t.sandbox.paypal.com/nvp' );
			curl_setopt( $chs, CURLOPT_VERBOSE, 1 );
			curl_setopt( $chs, CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt( $chs, CURLOPT_SSL_VERIFYHOST, false );
			curl_setopt( $chs, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt( $chs, CURLOPT_HTTPGET, true );
			curl_setopt( $chs, CURLOPT_POSTFIELDS, http_build_query( $post_values ) );
			$post_response = curl_exec( $chs );
		//	print_r($post_response);

			$response_array = explode( "&", $post_response );
			$final_response_val_pair_array = array();
			foreach ( $response_array as $val_string ) {
				$response_val_pair = explode( "=", $val_string );
				$final_response_val_pair_array[ $response_val_pair[ 0 ] ] = urldecode( $response_val_pair[ 1 ] );
			}

			if ( $final_response_val_pair_array[ 'ACK' ] == 'Success' ) {

				/*
				Every thing good, save the order to db and unset cart data in $_SEESION. Something like:
				$order = new Orders(); ... $order->save(); $_SESSION["cart"];
				Then redirect the user to a thankyou page
				*/
				// Set example cart data into session									
						$payment = new PaypalSMSPayment;
						$payment->amount = $final_response_val_pair_array['PAYMENTINFO_0_AMT'];
						$payment->order_time = $final_response_val_pair_array['PAYMENTINFO_0_ORDERTIME'];
						$payment->currency = $final_response_val_pair_array['PAYMENTINFO_0_CURRENCYCODE'];
						$payment->reference = $final_response_val_pair_array['PAYMENTINFO_0_TRANSACTIONID'];
						$payment->payment_status =  $final_response_val_pair_array['PAYMENTINFO_0_PAYMENTSTATUS'];
						$payment->credit = Session::get('amount_payed');
						$payment->user_id = Auth::user()->id;
						$payment->company_id = Auth::user()->company_id;
						$payment->save();

						$SMSCredit = SMSCredit::where('user_id', Auth::user()->id)->first();
						if(empty($SMSCredit)){
						$credits = new SMSCredit;
						$credits->credit = Session::get('amount_payed');
						$credits->user_id = Auth::user()->id;
						$credits->company_id = Auth::user()->company_id;
						$credits->save();
						}else{
						$finalcredit = Session::get('amount_payed') + floatval($SMSCredit->credit);
						$SMSCredit->credit = $finalcredit;
						$SMSCredit->save();
						}
				session(['shopping_cart' => $final_response_val_pair_array]);
				session(['sender_id_credits' => 'paid']);
			
				try{
					$this->notification->sendMailMandrill(Auth::user()->email, $this->emailtemplate(Auth::user()->name,$final_response_val_pair_array['PAYMENTINFO_0_TRANSACTIONID'],Auth::user()->phone,Auth::user()->email,Auth::user()->address,Session::get('amount_payed'),'Paypal'),'Credits Purchase','Credits Purchase');
				}catch(Exception $e){
					//return response(['status'=>"error"]);
				}
				$redirect_url =  url('/sms/senderID');
				Session::forget('amount_payed');

			} else {
				//error handling for the third/final apis call, DoExpressCheckoutPayment
				$msg = "error_code=" . $final_response_val_pair_array[ 'L_ERRORCODE0' ];
				$msg .= "&message=" . $final_response_val_pair_array[ 'L_LONGMESSAGE0' ];
				//$final_response_val_pair_array['L_SHORTMESSAGE0'];
			   $redirect_url = url('/sms/senderID');

			}


		} else {
			//error handling for the third/final apis call, DoExpressCheckoutPayment
			$msg = "error_code=" . $response[ 'L_ERRORCODE0' ];
			$msg .= "&message=" . $response[ 'L_LONGMESSAGE0' ];
			//$final_response_val_pair_array['L_SHORTMESSAGE0'];
		$redirect_url = url('/sms/senderID');


		}

		echo '{"redirect":"' . $redirect_url . '"}';
	}
    public
	function createSenderIDPayment1(Request $request) {
			$factory = new Factory;
			$generator = $factory->getLowStrengthGenerator();
			$number  = $generator->generateString(4, '123456789');
			$pp_username = 'xanton94-facilitator_api1.gmail.com'; 
			$pp_password = '92MRPRF2QRL9AW69'; 
			$pp_signature = 'AFcWxV21C7fd0v3bYYYRCpSSRl31AmFGKjy2F8Kdx2uiAREun-ep-1Ed'; 

			//$pp_username = Setting::where('config_key','paypal_username')->first()->config_value;
			//$pp_password = Setting::where('config_key','paypal_password')->first()->config_value;
			//$pp_signature = Setting::where('config_key','paypal_signature')->first()->config_value;
			$pp_logo = Setting::where('config_key','paypal_logo')->first()->config_value;
			$pp_bg_color = Setting::where('config_key','paypal_bg_color')->first()->config_value;
			$paypal_service = Setting::where('config_key','paypal_service')->first()->config_value;
		
		//echo $_POST['curr'];
		$company = Company::where('id',Auth::user()->company_id)->first();
		$mydata = array(
			'USER' => $pp_username,
			'PWD' => $pp_password,
			'SIGNATURE' => $pp_signature,
			'METHOD' => 'SetExpressCheckout',
			'VERSION' => 124.0,
			'PAYMENTREQUEST_0_AMT' => $request->input('amount'),
			'PAYMENTREQUEST_0_CURRENCYCODE' => 'USD',
			'PAYMENTREQUEST_0_PAYMENTACTION' => 'SALE',
			'PAYMENTREQUEST_0_SELLERPAYPALACCOUNTID' => 'admin@amexwrite.com',
			'PAYMENTREQUEST_0_DESC' => $company->name,
			'PAYMENTREQUEST_0_INVNUM' => $company->name,
			'cancelUrl' => url('/sms/senderID'.Session::get('sender_id_id')),
			'returnUrl' => url('/sms/senderID'.Session::get('sender_id_id')),
			'PAYMENTREQUEST_0_ITEMAMT' => $request->input('amount'), // ammount 

			'L_PAYMENTREQUEST_0_NAME0' =>  $company->fname.' '. $company->lname,
			'L_PAYMENTREQUEST_0_NUMBER0' => $number, // order id
			'L_PAYMENTREQUEST_0_QTY0' => 1,
			'L_PAYMENTREQUEST_0_AMT0' => $request->input('amount'), // amount
			'L_PAYMENTREQUEST_0_DESC0' => $company->name
		);


		session(['amt' => $request->input('amount')]);
		session(['number' => $number]);


		$postdata = http_build_query( $mydata );
		//$url = 'https://api-3t.paypal.com/nvp';
		$url = 'https://api-3t.sandbox.paypal.com/nvp';
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $postdata );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		$response = curl_exec( $ch );
		curl_close( $ch );
		if ( $response ) {



			$res = explode( '&', $response );
			/*$response_array would be something like
			[
			"TOKEN=EC%2d0VF85491NF796042N",
			"TIMESTAMP=2014%2d06%2d26T17%3a03%3a34Z",
			"CORRELATIONID=8b60fba0145f7",
			"ACK=Success",
			"VERSION=109%2e0",
			"BUILD=11624049"
			]*/

			//Cover string format to key value pair
			$response_pair = array();
			foreach ( $res as $val_string ) {
				$response_val_pair = explode( "=", $val_string );
				$response_pair[ $response_val_pair[ 0 ] ] = urldecode( $response_val_pair[ 1 ] );

			}
			//echo $response_pair['ACK'];
			if ( $response_pair[ 'ACK' ] == 'Success' ) {

				$ch = curl_init( $url );

				$params = array(
					'method' => 'GetExpressCheckoutDetails',
					'token' => $response_pair[ 'TOKEN' ],
					'version' => 124.0,
					'user' => $pp_username,
					'pwd' => $pp_password,
					'signature' => $pp_signature,
					'PAYMENTREQUEST_0_AMT' => $request->input('amount'),
					'PAYMENTREQUEST_0_CURRENCYCODE' => 'USD',
					'PAYMENTREQUEST_0_PAYMENTACTION' => 'SALE',
					'PAYMENTREQUEST_0_SELLERPAYPALACCOUNTID' => 'admin@amexwrite.com',
					'PAYMENTREQUEST_0_DESC' => $company->name,
					'PAYMENTREQUEST_0_INVNUM' => $company->name,
					'cancelUrl' => url('/sms/senderID'.Session::get('sender_id_id')),
					'returnUrl' => url('/sms/senderID'.Session::get('sender_id_id')),
				);

				curl_setopt( $ch, CURLOPT_POST, true );
				curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $params ) );
				curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
				curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 1 );
				curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 2 );

				$response2 = curl_exec( $ch );
				curl_close( $ch );


				$response_array = explode( '&', $response2 );
				$response_pair2 = array();
				foreach ( $response_array as $val_string2 ) {
					$response_val_pair2 = explode( "=", $val_string2 );
					$response_pair2[ $response_val_pair2[ 0 ] ] = urldecode( $response_val_pair2[ 1 ] );

				}

				if ( $response_pair2[ 'ACK' ] == 'Success' ) {
					echo '{"TOKEN":"' . $response_pair2[ 'TOKEN' ] . '"}';
					session(['expr_check_dets' => $response_pair2]);
				} else {
					echo $response_pair2[ 'ACK' ];
				}

				//echo "{'token':$token[1]}";
			} else {
				echo 'error2';
			}

		} else {
			echo 'error';
		}

	}
	public
	function completeSenderIDPayment1(Request $request) {
			$company = Company::where('id',Auth::user()->company_id)->first();
			//$pp_username = Setting::where('config_key','paypal_username')->first()->config_value;
			//$pp_password = Setting::where('config_key','paypal_password')->first()->config_value;
			//$pp_signature = Setting::where('config_key','paypal_signature')->first()->config_value;
			$pp_username = 'xanton94-facilitator_api1.gmail.com'; 
			$pp_password = '92MRPRF2QRL9AW69'; 
			$pp_signature = 'AFcWxV21C7fd0v3bYYYRCpSSRl31AmFGKjy2F8Kdx2uiAREun-ep-1Ed'; 
			$pp_logo = Setting::where('config_key','paypal_logo')->first()->config_value;
			$pp_bg_color = Setting::where('config_key','paypal_bg_color')->first()->config_value;
			$paypal_service = Setting::where('config_key','paypal_service')->first()->config_value;
		
		//$ch = new CURL_Util( 'https://api-3t.paypal.com/nvp', array(
		$ch = new CURL_Util( 'https://api-3t.sandbox.paypal.com/nvp', array(
			'USER' => $pp_username,
			'PWD' => $pp_password,
			'SIGNATURE' => $pp_signature,
			'METHOD' => 'SetExpressCheckout',
			'VERSION' => 124.0,
			'TOKEN' => $_POST[ 'paymentToken' ],
			'PAYERID' => $_POST[ 'payerId' ],
			'cancelUrl' => url('/sms/senderID'.Session::get('sender_id_id')),
			'returnUrl' => url('/sms/senderID'.Session::get('sender_id_id')),
			'PAYMENTREQUEST_0_AMT' => Session::get('amt'),
			"PAYMENTREQUEST_0_NUMBER" => Session::get('number'),
			'PAYMENTREQUEST_0_PAYMENTACTION' => 'Sale',
			'PAYMENTREQUEST_0_SELLERPAYPALACCOUNTID' => 'admin@amexwrite.com',
			'PAYMENTREQUEST_0_DESC' => $company->name,
			'PAYMENTREQUEST_0_INVNUM' => $company->name,
			'PAYMENTREQUEST_0_CURRENCYCODE' => 'USD',
			'PAYMENTREQUEST_0_ITEMAMT' => Session::get('amt'), // ammount 

			'L_PAYMENTREQUEST_0_NAME0' => $company->fname.' '.$company->lname,
			'L_PAYMENTREQUEST_0_NUMBER0' => Session::get('number'), // order id
			'L_PAYMENTREQUEST_0_QTY0' => 1,
			'L_PAYMENTREQUEST_0_AMT0' => Session::get('amt'), // amount
			'L_PAYMENTREQUEST_0_DESC0' => $company->name
		) );

		$response = $ch->exec();
		$redirect_url = '';

		if ( $response[ 'ACK' ] == 'Success' ) {
			$post_values = array(

				"METHOD" => "DoExpressCheckoutPayment",
				"VERSION" => 124.0,
				"USER" => $pp_username,
				"PWD" => $pp_password,
				"SIGNATURE" => $pp_signature,
				"PAYMENTREQUEST_0_PAYMENTACTION" => "Sale",

				'TOKEN' => $_POST[ 'paymentToken' ],
				'PAYERID' => $_POST[ 'payerId' ],
				"PAYMENTREQUEST_0_AMT" =>Session::get('amt'),
				"PAYMENTREQUEST_0_NUMBER" => Session::get('number'),
				'cancelUrl' => url('/sms/senderID'.Session::get('sender_id_id')),
				'returnUrl' => url('/sms/senderID'.Session::get('sender_id_id')),
				'PAYMENTREQUEST_0_SELLERPAYPALACCOUNTID' => 'admin@amexwrite.com',
				'PAYMENTREQUEST_0_DESC' => $company->name,
				'PAYMENTREQUEST_0_INVNUM' =>$company->name,
				'PAYMENTREQUEST_0_CURRENCYCODE' =>'USD',
				'PAYMENTREQUEST_0_ITEMAMT' => Session::get('amt')
			);

			//$request = curl_init(); // initiate curl object
			//curl_setopt($ch,CURLOPT_URL ,'https://api-3t.sandbox.paypal.com/nvp');
			//curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
			//curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
			//curl_setopt($request, CURLOPT_POSTFIELDS, $post_values); // use HTTP POST to send form data
			//curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response.
			//$post_response = curl_exec($request); // execute curl post and store results in $post_response
			//curl_close ($post_response);

			$chs = curl_init();
			//curl_setopt( $chs, CURLOPT_URL, 'https://api-3t.paypal.com/nvp' );
			curl_setopt( $chs, CURLOPT_URL, 'https://api-3t.sandbox.paypal.com/nvp' );
			curl_setopt( $chs, CURLOPT_VERBOSE, 1 );
			curl_setopt( $chs, CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt( $chs, CURLOPT_SSL_VERIFYHOST, false );
			curl_setopt( $chs, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt( $chs, CURLOPT_HTTPGET, true );
			curl_setopt( $chs, CURLOPT_POSTFIELDS, http_build_query( $post_values ) );
			$post_response = curl_exec( $chs );
		//	print_r($post_response);

			$response_array = explode( "&", $post_response );
			$final_response_val_pair_array = array();
			foreach ( $response_array as $val_string ) {
				$response_val_pair = explode( "=", $val_string );
				$final_response_val_pair_array[ $response_val_pair[ 0 ] ] = urldecode( $response_val_pair[ 1 ] );
			}

			if ( $final_response_val_pair_array[ 'ACK' ] == 'Success' ) {

				/*
				Every thing good, save the order to db and unset cart data in $_SEESION. Something like:
				$order = new Orders(); ... $order->save(); $_SESSION["cart"];
				Then redirect the user to a thankyou page
				*/
				// Set example cart data into session									
						$payment = new PaypalSMSPayment;
						$payment->amount = $final_response_val_pair_array['PAYMENTINFO_0_AMT'];
						$payment->order_time = $final_response_val_pair_array['PAYMENTINFO_0_ORDERTIME'];
						$payment->currency = $final_response_val_pair_array['PAYMENTINFO_0_CURRENCYCODE'];
						$payment->reference = $final_response_val_pair_array['PAYMENTINFO_0_TRANSACTIONID'];
						$payment->payment_status =  $final_response_val_pair_array['PAYMENTINFO_0_PAYMENTSTATUS'];
						$payment->credit = Session::get('amount_payed');
						$payment->user_id = Auth::user()->id;
						$payment->company_id = Auth::user()->company_id;
						$payment->save();
						

						
						$SMSCredit = SMSCredit::where('user_id', Auth::user()->id)->first();
						if(empty($SMSCredit)){
						$credits = new SMSCredit;
						$credits->credit = Session::get('amount_payed');
						$credits->user_id = Auth::user()->id;
						$credits->company_id = Auth::user()->company_id;
						$credits->save();
						}else{
						$finalcredit = Session::get('amount_payed') + floatval($SMSCredit->credit);
						$SMSCredit->credit = $finalcredit;
						$SMSCredit->save();
						}
				session(['shopping_cart' => $final_response_val_pair_array]);
				session(['sender_id_credits' => 'paid']);
			
				try{
					$this->notification->sendMailMandrill(Auth::user()->email, $this->emailtemplate(Auth::user()->name,$final_response_val_pair_array['PAYMENTINFO_0_TRANSACTIONID'],Auth::user()->phone,Auth::user()->email,Auth::user()->address,Session::get('amount_payed'),'Paypal'),'Credits Purchase','Credits Purchase');
				}catch(Exception $e){
					//return response(['status'=>"error"]);
				}
				$redirect_url =  url('/sms/senderID'.Session::get('sender_id_id'));
				Session::forget('amount_payed');

			} else {
				//error handling for the third/final apis call, DoExpressCheckoutPayment
				$msg = "error_code=" . $final_response_val_pair_array[ 'L_ERRORCODE0' ];
				$msg .= "&message=" . $final_response_val_pair_array[ 'L_LONGMESSAGE0' ];
				//$final_response_val_pair_array['L_SHORTMESSAGE0'];
			   $redirect_url = url('/sms/senderID'.Session::get('sender_id_id'));

			}


		} else {
			//error handling for the third/final apis call, DoExpressCheckoutPayment
			$msg = "error_code=" . $response[ 'L_ERRORCODE0' ];
			$msg .= "&message=" . $response[ 'L_LONGMESSAGE0' ];
			//$final_response_val_pair_array['L_SHORTMESSAGE0'];
		$redirect_url = url('/sms/senderID'.Session::get('sender_id_id'));


		}

		echo '{"redirect":"' . $redirect_url . '"}';
	}
	public
	function createSMSCreditPayment(Request $request) {
			$factory = new Factory;
			$generator = $factory->getLowStrengthGenerator();
			$number  = $generator->generateString(4, '123456789');
			$pp_username = 'xanton94-facilitator_api1.gmail.com'; 
			$pp_password = '92MRPRF2QRL9AW69'; 
			$pp_signature = 'AFcWxV21C7fd0v3bYYYRCpSSRl31AmFGKjy2F8Kdx2uiAREun-ep-1Ed'; 

			//$pp_username = Setting::where('config_key','paypal_username')->first()->config_value;
			//$pp_password = Setting::where('config_key','paypal_password')->first()->config_value;
			//$pp_signature = Setting::where('config_key','paypal_signature')->first()->config_value;
			$pp_logo = Setting::where('config_key','paypal_logo')->first()->config_value;
			$pp_bg_color = Setting::where('config_key','paypal_bg_color')->first()->config_value;
			$paypal_service = Setting::where('config_key','paypal_service')->first()->config_value;
		
		//echo $_POST['curr'];
		//$company = Company::where('id',Auth::user()->company_id)->first();
		$company = User::where('id',Auth::user()->company_id)->first();
		$name= 'Nodcomm';
		$mydata = array(
			'USER' => $pp_username,
			'PWD' => $pp_password,
			'SIGNATURE' => $pp_signature,
			'METHOD' => 'SetExpressCheckout',
			'VERSION' => 124.0,
			'PAYMENTREQUEST_0_AMT' => $request->input('amount'),
			'PAYMENTREQUEST_0_CURRENCYCODE' => 'USD',
			'PAYMENTREQUEST_0_PAYMENTACTION' => 'SALE',
			'PAYMENTREQUEST_0_SELLERPAYPALACCOUNTID' => 'admin@amexwrite.com',
			'PAYMENTREQUEST_0_DESC' => $name,
			'PAYMENTREQUEST_0_INVNUM' => $name,
			'cancelUrl' => url('/purchase/credits'),
			'returnUrl' => url('/purchase/credits'),
			'PAYMENTREQUEST_0_ITEMAMT' => $request->input('amount'), // ammount 

			'L_PAYMENTREQUEST_0_NAME0' =>  $name,
			'L_PAYMENTREQUEST_0_NUMBER0' => $number, // order id
			'L_PAYMENTREQUEST_0_QTY0' => 1,
			'L_PAYMENTREQUEST_0_AMT0' => $request->input('amount'), // amount
			'L_PAYMENTREQUEST_0_DESC0' => $name
		);


		session(['amt' => $request->input('amount')]);
		session(['number' => $number]);


		$postdata = http_build_query( $mydata );
		//$url = 'https://api-3t.paypal.com/nvp';
		$url = 'https://api-3t.sandbox.paypal.com/nvp';
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $postdata );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		$response = curl_exec( $ch );
		curl_close( $ch );
		if ( $response ) {



			$res = explode( '&', $response );
			/*$response_array would be something like
			[
			"TOKEN=EC%2d0VF85491NF796042N",
			"TIMESTAMP=2014%2d06%2d26T17%3a03%3a34Z",
			"CORRELATIONID=8b60fba0145f7",
			"ACK=Success",
			"VERSION=109%2e0",
			"BUILD=11624049"
			]*/

			//Cover string format to key value pair
			$response_pair = array();
			foreach ( $res as $val_string ) {
				$response_val_pair = explode( "=", $val_string );
				$response_pair[ $response_val_pair[ 0 ] ] = urldecode( $response_val_pair[ 1 ] );

			}
			//echo $response_pair['ACK'];
			if ( $response_pair[ 'ACK' ] == 'Success' ) {

				$ch = curl_init( $url );

				$params = array(
					'method' => 'GetExpressCheckoutDetails',
					'token' => $response_pair[ 'TOKEN' ],
					'version' => 124.0,
					'user' => $pp_username,
					'pwd' => $pp_password,
					'signature' => $pp_signature,
					'PAYMENTREQUEST_0_AMT' => $request->input('amount'),
					'PAYMENTREQUEST_0_CURRENCYCODE' => 'USD',
					'PAYMENTREQUEST_0_PAYMENTACTION' => 'SALE',
					'PAYMENTREQUEST_0_SELLERPAYPALACCOUNTID' => 'admin@amexwrite.com',
					'PAYMENTREQUEST_0_DESC' => $name,
					'PAYMENTREQUEST_0_INVNUM' => $name,
					'cancelUrl' => url('/purchase/credits'),
					'returnUrl' => url('/purchase/credits'),
				);

				curl_setopt( $ch, CURLOPT_POST, true );
				curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $params ) );
				curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
				curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 1 );
				curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 2 );

				$response2 = curl_exec( $ch );
				curl_close( $ch );


				$response_array = explode( '&', $response2 );
				$response_pair2 = array();
				foreach ( $response_array as $val_string2 ) {
					$response_val_pair2 = explode( "=", $val_string2 );
					$response_pair2[ $response_val_pair2[ 0 ] ] = urldecode( $response_val_pair2[ 1 ] );

				}

				if ( $response_pair2[ 'ACK' ] == 'Success' ) {
					echo '{"TOKEN":"' . $response_pair2[ 'TOKEN' ] . '"}';
					session(['expr_check_dets' => $response_pair2]);
				} else {
					echo $response_pair2[ 'ACK' ];
				}

				//echo "{'token':$token[1]}";
			} else {
				echo 'error2';
			}

		} else {
			echo 'error';
		}


		//include_once('Checkout.php');
		//$pay = new Checkout();
		//echo json_encode($pay->createPayment());
	}

	public
	function completeSMSCreditPayment(Request $request) {
			//$company = Company::where('id',Auth::user()->company_id)->first();
			$company = User::where('id',Auth::user()->company_id)->first();
			$name= 'Nodcomm';
			//$pp_username = Setting::where('config_key','paypal_username')->first()->config_value;
			//$pp_password = Setting::where('config_key','paypal_password')->first()->config_value;
			//$pp_signature = Setting::where('config_key','paypal_signature')->first()->config_value;
			$pp_username = 'xanton94-facilitator_api1.gmail.com'; 
			$pp_password = '92MRPRF2QRL9AW69'; 
			$pp_signature = 'AFcWxV21C7fd0v3bYYYRCpSSRl31AmFGKjy2F8Kdx2uiAREun-ep-1Ed'; 
			$pp_logo = Setting::where('config_key','paypal_logo')->first()->config_value;
			$pp_bg_color = Setting::where('config_key','paypal_bg_color')->first()->config_value;
			$paypal_service = Setting::where('config_key','paypal_service')->first()->config_value;
		
		//$ch = new CURL_Util( 'https://api-3t.paypal.com/nvp', array(
		$ch = new CURL_Util( 'https://api-3t.sandbox.paypal.com/nvp', array(
			'USER' => $pp_username,
			'PWD' => $pp_password,
			'SIGNATURE' => $pp_signature,
			'METHOD' => 'SetExpressCheckout',
			'VERSION' => 124.0,
			'TOKEN' => $_POST[ 'paymentToken' ],
			'PAYERID' => $_POST[ 'payerId' ],
			'cancelUrl' => url('/purchase/credits'),
			'returnUrl' => url('/purchase/credits'),
			'PAYMENTREQUEST_0_AMT' => Session::get('amt'),
			"PAYMENTREQUEST_0_NUMBER" => Session::get('number'),
			'PAYMENTREQUEST_0_PAYMENTACTION' => 'Sale',
			'PAYMENTREQUEST_0_SELLERPAYPALACCOUNTID' => 'admin@amexwrite.com',
			'PAYMENTREQUEST_0_DESC' => $name,
			'PAYMENTREQUEST_0_INVNUM' => $name,
			'PAYMENTREQUEST_0_CURRENCYCODE' => 'USD',
			'PAYMENTREQUEST_0_ITEMAMT' => Session::get('amt'), // ammount 

			'L_PAYMENTREQUEST_0_NAME0' => $name,
			'L_PAYMENTREQUEST_0_NUMBER0' => Session::get('number'), // order id
			'L_PAYMENTREQUEST_0_QTY0' => 1,
			'L_PAYMENTREQUEST_0_AMT0' => Session::get('amt'), // amount
			'L_PAYMENTREQUEST_0_DESC0' => $name
		) );

		$response = $ch->exec();
		$redirect_url = '';

		if ( $response[ 'ACK' ] == 'Success' ) {
			$post_values = array(

				"METHOD" => "DoExpressCheckoutPayment",
				"VERSION" => 124.0,
				"USER" => $pp_username,
				"PWD" => $pp_password,
				"SIGNATURE" => $pp_signature,
				"PAYMENTREQUEST_0_PAYMENTACTION" => "Sale",

				'TOKEN' => $_POST[ 'paymentToken' ],
				'PAYERID' => $_POST[ 'payerId' ],
				"PAYMENTREQUEST_0_AMT" =>Session::get('amt'),
				"PAYMENTREQUEST_0_NUMBER" => Session::get('number'),
				'cancelUrl' => url('/purchase/credits'),
				'returnUrl' => url('/purchase/credits'),
				'PAYMENTREQUEST_0_SELLERPAYPALACCOUNTID' => 'admin@amexwrite.com',
				'PAYMENTREQUEST_0_DESC' => $name,
				'PAYMENTREQUEST_0_INVNUM' =>$name,
				'PAYMENTREQUEST_0_CURRENCYCODE' =>'USD',
				'PAYMENTREQUEST_0_ITEMAMT' => Session::get('amt')
			);

			//$request = curl_init(); // initiate curl object
			//curl_setopt($ch,CURLOPT_URL ,'https://api-3t.sandbox.paypal.com/nvp');
			//curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
			//curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
			//curl_setopt($request, CURLOPT_POSTFIELDS, $post_values); // use HTTP POST to send form data
			//curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response.
			//$post_response = curl_exec($request); // execute curl post and store results in $post_response
			//curl_close ($post_response);

			$chs = curl_init();
			//curl_setopt( $chs, CURLOPT_URL, 'https://api-3t.paypal.com/nvp' );
			curl_setopt( $chs, CURLOPT_URL, 'https://api-3t.sandbox.paypal.com/nvp' );
			curl_setopt( $chs, CURLOPT_VERBOSE, 1 );
			curl_setopt( $chs, CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt( $chs, CURLOPT_SSL_VERIFYHOST, false );
			curl_setopt( $chs, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt( $chs, CURLOPT_HTTPGET, true );
			curl_setopt( $chs, CURLOPT_POSTFIELDS, http_build_query( $post_values ) );
			$post_response = curl_exec( $chs );
		//	print_r($post_response);

			$response_array = explode( "&", $post_response );
			$final_response_val_pair_array = array();
			foreach ( $response_array as $val_string ) {
				$response_val_pair = explode( "=", $val_string );
				$final_response_val_pair_array[ $response_val_pair[ 0 ] ] = urldecode( $response_val_pair[ 1 ] );
			}

			if ( $final_response_val_pair_array[ 'ACK' ] == 'Success' ) {

				/*
				Every thing good, save the order to db and unset cart data in $_SEESION. Something like:
				$order = new Orders(); ... $order->save(); $_SESSION["cart"];
				Then redirect the user to a thankyou page
				*/
				// Set example cart data into session									
						$payment = new PaypalSMSPayment;
						$payment->amount = $final_response_val_pair_array['PAYMENTINFO_0_AMT'];
						$payment->order_time = $final_response_val_pair_array['PAYMENTINFO_0_ORDERTIME'];
						$payment->currency = $final_response_val_pair_array['PAYMENTINFO_0_CURRENCYCODE'];
						$payment->reference = $final_response_val_pair_array['PAYMENTINFO_0_TRANSACTIONID'];
						$payment->payment_status =  $final_response_val_pair_array['PAYMENTINFO_0_PAYMENTSTATUS'];
						$payment->credit = Session::get('amount_payed');
						$payment->user_id = Auth::user()->id;
						$payment->company_id = Auth::user()->company_id;
						$payment->save();
						
						
					   $payments = PaypalSMSPayment::where('user_id', Auth::user()->id)->get();
						$credit = 0;
						if(!empty($payments)){
						foreach($payments as $payment){
							$credit +=  floatval($payment->credit);
						}
						}
						
						$SMSCredit = SMSCredit::where('user_id', Auth::user()->id)->first();
						if(empty($SMSCredit)){
						$credits = new SMSCredit;
						$credits->credit = $credit;
						$credits->user_id = Auth::user()->id;
						$credits->company_id = Auth::user()->company_id;
						$credits->save();
						}else{
						$SMSCredit->credit = $credit;
						$SMSCredit->save();
						}
				session(['shopping_cart' => $final_response_val_pair_array]);
				session(['sender_id_credits' => 'paid']);
				try{
					$this->notification->sendMailMandrill(Auth::user()->email, $this->emailtemplate(Auth::user()->name,$final_response_val_pair_array['PAYMENTINFO_0_TRANSACTIONID'],Auth::user()->phone,Auth::user()->email,Auth::user()->address,Session::get('amount_payed'),'Paypal'),'Credits Purchase','Credits Purchase');
				}catch(Exception $e){
					//return response(['status'=>"error"]);
				}

				Session::forget('amount_payed');
				$redirect_url =  url('/purchase/credits');


			} else {
				//error handling for the third/final apis call, DoExpressCheckoutPayment
				$msg = "error_code=" . $final_response_val_pair_array[ 'L_ERRORCODE0' ];
				$msg .= "&message=" . $final_response_val_pair_array[ 'L_LONGMESSAGE0' ];
				//$final_response_val_pair_array['L_SHORTMESSAGE0'];
			   $redirect_url = url('/purchase/credits');

			}


		} else {
			//error handling for the third/final apis call, DoExpressCheckoutPayment
			$msg = "error_code=" . $response[ 'L_ERRORCODE0' ];
			$msg .= "&message=" . $response[ 'L_LONGMESSAGE0' ];
			//$final_response_val_pair_array['L_SHORTMESSAGE0'];
		$redirect_url = url('/purchase/credits');


		}

		echo '{"redirect":"' . $redirect_url . '"}';
	}
	    public function adminemailtemplate($username, $company, $sender_id) {
        $html = '<!DOCTYPE html>
                    <html>

                    <head>
                        <title></title>
                        <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet" type="text/css"/>
                        <style type="text/css">
                            body {
                                font-family: ‘Lobster’, Arial, sans-serif;
                                font-weight: 400;
                                font-size: 14px;
                            }
                        </style>
                    </head>

                    <body style="">
                        <div style="height:20px;"></div>
                        <table cellpadding="0" cellspacing="0" style="width:320px; border-radius: 4px;overflow: hidden;background-color: #E8E8E8 ; border-collapse: collapse;  margin:0px auto; border: 1px solid #ccc; ">
                            <tr>
                                <td style="text-align: center; padding: 10px; border-bottom:2px solid #037caa; "><img style="width: 80%;" src="' . url('/images/Nodcomm.png'). '" alt="Company Logo"/>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 10px; background-color:#fff; ">
                                    <h3 style="color: #037caa">Sender ID Purchase Notification</h3> 
                                    <h4>Dear Administrator,</h4>
                                    <p>
                                   '.$username.' from '.$company.' has requested a sender ID ('.$sender_id.')</p>
                                    </p>
                                     
                                    <p>Regards,</p>
                                    <p>Nodcomm</p>
                                </td>
                            </tr>
                            <tr>
                                <td style=" text-align: center; color: #000; padding: 10px;">

                                    © ' . date( "Y" ) . ' ' . ' Nodcomm / Terms & Conditions / Privacy Notice</td>
                            </tr>
                        </table>

                    </body>

                    </html>
                    ';
        return $html;
    }
}
