<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\UserModel;

class UserController extends Controller
{
    function RegisterUser(Request $request) {
        $reqObj = json_decode($request->getContent());

        if($this->CheckRegister($reqObj->id))
            return response('이미 가입된 계정입니다.', 401);

        $result = UserModel::insert([
            'user_id' => $reqObj->id,
            'user_email' => $reqObj->email,
        ]);

        if ($result)
            return response('가입 성공', 200);
        else
            return response('가입 실패', 400);
    }

    function CheckRegister($id) {
        $result = UserModel::where('user_id', $id);

        if($result->count() > 0)
            return true;

         return false;
    }

    function LoginUser(Request $request) {
        $reqObj = json_decode($request->getContent());

        $user = UserModel::select('user_id', 'token')->where('user_id', $reqObj->id);

        if($user->first()->token != null)
            return response('이미 로그인 되어있습니다.', 401);

        if($user->count() == 0)
            return response("계정 정보를 확인해주세요", 400);
        else {
            $user->update(['token' => $reqObj->token]);
            return response('로그인 성공', 200);
        }
    }

    function CheckLogin(Request $request) {
        $reqObj = json_decode($request->getContent());

        $user = UserModel::where('token', $reqObj->token);

        if($user->count() > 0)
            return response('인증 성공', 200);
        else if($user->count() == 0)
            return response('인증 실패', 401);
    }

    function LogoutUser(Request $request) {
        $reqObj = json_decode($request->getContent());

        $user = UserModel::where('token', $reqObj->token);

        if ($user->count() == 0)
            return response('이미 로그아웃 되었거나 잘못된 토큰', 400);
        else {
            $user->update([
                'token' => null,
                'user_lastlogout' => \Carbon\Carbon::now()
            ]);
            return response('로그아웃 성공', 200);
        }
    }

     function GetLogoutDate($id) {
         $result = UserModel::where('user_id', $id);

         if($result->count() == 0)
             return response('일치하는 계정이 없습니다.', 400);
         else if($result->first()->user_lastlogout == null)
             return response('로그인 한 적이 없는 계정입니다.', 401);
         return response($result->first()->user_lastlogout, 200);
     }
}
