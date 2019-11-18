<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TestMessage;
use Illuminate\Pagination\LengthAwarePaginator;

class ReportController extends Controller
{
    //

    public function getReports(){

    	$message_reports= TestMessage::paginate(20);


    	return view('report', ['message_reports' => $message_reports]);
    	// return $message_reports;

    }

public function table(){
        return view('table');
}

}
