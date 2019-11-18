<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestMessage extends Model
{
	protected $table = 'test_messages';
            /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phone', 'message','company_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
     
    ];
}
