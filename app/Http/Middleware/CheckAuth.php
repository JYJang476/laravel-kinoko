<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Controllers\UserController;
use http\Env\Request;
use Illuminate\Http\Response;

class CheckAuth
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
        $userController = new UserController();

        return response($request->cookie(), 200);
//        $bool = $userController->CheckLogin($request)->content() == '인증 실패';
//
//        if($bool)
//            return response('인증 실패', 401);
//
        return $next($request);
    }
}
