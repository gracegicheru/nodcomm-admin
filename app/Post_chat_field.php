<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post_chat_field extends Model
{
                    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'post_chat_fields';
    protected $fillable = [
        'name', 'visible','required','company_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
       
    ];
}
