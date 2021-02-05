<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MachineModel;
use App\ProgramModel;
use App\Http\Controllers\ProgramController;
use Illuminate\Database\Eloquent;
use App\PinModel;
use App\UserModel;
use Validator;
use App\Http\Controllers\Controller;

class MachineController extends Controller
{
    function AddMachine(Request $request) {
        $validator = Validator::make($request->all(),[
            "pin" => "required",
            "pw" => "required",
        ]);

        if($validator->fails())
            return response($validator->errors(), 400);

        $result = MachineModel::insert([
            'machine_userid' => 1,
            'machine_prgid' => 0,
            'machine_pin' => $request->pin,
            'machine_name' => ""
        ]);

        if(!$result)
            return response("기기 추가 실패", 403);

        $insertMachineId = MachineModel::all()->last()->id;

        $result = PinModel::insert([
            'pin_value' => $request->pin,
            'pin_machineid' => $insertMachineId,
            'pin_pw' => $request->pw
        ]);

        if(!$result)
            return response("핀 번호 추가 실패", 403);

        return response("성공", 201);
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
                  ->update('machine_ison', $request->status);

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
            ->update('machine_ispresence', $request->status);

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

        $result = MachineModel::where('id', '=', $request->id)->first();

        if(!$result)
            return response('해당 데이터가 없습니다.', 404);

        return response($result->machine_ison, 200);
    }

    // 배지 유무 설정
    function GetIsPresence(Request $request) {
        $validator = Validator::make($request->all(),[
            "id" => "required",
        ]);

        if($validator->fails())
            return response($validator->errors(), 400);

        $result = MachineModel::where('id', '=', $request->id)->first();

        if(!$result)
            return response('해당 데이터가 없습니다.', 404);

        return response($result->machine_ispresence, 200);
    }

    function MachineTest(Request $request) {
        $request->validate([
           "id" => "required"
        ]);
//        return $result->;
//        $userId = UserModel::where('user_id', '=', $request->userId)->first()->id;
//
//        $machine = MachineModel::where('machine_userid', '=', $userId)->get();
//
//        return response($machine->toArray(), 200);
    }

    function DeleteMachine(Request $request) {
        $result = MachineModel::where('id', $request->id)->update([
            "machine_userid" => 1
        ]);

        if(!$result)
            return response('삭제 실패', 403);

        return response('삭제 성공', 200);
    }

    function RegisterMachine(Request $request) {
//        $validator = Validator::make($request->all(),[
//            "pin" => "required",
//            "pw" => "required",
//            "name" => "required",
//            "userId" => "required"
//        ]);
//
//        if($validator->fails())
//            return response($validator->errors(), 400);

        $result = MachineModel::select('machines.machine_userid', 'pins.pin_value', 'pins.pin_pw')
                                ->join('pins', 'machines.machine_pin', '=', 'pins.pin_value')
                                ->where('pins.pin_value', '=', $request->pin)->first();

        $user = UserModel::where('user_id', '=', $request->userId)->first();

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

        $machine = MachineModel::select('programs.id', 'programs.prg_name')->join('programs', 'machines.machine_prgid', '=', 'programs.id')
                        ->where('machines.id', '=', $request->input('id'));

        if($machine->count() == 0)
            return response('해당 데이터가 없습니다.', 404);

        return response($machine->get()->toArray(), 200);
    }

    function GetMachineList(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "userId" => "required"
        ]);

        if($validator->fails())
            return response($validator->errors(), 400);

        $user = UserModel::where('user_id', '=', $request->userId)->first();

        if($user == null)
            return response('해당 유저가 없습니다.', 404);

        $machine = MachineModel::where('machine_userid', '=', $user->id);

        if($machine->count() == 0)
            return response("해당 데이터가 없습니다.", 404);

        return response($machine->get(), 200);
    }
}
