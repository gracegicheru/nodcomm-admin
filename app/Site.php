<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Visitor;
class Site extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'sites';
    protected $fillable = [
        'name', 'url','company_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
       
    ];
        public function visitors()
    {
        return $this->hasMany(Visitor::class,'site','id');
    }
    public function company(){
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
}
