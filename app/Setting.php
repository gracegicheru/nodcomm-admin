<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'settings';
    protected $fillable = [
        'config_key', 'config_value'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
       
    ];
}
