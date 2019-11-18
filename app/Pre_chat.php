<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pre_chat extends Model
{
            /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'pre_chats';
    protected $fillable = [
        'team_name', 'agents_avatar','online_greeting_msg','offline_greeting_msg','company_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
       
    ];
}
