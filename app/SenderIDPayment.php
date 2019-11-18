<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SenderIDPayment extends Model
{
    protected $table = 'sender_id_payment';
	
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
		'user_id',
		'authoriation_document',
		'sender_id',
		'company_id'
    ];
    protected $hidden = [

    ];
}
