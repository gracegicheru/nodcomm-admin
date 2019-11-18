<?php

namespace App\Http\Controllers;

use App\SupportTicket;
use Illuminate\Http\Request;
use App\Sale;
use Auth;
use App\User;


class HelpController extends Controller
{
    //
    public function ApiSupport(){

    return view('Support.Api');
}

public function SalesSupport(){
        return view('Support.sales');
}
public function TechnicalSupport(){



            $ticket = SupportTicket::where('user_id', 71)
                ->orderBy('created_at', 'desc')
                ->get();
//            dd($ticket);
            return view('Support.technical')->with('tickets',$ticket);
}



public function supportTechnical(Request $request){


    $support= new SupportTicket;
        $support->title= $request->input('title');
        $support->department= $request->input('department');
//    dd($support);
        $support->priority= $request->input('priority');
        $support->message= $request->input('message');
        $support->user_id= Auth::user()->id;

        $support->save();


        return response()->json([
            'status'=>'ok',

        ]);


}

}
