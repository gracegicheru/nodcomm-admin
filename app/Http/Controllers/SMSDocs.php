<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SMSDocs extends Controller
{
	public function __construct(){
        $this->middleware('auth');
    }

    public function introduction(){
    	return view('docs/sms_docs_intro');
    }

    public function send_sms(){
    	return view('docs/sms_docs_send_sms');
    }
}
