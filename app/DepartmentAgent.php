<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepartmentAgent extends Model
{
      protected $table ='department_agents';  
        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'department_id', 'agent_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
       
    ];
}
