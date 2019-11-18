<?php

namespace App;

use App\SMSGateway;
use App\Company;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';

    public function smsgateway(){
    	return $this->belongsTo(SMSGateway::class, 'sms_gateway', 'id');
    }

    public function site(){
    	return $this->belongsTo(Company::class, 'initiator', 'id');
    }
}
