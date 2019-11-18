<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaypalSMSPayment extends Model
{
    protected $table = 'paypalsmspayment';
	
    protected $fillable = [
        'amount', 
		'credit',
		'currency', 
		'reference',
		'order_time', 
		'payment_status',
		'user_id',
		'company_id'
    ];
    protected $hidden = [

    ];
}
