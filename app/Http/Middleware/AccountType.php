<?php

namespace App\Http\Middleware;

use Closure;
use Session;
class AccountType
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
         if(empty(Session::get('account_type'))){
            return redirect('/account-type');
         }
        return $next($request);
    }
}
