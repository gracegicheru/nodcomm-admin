<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use Auth;
use App\Notification;
use App\Setting;
class TrialDaysController extends Controller
{
     private $notification ;
			
	 public function __construct()
	    {
			$this->middleware('auth');
			$this->notification = new Notification();
	    }
	 public function extend_trial_days(Request $request){

			$company = Company::find(Auth::user()->company_id);	
			$extendeddays = Setting::where('config_key','extended_trial_days')->first()->config_value;
		    $created_at = strtotime($company->created_at);
			$date = strtotime("+".$extendeddays." day", $created_at);
			
			if($this->notification->sendMailMandrill( $company->email, $this->emailtemplate($company->fname." ".$company->lname,date('Y-m-d H:i:s', $date),$extendeddays),'Extension of Trial Period Email','Nodcomm Extension of Trial Period ')){
			$company->extende_trial_date =date('Y-m-d H:i:s', $date);
			$company->save();
			return response(['status'=>'success','details'=>url('/dashboard')]);
			}else{
			return response(['status'=>'error', 'details'=>'An error occurred, please try again.']);
			}
	 }
	     public function emailtemplate($username, $date, $extendeddays) {
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
                                    <h3 style="color: #037caa">Extension of Trial Period</h3> 
                                    <h4>Dear '.$username.',</h4>
                                    <p>
										Your free trial of Nodcomm has been extended by '.$extendeddays.' days. The trial period will end on '.$date.'.
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
