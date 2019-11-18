<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailGateway extends Model
{
    protected $table = 'email_gateways';
	
    protected $fillable = [
        'name', 'alphanumeric','identifier',
    ];
    protected $hidden = [
    	'key',
    	'secret'
    ];
}
