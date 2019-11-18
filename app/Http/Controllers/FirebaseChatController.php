<?php

namespace App\Http\Controllers;
use App;
use Lang;
use Illuminate\Http\Request;
class FirebaseChatController extends Controller
{

     public function __construct()
    {

    $this->middleware('auth');
	
    }
	 public function index()
    {
		$array = Lang::get('menu');
		//return response(['status'=>'success','details'=>$array]);
		//print_r(json_encode($array));
		return view('firebase.example')->with('array',json_encode($array));
	}
	 public function index1()
    {
		$array = Lang::get('menu');
		return response(['status'=>'success','details'=>$array]);
		//print_r(json_encode($array));
		//return view('firebase.example')->with('array',json_encode($array));
	}
	
}
