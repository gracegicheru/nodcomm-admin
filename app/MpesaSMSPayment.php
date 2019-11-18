<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MpesaSMSPayment extends Model
{
    protected $table = 'mpesasmspayment';
	
    protected $fillable = [
        'amount', 
		'credit',
		'phone_number',
		'currency', 
		'reference',
		'time', 
		'deviceinfo',
		'user_ip', 
		'user_id',
		'company_id'
    ];
    protected $hidden = [

    ];
}
