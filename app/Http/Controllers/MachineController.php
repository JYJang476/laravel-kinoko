<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\SettingModel;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\MachineModel;
use App\ProgramModel;
use App\Http\Controllers\ProgramController;
use Illuminate\Database\Eloquent;
use App\PinModel;
use App\UserModel;
use Validator;

class MachineController extends Controller
{
    // 목적: 새로운 기기를 추가한다.
    // 파라미터 : 1. pin - 등록된 핀번호
    //          2. pw  - 핀번호의 패스워드
    function AddMachine(Request $request) {
        // 파라미터의 유효성 검사
        $validator = Validator::make($request->all(),[
            "pin" => "required",
            "pw" => "required",
        ]);

        if($validator->fails())
            return response($validator->errors(), 400);

        // 새로운 기기를 추가한다.
        $result = MachineModel::insert([
            'machine_userid' => 1,
            'machine_prgid' => 0,
            'machine_pin' => $request->pin,
            'machine_name' => ""
        ]);
        // 추가 실패 시 에러 반환
        if(!$result)
            return response("기기 추가 실패", 403);
        // 추가한 요소의 ID값을 가져온다.
        $insertMachineId = MachineModel::all()->last()->id;
        // 핀 테이블에 새로운 핀 추가
        $result = PinModel::insert([
            'pin_value' => $request->pin,
            'pin_machineid' => $insertMachineId,
            'pin_pw' => $request->pw
        ]);
        // 실패시 에러 반환
        if(!$result)
            return response("핀 번호 추가 실패", 403);
        // 성공 반환
        return response("성공", 201);
    }

    public function IsExist(Request $request) {
        $result = MachineModel::where('machine_pin', '=', $request->pin)->first();

        if($result->machine_prgid == null)
            return response('false', 201);

        return response($result->machine_prgid, 200);
    }

    // 기기의 사용 프로그램 설정
    function SetProgram(Request $request) {
        $validator = Validator::make($request->all(),[
            "id" => "required",
            "prgId" => "required",
        ]);

        if($validator->fails())
            return response($validator->errors(), 400);

        $prgObj = ProgramModel::where([
            'prg_machineid' => $request->id,
        ])->first();

        $machineObj = MachineModel::where('id', '=', $request->id)->first();

        if(!$machineObj)
            return response('기기 받아오기 실패', 404);

        $beforeId = $machineObj->machine_prgid;

        if(!$machineObj->update([
            'machine_prgid' => $request->prgId
        ]))
            return response('기기 변경 실패', 403);

        $setting = SettingModel::where([
            'setting_prgid' => $request->prgId,
            'setting_type' => 'temperature'
        ])->get();
        $tempsetting = SettingModel::where([
            'setting_prgid' => $request->prgId,
            'setting_type' => 'humidity'
        ])->get();
        $i = 0;

        foreach($setting as $data){
            SettingModel::where('id', '=', $data->id)->update([
               'setting_date' => Carbon::now()->addDay($i++)
            ]);
        }
        $i = 0;
        foreach($tempsetting as $data){
            SettingModel::where('id', '=', $data->id)->update([
                'setting_date' => Carbon::now()->addDay($i++)
            ]);
        }

        return response('성공', 201);
    }

    // 가동 상태 설정
    function SetIsOn(Request $request) {
        $validator = Validator::make($request->all(),[
            "id" => "required",
            "status" => "required"
        ]);

        if($validator->fails())
            return response($validator->errors(), 400);

        $result = MachineModel::where('id', '=', $request->id)
            ->update([
                'machine_ison' => $request->status
            ]);

        if(!$result)
            return response('실패', 403);

        return response('성공', 200);
    }

    // 배지 유무 설정
    function SetIsPresence(Request $request) {
        $validator = Validator::make($request->all(),[
            "id" => "required",
            "status" => "required"
        ]);

        if($validator->fails())
            return response($validator->errors(), 400);

        $result = MachineModel::where('id', '=', $request->id)
            ->update([
                'machine_ispresence' => $request->status
            ]);

        if(!$result)
            return response('실패', 403);

        return response('성공', 200);
    }

    // 가동 상태 설정
    function GetIsOn(Request $request) {
        $validator = Validator::make($request->all(),[
            "id" => "required"
        ]);

        if($validator->fails())
            return response($validator->errors(), 400);

        // 해당 유저 아이디로 기기와 조인해서 정보를 얻어온다.
        $result = MachineModel::where('id', '=', $request->id)->first();

        // 없다면 404 에러
        if(!$result)
            return response('해당 데이터가 없습니다.', 404);

        // 문제 없다면 해당 유저 기기의 가동 상태를 반환
        return response($result->machine_ison, 200);
    }

