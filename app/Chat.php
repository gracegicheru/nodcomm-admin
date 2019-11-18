<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Visitor;

class Chat extends Model
{
    protected $table = 'chats';
    protected $fillable= [
        'visitor_identifier',
        'session',
        'message',
        'from',
        'to',
        'read'
    ];

    public function visitor(){
        return $this->belongsTo(Visitor::class, 'session', 'current_session');
    }
}
