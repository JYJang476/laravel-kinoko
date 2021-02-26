<?php

namespace App\Http\Middleware;

use Closure;

class CrossDomain
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
        header("Access-Control-Allow-Headers: x-xsrf-token, Set-Cookie");
        header("Access-Control-Allow-Origin: http://54.92.175.125");
        header("Access-Control-Allow-Methods: GET, HEAD, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Credentials: true");

        return $next($request);
    }
}
