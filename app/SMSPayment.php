<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SMSPayment extends Model
{
    protected $table = 'smspayment';
	
    protected $fillable = [
        'amount', 
		'charge',
		'currency', 
		'reference',
		'time', 
		'identifier',
		'expiry', 
		'type',
		'card_id',
		'card',
        'credit', 
		'user_id',
		'company_id'
    ];
    protected $hidden = [

    ];
}
