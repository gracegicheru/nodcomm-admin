<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class ImpersonateController extends Controller
{
		public function impersonateIn($id)
	{
		session(['impersonated' => $id, 'backUrl' => \URL::previous()]);

		return redirect()->to('dashboard');
	}

	public function impersonateOut()
	{

		$back_url = Session::get('backUrl');

		//Request::session()->forget('impersonated', 'secretUrl');
		Session::forget('impersonated', 'secretUrl');

		return $back_url ? 
			redirect()->to($back_url) : 
			redirect()->to('dashboard');
	}
}
