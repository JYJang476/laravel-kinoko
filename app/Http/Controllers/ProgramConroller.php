<?php

namespace App\Http\Controllers;

use App\DateModel;
use App\GrowthRateModel;

use App\MachineModel;
use App\ProgramModel;
use App\SettingModel;
use App\Http\Controllers\MachineController;
use Validator;

use Illuminate\Http\Request;
use function foo\func;

class ProgramController extends Controller
{
    # param : 종류,AddCustomProgram
    public function GetGraphData(Request $request) {
        $validator = Validator::make($request->all(),[
            "id" => "required",
            "type" => "required",
        ]);

        if($validator->fails())
            return response($validator->errors(), 400);

        $table = ProgramModel::join('Setting_datas', 'Programs.id', '=', 'Setting_datas.setting_prgid')
            ->where(['prg_type' => $request->type,
                'Programs.id' => $request->id
            ]);

        if($table->count() == 0)
            return response('해당 데이터가 없습니다.', 404);

        $temperature = clone $table;
        $temperature = $temperature->where('Setting_datas.setting_type', 'temperature')
            ->select('setting_type', 'setting_value', 'setting_date')->get();

        $humidity = clone $table;
        $humidity = $humidity->where('Setting_datas.setting_type', 'humidity')
            ->select('setting_type', 'setting_value', 'setting_date')->get();

        $growthRate = ProgramModel::join('Growth_rates', 'Programs.id', '=', 'Growth_rates.gr_prgid')
            ->where('Programs.id',  $request->id);

        $growthRate = $growthRate
            ->select('gr_value')->get();

        return response([
            'temperature' => $temperature->toArray(),
            'humidity' => $humidity->toArray(),
            'growthRate' => $growthRate->toArray()
        ], 201);
    }

    private function GetProgramList($type) {

        $customs = ProgramModel::select('id', 'prg_name', 'prg_count')
            ->where('prg_type', $type);

        return $customs;
    }

    public function CustomList() {
        $customs = $this->GetProgramList("custom")->get()->map(function ($custom) {

            $temps = SettingModel::select('setting_value', 'setting_date')->where([
                'setting_prgid' => $custom->id,
                'setting_type' => 'temperature'
            ])->get();

            $humi = SettingModel::select('setting_value', 'setting_date')->where([
                'setting_prgid' => $custom->id,
                'setting_type' => 'humidity'
            ])->get();

            $growth = GrowthRateModel::select('gr_value')->where('gr_prgid', '=', $custom->id)->get();

            return [
                'id' => $custom->id,
                'prg_name' => $custom->prg_name,
                'prg_count' => $custom->prg_count,
                'temperature' => $temps->toArray(),
                'humidity' => $humi->toArray(),
                'growthRate' => $growth->toArray()
            ];
        });

        return response($customs->toArray(), 200);
    }

    public function SetCompostName(Request $request) {
        $validator = Validator::make($request->all(),[
            "name" => "required",
            "id" => "required",
        ]);

        if($validator->fails())
            return response($validator->errors(), 400);

        if(!ProgramModel::update([
            'prg_compostname' => $request->name
        ])->where('id', '=', $request->id))
            return response('변경 실패', 403);

        return response('변경 성공', 200);
    }

    public function AddCustomProgram(Request $request) {
        // 유저 id, 재배기간, 물주기, 햇빛, 온도, 습도, 프로그램 이름
        $validator = Validator::make($request->all(),[
            "machineId" => "required",
            "name" => "required",
            "water" => "required",
            "sunshine" => "required",
            "period" => "required"
        ]);

        if($validator->fails())
            return response($validator->errors(), 400);

        $machine = MachineModel::where('id', $request->machineId)->first();

        if($machine == null)
            return response("not found", 401);
        // 기간 만큼 빈 날짜 데이터 추가
        DateModel::insert([
            'date_userid' => $machine->machine_userid
        ]);

        $insertDate = DateModel::all()->last();

        // 프로그램 데이터 추가
        $result = ProgramModel::insert([
            'prg_userid' => $machine->machine_userid,
            'prg_machineid' => 0,
            'prg_name' => $request->name,
            'prg_type' => 'custom',
            'prg_water' => $request->water,
            'prg_sunshine' => $request->sunshine,
            'prg_count' => 0,
            'prg_compostname' => "",
            'prg_period' => $request->period,
            'prg_dateid' => $insertDate->id
        ]);
        // 예외 처리
        if(!$result)
            return response('실패', 402);

        $insertProgramId = ProgramModel::all()->last()->id;
        // 재배 기간 만큼 빈 데이터 추가
        for($i = 0; $i < $request->period; $i++) {
            // 온도
            SettingModel::insert([
                'setting_prgid' => $insertProgramId,
                'setting_value' => $request->temp[$i],
                'setting_type' => "temperature"
            ]);
            // 습도
            SettingModel::insert([
                'setting_prgid' => $insertProgramId,
                'setting_value' => $request->humi[$i],
                'setting_type' => "humidity"
            ]);
            // 생장률
            GrowthRateModel::insert([
                'gr_userid' => $machine->machine_userid,
                'gr_prgid' => $insertProgramId,
                'gr_value' => 0
            ]);
        }

        return response("성공", 200);
    }


    public function ExtendCustomPeriod(Request $request) {
        // 기간, 기간분의 데이터(Array), 프로그램 id, 유저 id
        $validator = Validator::make($request->all(),[
            "id" => "required",
            "value" => "required",
            "tempDate" => "required",
            "humiDate" => "required",
            "period" => "required",
            "userid" => "required"
        ]);

        if($validator->fails())
            return response($validator->errors(), 400);

        for($i = 0; $i < $request->period; $i++) {
            // 온도
            SettingModel::insert([
                'setting_prgid' => $request->id,
                'setting_value' => $request->value,
                'setting_type' => 'temperature',
                'setting_date' => $request->tempDate[$i],
            ]);
            // 습도
            SettingModel::insert([
                'setting_prgid' => $request->id,
                'setting_value' => $request->value,
                'setting_type' => 'humidity',
                'setting_date' => $request->humiDate[$i],
            ]);
            // 생장률
            GrowthRateModel::insert([
                'gr_userid' => $request->userid,
                'gr_prgid' => $request->id,
                'gr_value' => 0
            ]);
        }

        $result = ProgramModel::where('id', $request->id)->update([
            'prg_period' => $request->period
        ]);

        if(!$result)
            return response("연장 실패", 403);

        return response("성공", 201);
    }

    public function DeleteCustomProgram(Request $request) {
        $validator = Validator::make($request->all(),[
            "id" => "required"
        ]);

        if($validator->fails())
            return response($validator->errors(), 400);

        $result = ProgramModel::where('id', $request->id)->delete();

        if(!$result)
            return response('실패', 403);

        return response('성공', 200);
    }

    public function getProgramData($id) {
        # 이름
        # 하루 당 온습도
        # 재배기간
        # 물주기
        # 햇빛
        # 날짜당 생장률
        # 날짜당 수확 버섯 수
        # 수확한 버섯 수
        # 시작, 종료날짜

    }

    // param : 날짜 당 온/습도(Array), 물주기, 햇빛, 재배기간, 프로그램 이름
    public function AddProgramData(Request $request) {

    }
}
