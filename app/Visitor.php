<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Chat;
use App\User;

class Visitor extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'visitors';
    protected $fillable = [
        'ip', 'device_info', 'visits', 'chats', 'identifier'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
       
    ];

    public function visitor_chats(){
        return $this->hasMany(Chat::class, 'session','current_session');
    }

    public function agent(){
        return $this->hasMany(User::class, 'id','assigned_agent');
    }
}
