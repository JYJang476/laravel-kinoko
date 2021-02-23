<?php

namespace App\Http\Controllers;

use App\TokenModel;
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
        $userid = TokenModel::where('token', '=', $request->token)->first()->user_no;

        $result = UserModel::select('Users.id', 'Users.user_machineid', 'Machines.machine_name')
                            ->join('Machines', 'Users.user_machineid', 'Machines.id')
                            ->where('Users.id', '=', $userid)->first();
        if($result == null)
            return response('일치하는 결과 없음', 404);

        return response([
            'id' => $result->user_machineid,
            'name' => $result->machine_name
        ], 200);
    }

    function SelectMachine(Request $request) {
        $validator = Validator::make($request->all(),[
            "id" => "required", // 기기 아이디
            "token" => "required" // 토큰
        ]);

        if($validator->fails())
            return response($validator->errors(), 400);

        $result = UserModel::select('Users.id', 'token.user_no', 'token.token')->join('token', 'Users.id', 'token.user_no')
            ->where('token', '=', $request->token)
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

        $user = UserModel::select('id', 'user_id')->where('user_id', $request->id)->first();

        if($user->count() == 0)
            return response("계정 정보를 확인해주세요", 401);
        else {
            $result = TokenModel::where('user_no', '=', $user->id)->first();

            if($result != null)
                return response('이미 로그인 되어있습니다.', 403);

            TokenModel::insert([
                'user_no' => $user->id,
                'token' => $request->token
            ]);
            return response('로그인 성공', 201);
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

        $user = UserModel::select('Users.id', 'token.user_no', 'token.token')->join('token', 'Users.id', 'token.user_no')
            ->where('token', '=', $request->token)->first();

        if ($user == null)
            return response('이미 로그아웃 되었거나 잘못된 토큰', 403);

        $result = TokenModel::where('token', '=', $request->token)->delete();

        if(!$result)
            return response('토큰 삭제 실패', 403);

        $user->update([
            'user_lastlogout' => \Carbon\Carbon::now()
        ]);

        return response('로그아웃 성공', 200);
    }

    function GetMainMachineId(Request $request) {
        $validator = Validator::make($request->all(),[
            "token" => "required"
        ]);

        $user = UserModel::select('Users.id', 'token.user_no', 'token.token')->join('token', 'Users.id', 'token.user_no')
            ->where('token', '=', $request->token)->first();

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
            "id" => "required",
            "token" => "required"
        ]);

        if($validator->fails())
            return response($validator->errors(), 400);

        $user = UserModel::select('Users.id', 'Users.user_lastlogout', 'token.token')->join('token', 'Users.id', 'token.user_no')
            ->where('token', '=', $request->token)->first();

        if($user == null)
            return response('일치하는 계정이 없습니다.', 404);
        else if($user->user_lastlogout == null)
            return response('로그인 한 적이 없는 계정입니다.', 404);
        return response($user->user_lastlogout, 200);
    }
}
