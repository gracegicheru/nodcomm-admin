<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Site;
use App\Exceptions\Handler;

class LiveChatController extends Controller
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

    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return "console.log('here');";
    }

    public function addsite(AddSiteRequest $request){

        try{
            $site = new Site;
            $site->name = $request->input('name');
            $site->url = $request->input('url');

            $site->save();

            return response(['status'=>'success']);
        }catch(Exception $e){
            return response(['status'=>'error']);
        }
        
    }
}
