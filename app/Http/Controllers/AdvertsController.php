<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Adverts;
class AdvertsController extends Controller
{
     public function __construct()
    {
    $this->middleware('auth');
    }
    public function index()
    {
		$advert = Adverts::first();
        return view('addadvert')->with('advert', $advert);
    }
		public function addadvert(Request $request){

        try{

			if(!empty($request->id)){
				 try{
					 $advert= Adverts::find($request->id);
				     return response(['status'=>'success', 'details'=>$advert]);
				    }catch(Exception $e){
					 return response(['status'=>'error']);
					}

			}
			if($request->name==''){
				return response(['status'=>'error', 'details'=>"Please enter the advert name"]);
			}
			else if($request->message==''){
				return response(['status'=>'error', 'details'=>"Please enter the advert message"]);
			}
			else{

			$advert = new Adverts;
            $advert->name = $request->input('name');
            $advert->message = $request->input('message');
			$advert->status = 1;

			
			$advert->save();
		
            return response(['status'=>'success', 'details'=>$advert]);
			}
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
			    public function editadvert(Request $request){

        try{
			if($request->name==''){
				return response(['status'=>'error', 'details'=>"Please enter the advert name"]);
			}
			else if($request->message==''){
				return response(['status'=>'error', 'details'=>"Please enter the advert message"]);
			}
			else{
            $advert = Adverts::find($request->input('id'));
            $advert->name = $request->input('name');
            $advert->message = $request->input('message');
			$advert->save();


            return response(['status'=>'success', 'details'=>$advert]);
			}
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
		    public function disableadvert(Request $request){

        try{

            $advert = Adverts::find($request->input('id'));
            $advert->status =0;

            $advert->save();
		
            $adverts=  Adverts::all();
            
            return response(['status'=>'success', 'details'=>$adverts]);
			
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
		public function enableadvert(Request $request){

        try{

            $advert = Adverts::find($request->input('id'));
            $advert->status =1;

            $advert->save();
		
            $adverts=  Adverts::all();
            
            return response(['status'=>'success', 'details'=>$adverts]);
			
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
}
