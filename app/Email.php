<?php

namespace App;

use App\EmailGateway;
use App\Company;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $table = 'emails';

    public function emailgateway(){
    	return $this->belongsTo(EmailGateway::class, 'email_gateway', 'id');
    }

    public function site(){
    	return $this->belongsTo(Company::class, 'initiator', 'id');
    }
}
