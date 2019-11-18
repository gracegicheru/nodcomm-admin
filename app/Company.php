<?php

namespace App;
use App\Message;
use App\User;
use App\Site;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
            /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'companies';
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
     //'password',
    ];
    public function messages()
    {
        return $this->hasMany(Message::class,'initiator','id');
    }
        public function users()
    {
        return $this->hasMany(User::class,'company_id','id');
    }
    public function sites()
    {
        return $this->hasMany(Site::class,'company_id','id');
    }
}
