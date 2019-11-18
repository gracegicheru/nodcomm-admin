<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SenderID extends Model
{
    protected $table = 'sender_id';
	
    protected $fillable = [ 
		'credit',
		'time', 
		'user_id',
		'authoriation_document',
		'company_id'
    ];
    protected $hidden = [

    ];
}
