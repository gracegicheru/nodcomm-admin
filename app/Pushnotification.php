<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Minishlink\WebPush\WebPush;

class Pushnotification extends Model
{
                    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	 protected $table = 'pushnotifications';
	
    protected $fillable = [
        'endpoint', 'expiration_time','p256dh','auth','company_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
       
    ];
	
			public function send_notification($query,$message){
				$endpoints = [];

				if(!empty($query)){
					foreach ($query as $row) {
						$endpoints[] = [
								'endpoint' => $row->endpoint,
								'p256dh' => $row->p256dh,
								'auth' => $row->auth
						];
					}


					$auth = array(
						//'GCM' => 'MY_GCM_API_KEY', // deprecated and optional, it's here only for compatibility reasons
						'VAPID' => array(
						  //  'subject' => 'mailto:admin@writenod.com',
							'subject' => 'mailto:brendah.k@mambo.co.ke',
							'publicKey' => 'BH5yhWUwomgwwXJdpS5xuzHLLDMcHyJT3rpNErsxA-xrZ6LTnUANvaxj6MrP94E_V-ov-LggGr4kWhxv14IaLIA',
							'privateKey' => 'K-vS_yDpSC0iBYs1yDo65mL0MMZEb6d9Ss3BL_ilAnY'
						),
					);

					$webPush = new WebPush($auth);

					foreach ($endpoints as $endpoint) {


						$webPush->sendNotification(
							$endpoint["endpoint"],
							json_encode($message),
							$endpoint["p256dh"], // optional (defaults null)
							$endpoint["auth"]
						);

						$webPush->flush();
					}
				}
		}
}
