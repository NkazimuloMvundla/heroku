<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Auth;

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
         if (request()->search == null ) {
            return redirect('/');

        }
        return $next($request);
    }
}
