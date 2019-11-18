<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adverts extends Model
{
           /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'adverts';
    protected $fillable = [
        'name', 'message',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
     
    ];
}
