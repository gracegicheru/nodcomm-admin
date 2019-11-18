<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use Auth;
class ApiController extends Controller
{
	   public function index()
    {
		if (Auth::user()->admin && Auth::user()->company_id==0){
	    $data = array(
		'apis'=>Company::all()
		);	
		}else{
       $data = array(
		'api'=>Company::find(Auth::user()->company_id),
		'disabled'=>1
		
		);
		}
        return view('settings.api')->with($data);
	}

}
