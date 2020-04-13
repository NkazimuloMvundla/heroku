<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Session;

class AccessSuperUser
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
        if (!Auth::check()) {
            return redirect('/login');
        } else if (Auth::user()->role != 'God') {
            return redirect('/');
        }

        return $next($request);
    }
}
