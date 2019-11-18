<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //'password', 'remember_token',
    ];

    public function is_admin(){
        if($this->admin){
            return true;
        }
         return false;
    }
        public function departments()
    {
        return $this->belongsToMany('App\Department','department_agents','agent_id','department_id');
    }
        public function visitors()
    {
        return $this->hasMany('App\Visitor', 'assigned_agent','id');
    }

    public function Ticket()
    {
        return $this->hasMany('App\SupportTicket');
    }


}
