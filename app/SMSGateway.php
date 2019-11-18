<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SMSGateway extends Model
{
    protected $table = 'sms_gateways';

    protected $hidden = [
    	'key',
    	'secret'
    ];
}
