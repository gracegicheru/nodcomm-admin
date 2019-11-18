<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use Auth;
use App\Notification;
use App\Setting;
use Illuminate\Support\Facades\DB;
class EmailCronController extends Controller
{
     private $notification ;
			
	 public function __construct()
	    {
			$this->notification = new Notification();
	    }
	    public function send_reminder_email(){

			$reminder_days = Setting::where('config_key','reminder_days')->first()->config_value;
			$trialdays = Setting::where('config_key','company_trial-days')->first()->config_value;
			$companies=DB::table('companies')
							->select('*')
						   ->whereRaw($trialdays.'-DATEDIFF(NOW(),created_at)='.$reminder_days)
						   ->get();
			$date = strtotime("+".$reminder_days." day", time());
			foreach ($companies as $company) {
				
			$this->notification->sendMailMandrill($company->email, $this->emailtemplate($company->fname." ".$company->lname, date('d-m-Y', $date)),'Expiry of Trial Period Email','Your Nodcomm Free Trial Expires on '.date('d-m-Y', $date));
			}
		}
		public function send_reminder_email_for_extended_trial_days(){

			$reminder_days = Setting::where('config_key','reminder_days')->first()->config_value;
			$companies=DB::table('companies')
							->select('*')
						   ->whereRaw('DATEDIFF(extende_trial_date,NOW())='.$reminder_days)
						   ->get();

			$date = strtotime("+".$reminder_days." day", time());
			foreach ($companies as $company) {
				
			$this->notification->sendMailMandrill($company->email, $this->emailtemplate($company->fname." ".$company->lname, date('d-m-Y', $date)),'Expiry of Trial Period Email','Your Nodcomm Free Trial Expires on '.date('d-m-Y', $date));
			}
		}
		
	    public function emailtemplate($username,$date) {
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
                                    <h3 style="color: #037caa">Expiry of Trial Period</h3> 
                                    <h4>Dear '.$username.',</h4>
                                    <p>
										This is to remind you that your free trial of Nodcomm  expires on '.$date.'.
                                    </p>
									<p>
										To continue to use Nodcomm , please login to complete your purchase as soon as possible.
									</p>
									<p>
										Should you have any questions or need any help, please feel free to let us know.
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
