<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class Proxy extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function curl(Request $request){
    	$data = $request->input('data');
    	$url = $request->input('url');
    	//$function = $request->input('function');
    	
    	if(isset($data) && !empty($data) && isset($url) && !empty($url)){
	    	$final_post = http_build_query(json_decode($data));
	    	
			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL, $url); 
			curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.73 Safari/537.36"); 
			curl_setopt($ch,CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $final_post); 
			curl_setopt($ch, CURLOPT_TIMEOUT, 100); 
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 100);
			//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			//curl_setopt($ch, CURLOPT_CAINFO,  getcwd()."/curl-ca-bundle.crt"); //  ok
			$response = curl_exec($ch); 
			$errmsg = curl_error($ch); 
			$cInfo = curl_getinfo($ch); 
			curl_close($ch); 
			
			echo $response;
		}
    }
}
