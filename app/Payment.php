<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
             /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'payments';
    protected $fillable = [
        'txn_id', 'payment_gross','currency_code','payment_status','payment_method','payment_date','customer_email','payer_id','cart',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
     
    ];
}
