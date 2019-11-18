<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
	 protected $table = 'pdf_test';
	 public $timestamps = false;
    protected $fillable = ['full_name','street_address','zip_code','city'];
}