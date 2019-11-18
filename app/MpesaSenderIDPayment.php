<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MpesaSenderIDPayment extends Model
{
    protected $table = 'mpesasenderidpayment';
	
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
