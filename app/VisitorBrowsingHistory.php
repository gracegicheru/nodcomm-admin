<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VisitorBrowsingHistory extends Model
{
    protected $table = 'visitor_browsing_histories';
    protected $fillable = [
    	'visitor_identifier',
    	'page_title',
    	'page_url',
    	'start_time',
    	'end_time'
    ];
}
