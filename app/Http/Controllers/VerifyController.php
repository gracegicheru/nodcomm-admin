<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sample;

class verifyController extends Controller
{
    //

    public function verify(){
    	return view('auth.verification');
    }

    public function loginUser(){
    	return view('auth.login12');
    }
    public function Register1(){
    	return view('register1');
    }
    public function Register2(){
        return view('register2');
    }
    public function sample(){
        return view('sample');
    }

    public function register3(){
        return view('register3');
    }
    public function master(){
        return view('layouts.new_master1');
    }
}
