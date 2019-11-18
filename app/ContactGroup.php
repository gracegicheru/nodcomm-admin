<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactGroup extends Model
{
    protected $table = 'contact_group';
	
    protected $fillable = [ 
		'name',
		'phones', 
		'user_id',
		'company_id'
    ];
    protected $hidden = [

    ];
}
