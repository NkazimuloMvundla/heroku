<?php

namespace App\Http\Middleware;



use Closure;

class BlockGetRequest
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
        if (request()->method() == "GET" && request()->getRequestUri() == '/subcats') {
            return redirect('/');
        } else if (request()->method() == "GET" && request()->getRequestUri() == '/lastcats') {
            return redirect('/');
        } else if (request()->method() == "GET" && request()->getRequestUri() == '/reviews') {
            return redirect('/');
        } else if (request()->method() == "GET" && request()->getRequestUri() == '/singleSellingRequest') {
            return redirect('/');
        } else if (request()->method() == "GET" && request()->getRequestUri() == '/singleBuyingRequest') {
            return redirect('/');
        } else if (request()->method() == "GET" && request()->getRequestUri() == '/autocomplete/fetch') {
            return redirect('/');
        } else if (request()->method() == "GET" && request()->getRequestUri() == '/subscriber') {
            return redirect('/');
        } else if (request()->method() == "GET" && request()->getRequestUri() == '/u/profile/delete-certificate') {
            return redirect('/');
        } else if (request()->method() == "GET" && request()->getRequestUri() == '/u/updateStatus') {
            return redirect('/');
        } else if (request()->method() == "GET" && request()->getRequestUri() == '/u/destroyEmails') {
            return redirect('/');
        } else if (request()->method() == "GET" && request()->getRequestUri() == '/u/remove-favorite') {
            return redirect('/');
        } else if (request()->method() == "GET" && request()->getRequestUri() == '/u/delete-product-image') {
            return redirect('/');
        } else if (request()->method() == "GET" && request()->getRequestUri() == '/u/product/deleteSpecs') {
            return redirect('/');
        } else if (request()->method() == "GET" && request()->getRequestUri() == '/u/product/showSpec') {
            return redirect('/');
        } else if (request()->method() == "GET" && request()->getRequestUri() == '/u/product/addSpec') {
            return redirect('/');
        } else if (request()->method() == "GET" && request()->getRequestUri() == '/u/showSpecList') {
            return redirect('/');
        } else if (request()->method() == "GET" && request()->getRequestUri() == '/u/product/addSpec') {
            return redirect('/');
        } else if (request()->method() == "GET" && request()->getRequestUri() == '/u/product/showSpec') {
            return redirect('/');
        } else if (request()->method() == "GET" && request()->getRequestUri() == '/u/product/addSpec') {
            return redirect('/');
        } else if (request()->method() == "GET" && request()->getRequestUri() == '/filter-by-price') {
            return redirect('/');
        }


        return $next($request);
    }
}
