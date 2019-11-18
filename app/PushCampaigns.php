<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PushCampaigns extends Model
{
                /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'push_campaigns';
    protected $fillable = [
        'web_push_title', 'web_push_text','web_push_link','site_id','company_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
       
    ];
}
