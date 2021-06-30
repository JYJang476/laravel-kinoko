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
    // 목적: 새로운 기기를 추가 한다.
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

    // 목적: 핀 번호가 존재하는지 조회한다.
    // 파라미터 : 1. pin - 조회할 핀번호
    public function IsExist(Request $request) {
        $result = MachineModel::where('machine_pin', '=', $request->pin)->first();

        if($result->machine_prgid == null)
            return response('false', 201);

        return response($result->machine_prgid, 200);
    }

    // 목적: 기기의 사용 프로그램을 설정한다.
    // 파라미터 : 1. id - 대상 기기 ID
    //          2. pw  - 핀번호의 패스워드
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
        // 시작시간 설정
        ProgramModel::select('Programs.id', 'Dates.date_start')
            ->join('Dates', 'Dates.id', 'Programs.prg_dateid')
            ->where('Programs.id', '=', $request->prgId)
            ->update([
               'date_start' => Carbon::now()->format('Y-m-d H:i:s')
            ]);

        return response('성공', 201);
    }

    // 가동 상태 설정
    // 목적: 기기의 가동상태를 설정한다.
    // 파라미터 : 1. id - 대상 기기 ID
    //          2. status - 설정할 상태값(true : 가동, false : 비가동)
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
    // 목적: 기기 안에 있는 배지의 유무를 설정한다.
    // 파라미터 : 1. id - 대상 기기 ID
    //          2. status - 배지의 존재유무 (true : 있음, false : 없음)
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

    // 목적: 기기의 가동상태를 얻어온다.
    // 파라미터 : 1. id - 대상 기기 ID
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
    // 목적: 기기의 배지 유무를 가져온다.
    // 파라미터 : 1. id - 대상 기기 ID
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

    // 목적: 기기를 목록에서 삭제한다.
    // 파라미터 : 1. id - 대상 기기 ID
    function DeleteMachine(Request $request) {
        $validator = Validator::make($request->all(),[
            "id" => "required",
        ]);

        if($validator->fails())
            return response($validator->errors(), 400);
        // 해당 id를 가진 기기를 찾는다.
        $machine = MachineModel::where('id', $request->id);
        // 찾는 기기가 없으면 에러 반환
        if($machine->count() == 0)
            return response('해당 기기 없음', 200 );
        // 해당 기기를 소유하는 사용자 id를 가져온다.
        $userId = $machine->first()->machine_userid;

//        $machineId = UserModel::where('id', '=', $userId)
//            ->first()->user_machineid;

        //if($machineId != $request->id)
        UserModel::where('id', '=', $userId)->update([
           'user_machineid' => 0
        ]);

        $result = $machine->update([
            'machine_userid' => 0,
            'machine_ison' => 'false',
            'machine_ip' => null,
            'machine_ispresence' => 'false',
            'machine_name' => '',
            'machine_prgid' => 0
,        ]);

        if(!$result)
            return response('삭제 실패', 403);

        return response('삭제 성공', 200);
    }

    // 목적: 새로운 기기를 등록한다.
    // 파라미터 : 1. id - 대상 기기 ID
    //          2. pw  - 핀번호의 패스워드
    //          3. machineName  - 설정할 기기의 이름
    function RegisterMachine(Request $request) {
        $validator = Validator::make($request->all(),[
            "pin" => "required",
            "pw" => "required",
            "machineName" => "required",
            "token" => "required"
        ]);

        if($validator->fails())
            return response($validator->errors(), 400);

        $result = MachineModel::select('Machines.machine_userid', 'Pins.pin_value', 'Pins.pin_pw')
            ->join('Pins', 'Machines.machine_pin', '=', 'Pins.pin_value')
            ->where('Pins.pin_value', '=', $request->pin)->first();

        $user = UserModel::select('Users.id', 'token.user_no', 'token.token')->join('token', 'Users.id', 'token.user_no')
            ->where('token.token', '=', $request->token)->first();

        if(!$user || !$result)
            return response("해당 유저가 없습니다", 404);
        if($result->pin_pw != $request->pw)
            return response("비밀번호 인증 실패", 401);
        if($result->machine_userid != 0)
            return response('이미 등록된 기기', 404);

        MachineModel::where('machine_pin', '=', $request->pin)->update([
            'machine_userid' => $user->id,
            'machine_name' => $request->machineName
        ]);

        return response($result->machine_ip, 200);
    }

    // 목적: 해당 기기의 이름, 온도, 습도, 생장률, 배지이름 등을 가져온다.
    // 파라미터 : 1. id - 대상 기기 ID
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

    // 목적: 기기의 목록을 가져온다.
    // 파라미터 : 1. token - 조회할 계정의 현재 토큰
    function GetMachineList(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "token" => "required"
        ]);

        if($validator->fails())
            return response($validator->errors(), 400);

        $user = UserModel::select('Users.id', 'token.user_no', 'token.token')->join('token', 'Users.id', 'token.user_no')
            ->where('token.token', '=', $request->token)->first();

        if($user == null)
            return response('해당 유저가 없습니다.', 404);

        $machine = MachineModel::where('machine_userid', '=', $user->id);

        if($machine->count() == 0)
            return response("해당 데이터가 없습니다.", 404);

        return response($machine->get(), 200);
    }

    // 목적: 기기 아이피를 설정한다.
    // 파라미터 : 1. id - 대상 기기 ID
    //          2. ip  - 설정할 ip
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

        return response('변경 성공', 200);
    }
}
