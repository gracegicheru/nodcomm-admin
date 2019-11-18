<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Push_sites extends Model
{
       /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'push_sites';
    protected $fillable = [
        'name', 'url','company_id','code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
       
    ];

    public function company(){
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
}
