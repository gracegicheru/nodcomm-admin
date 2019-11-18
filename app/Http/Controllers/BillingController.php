<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;
class BillingController extends Controller
{
    	 public function __construct()
	    {
			$this->middleware('auth');
	    }
		 public function index()
		{
		$paypal_client_ID = Setting::where('config_key','paypal_client_ID')->first()->config_value;
	    $paypal_mode = Setting::where('config_key','paypal_mode')->first()->config_value;
	    $amount = Setting::where('config_key','company_payable_amount')->first()->config_value;
		$data = array(
		'paypal_client_ID'=>$paypal_client_ID,
		'amount'=>$amount,
		'paypal_mode'=>$paypal_mode
		);
			 return view('billing')->with($data);
		}
}
