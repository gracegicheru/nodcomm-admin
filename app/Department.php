<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
                /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'departments';
    protected $fillable = [
        'department_name', 'description','company_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
       
    ];
        public function users()
    {
        return $this->belongsToMany('App\User','department_agents','department_id','agent_id');
    }
}
