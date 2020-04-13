<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class SuperUserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Session::get('super') == null) {
            return  redirect()->route('super_user_login');
        }
        return $next($request);
    }
}
