<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
                /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'supports';
    protected $fillable = [
        'support_description','company_id','user_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
       
    ];

}
