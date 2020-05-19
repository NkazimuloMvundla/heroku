<?php

namespace App\Http\Middleware;

use Closure;

class StripAuthenticateHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */


    // Enumerate headers which you do not want in your application's responses.
    // Great starting point would be to go check out @Scott_Helme's:
    // https://securityheaders.com/
    private $unwantedHeaderList = [
        'X-Powered-By',
        'Server',
    ];
    public function handle($request, Closure $next)
    {
        $this->removeUnwantedHeaders($this->unwantedHeaderList);
        $response = $next($request);
        $response->headers->set('cache-control', 'private', 'max-age=31536000', 'no-cache');
        $response->headers->set('Referrer-Policy', 'no-referrer-when-downgrade');
        /*$response->headers->set('X-Content-Type-Options', 'nosniff');*/
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
      /*  $response->headers->set(' Content-Security-Policy', "default-src;self");*/
        /* $response->headers->set('Content-Security-Policy', "style-src 'self'"); // Clearly, you will be more elaborate here.*/
        return $response;
    }
    private function removeUnwantedHeaders($headerList)
    {
        foreach ($headerList as $header)
            header_remove($header);
    }
}
