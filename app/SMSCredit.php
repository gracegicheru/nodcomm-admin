<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SMSCredit extends Model
{
    protected $table = 'sms_credit';
	
    protected $fillable = [
        'credit', 
		'user_id',
		'company_id'
    ];
    protected $hidden = [

    ];
}
