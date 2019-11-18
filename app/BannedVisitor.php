<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BannedVisitor extends Model
{
    protected $table = 'banned_visitors';

    protected $fillable = [
    	'visitor_identifier',
    	'visitor_ip',
    	'visitor_email'
    ];
}
