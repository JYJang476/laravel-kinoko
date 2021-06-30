<?php

namespace App\Http\Middleware;

use App\TokenModel;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Cookie;

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
        $db_token = TokenModel::where('token', '=', $request->token)->first();

        if($db_token == null)
            return response("유효하지 않은 토큰입니다.", 403);

        $db_Date = Carbon::createFromTimeString($db_token->date)->addHour(3);
        $now_Date = Carbon::now()->format('Y-m-d H:i:s');

        if($db_Date < $now_Date)
            return response("이미 만료된 토큰");

        return $next($request);
    }
}
