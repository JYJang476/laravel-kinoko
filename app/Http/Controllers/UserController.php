<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\UserModel;
use Validator;

class UserController extends Controller
{
    function RegisterUser(Request $request) {
        $validator = Validator::make($request->all(),[
            "id" => "required",
            "email" => "required"
        ]);

        if($validator->fails())
            return response($validator->errors(), 400);

        if($this->CheckRegister($request->id))
            return response('이미 가입된 계정입니다.', 401);

        $result = UserModel::insert([
            'user_id' => $request->id,
            'user_email' => $request->email,
        ]);

        if ($result)
            return response('가입 성공', 201);
        else
            return response('가입 실패', 403);
    }

    // 기기 받아오는 함수
    // param: 토큰
    function GetMachineId(Request $request) {
        $validator = Validator::make($request->all(),[
            "token" => "required"
        ]);

        if($validator->fails())
            return response($validator->errors(), 400);

        $result = UserModel::select('user_machineid')->where('token', '=', $request->token)->first();

        if(!$result)
            return response('일치하는 결과 없음', 404);

        return response($result->user_machineid, 200);
    }

    function SelectMachine(Request $request) {
        $validator = Validator::make($request->all(),[
            "id" => "required",
            "token" => "required"
        ]);

        if($validator->fails())
            return response($validator->errors(), 400);

        $result = UserModel::where('token', '=', $request->token)
            ->update([
                'user_machineid' => $request->id
            ]);

        if(!$result)
            return response('기기 선택 실패', 403);

        return response('기기 선택 성공', 200);
    }
    
    function CheckRegister($id) {
        $result = UserModel::where('user_id', $id);

        if($result->count() > 0)
            return true;

        return false;
    }

    function LoginUser(Request $request) {
        $validator = Validator::make($request->all(),[
            "id" => "required",
            "token" => "required"
        ]);

        if($validator->fails())
            return response($validator->errors(), 400);

        $user = UserModel::select('user_id', 'token')->where('user_id', $request->id);

        if($user->first()->token != null)
            return response('이미 로그인 되어있습니다.', 401);

        if($user->count() == 0)
            return response("계정 정보를 확인해주세요", 401);
        else {
            $user->update(['token' => $request->token]);
            return response('로그인 성공', 200);
        }
    }

    function CheckLogin(Request $request) {
        $validator = Validator::make($request->all(),[
            "token" => "required"
        ]);

        if($validator->fails())
            return response($validator->errors(), 400);

        $user = UserModel::where('token', $request->token);

        if($user->count() > 0)
            return response('인증 성공', 200);
        else if($user->count() == 0)
            return response('인증 실패', 401);
    }

    function LogoutUser(Request $request) {
        $validator = Validator::make($request->all(),[
            "token" => "required"
        ]);

        if($validator->fails())
            return response($validator->errors(), 400);

        $user = UserModel::where('token', $request->token);

        if ($user->count() == 0)
            return response('이미 로그아웃 되었거나 잘못된 토큰', 403);

        $user->update([
            'token' => null,
            'user_lastlogout' => \Carbon\Carbon::now()
        ]);

        return response('로그아웃 성공', 200);
    }

    function GetMainMachineId(Request $request) {
        $validator = Validator::make($request->all(),[
            "token" => "required"
        ]);

        $user = UserModel::where('token', '=', $request->token)->first();

        return $user->user_machineid;
    }

    function CreateToken($params) {
        $result = UserModel::insert($params);

        if(!$result)
            return false;

        return true;
    }

    function GetLogoutDate(Request $request) {
        $validator = Validator::make($request->all(),[
            "id" => "required"
        ]);

        if($validator->fails())
            return response($validator->errors(), 400);

        $result = UserModel::where('user_id', $request->id);

        if($result->count() == 0)
            return response('일치하는 계정이 없습니다.', 404);
        else if($result->first()->user_lastlogout == null)
            return response('로그인 한 적이 없는 계정입니다.', 404);
        return response($result->first()->user_lastlogout, 200);
    }
}
