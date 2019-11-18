<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostChatSetting extends Model
{
                /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'post_chat_settings';
    protected $fillable = [
       'greeting_msg','company_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
       
    ];
}
