<?php

namespace App\Http\Middleware;
use Session;
use Closure;
use Auth;
use App;
class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
	public function handle($request, Closure $next) {
		$locale = 'en';

		if (Session::has('applocale')) {
			$locale = Session::get('applocale');
		}

		App::setlocale($locale);
		return $next($request);
	}
}
