<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Support_Message extends Model
{
	public  $table="support_messages";
                    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'support_id','description	s'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
       
    ];
}
