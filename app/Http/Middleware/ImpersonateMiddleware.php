<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Auth;

class ImpersonateMiddleware
{
    public function handle($request, Closure $next)
    {
        if(Session::has('impersonated')){
            Auth::onceUsingId(Session::get('impersonated'));
         }
	return $next($request);
     }
}
