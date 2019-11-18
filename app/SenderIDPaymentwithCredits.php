<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SenderIDPaymentwithCredits extends Model
{
    protected $table = 'paysenderidwithcredits';
	
    protected $fillable = [ 
		'credit',
		'time', 
		'user_id',
		'sender_id',
		'company_id'
    ];
    protected $hidden = [

    ];
}
