<?php

namespace App;

use App\Chat;
use Illuminate\Database\Eloquent\Model;

class ChatSession extends Model
{
    protected $table = 'chat_sessions';

    protected $fillable = [
    	'session_id',
    	'visitor_identifier',
    	'name',
    	'email',
    	'agent'
    ];

    public function messages(){
    	return $this->hasMany(Chat::class, 'session','session_id')->orderBy('created_at', 'DESC');
    }

    public function agent(){
        return $this->belongsTo(User::class, 'agent','id');
    }
}
