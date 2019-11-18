<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class Login
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   if(Auth::user() &&  Auth::user()->company_id!=0){
        //return redirect()->to('https://dashboard.nodcomm.com/dashboard');
      // return redirect()->to('');
        }
        return $next($request);
    }
}