    // 배지 유무 설정
    function GetIsPresence(Request $request) {
        $validator = Validator::make($request->all(),[
            "id" => "required"
        ]);

        if($validator->fails())
            return response($validator->errors(), 400);

        // 해당 유저 아이디로 기기와 조인해서 정보를 얻어온다.
        $result = MachineModel::where('id', '=', $request->id)->first();

        // 없다면 404 에러
        if(!$result)
            return response('해당 데이터가 없습니다.', 404);

        // 문제 없다면 해당 유저 기기의 가동 상태를 반환
        return response($result->machine_ispresence, 200);
    }

    function MachineTest(Request $request) {
        return response([ "token" => $request->cookie("token")]);
    }

    function DeleteMachine(Request $request) {
        $machine = MachineModel::where('id', $request->id);

        $userId = $machine->first()->machine_userid;

        $result = $machine->update([
            "machine_userid" => 1
        ]);

        $machineId = UserModel::where('id', '=', $machine->first()->id)
            ->first()->user_machineid;

        if($machineId != $request->id)
            UserModel::where('id', '=', $userId)->update([
               'user_machineid' => 0
            ]);

        if(!$result)
            return response('삭제 실패', 403);

        return response('삭제 성공', 200);
    }

    function RegisterMachine(Request $request) {
        $validator = Validator::make($request->all(),[
            "pin" => "required",
            "pw" => "required",
            "machineName" => "required",
        ]);

        if($validator->fails())
            return response($validator->errors(), 400);

        $result = MachineModel::select('Machines.machine_userid', 'Pins.pin_value', 'Pins.pin_pw')
            ->join('Pins', 'Machines.machine_pin', '=', 'Pins.pin_value')
            ->where('Pins.pin_value', '=', $request->pin)->first();

        $user = UserModel::select('Users.id', 'token.user_no', 'token.token')->join('token', 'Users.id', 'token.user_no')
            ->where('token', '=', $request->token)->first();

        if(!$user)
            return response("해당 유저가 없습니다", 404);
        if($result->pin_pw != $request->pw)
            return response("비밀번호 인증 실패", 401);
        if($result->machine_userid != 1)
            return response('이미 등록된 기기', 404);

        MachineModel::where('machine_pin', '=', $request->pin)->update([
            'machine_userid' => $user->id,
            'machine_name' => $request->machineName
        ]);

        return response($result->machine_ip, 200);
    }

    function GetMachine(Request $request) {
        // 프로그램 이름, 온/습/생장, 배지 이름,
        $validator = Validator::make($request->all(),[
            "id" => "required"
        ]);

        if($validator->fails())
            return response($validator->errors(), 400);

        $machine = MachineModel::select('Programs.id', 'Programs.prg_name')
            ->join('Programs', 'Machines.machine_prgid', '=', 'Programs.id')
            ->where('Machines.id', '=', $request->id);

        if($machine->count() == 0)
            return response('해당 데이터가 없습니다.', 404);

        return response($machine->get()->toArray(), 200);
    }

    function GetMachineList(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "token" => "required"
        ]);

        if($validator->fails())
            return response($validator->errors(), 400);

        $user = UserModel::select('Users.id', 'token.user_no', 'token.token')->join('token', 'Users.id', 'token.user_no')
            ->where('token', '=', $request->token)->first();

        if($user == null)
            return response('해당 유저가 없습니다.', 404);

        $machine = MachineModel::where('machine_userid', '=', $user->id);

        if($machine->count() == 0)
            return response("해당 데이터가 없습니다.", 404);

        return response($machine->get(), 200);
    }

    function SetMachineIP(Request $request) {
        $validator = Validator::make($request->all(),[
            "id" => "required",
            "ip" => "required"
        ]);

        if($validator->fails())
            return response($validator->errors(), 400);

        // 기기 체크
        $machine = MachineModel::where('id', '=', $request->id);
        // 없으면 예외
        if($machine->count() == 0)
            return response('해당 기기가 없습니다.', 404);

        $result = $machine->update([
            'machine_ip' => $request->ip
        ]);

        if(!$result)
            return response('변경에 실패하였습니다.', 403);
        return response('변경 성공', 200);
    }
}
