<?php

namespace App\Http\Controllers;

use App\GrowthRateModel;
use App\UserModel;
use Illuminate\Http\Request;
use App\SettingModel;
use Illuminate\Support\Facades\DB;
use Validator;

class SettingController extends Controller
{
    function GetDataToLastlogout(Request $request) {
        $validator = Validator::make($request->all(),[
            "prgId" => "required",
            "date" => "required"
        ]);

        if($validator->fails())
            return response($validator->errors(), 400);

        // 유저 아이디로 마지막 로그인 날짜 획득
        $tempArray = SettingModel::whereRaw(
            'setting_type="temperature" and setting_prgid=? and setting_date >= date_format(?, "%Y-%m-%d %H:%i:%S")', [
            $request->prgId,
            $request->date])->orderBy('setting_date')->get();

        $humiArray = SettingModel::whereRaw(
            'setting_type="humidity" and setting_prgid=? and setting_date >= date_format(?, "%Y-%m-%d %H:%i:%S")', [
            $request->prgId,
            $request->date])->orderBy('setting_date')->get();

        return response([
            "temperature" => $tempArray,
            "humidity" => $humiArray
        ], 200);
    }
    // 시간 단위로 데이터를 받아온다.
    function GetDataToHour(Request $request) {
        $validator = Validator::make($request->all(),[
            "prgId" => "required",
        ]);

        if($validator->fails())
            return response($validator->errors(), 400);

        $settingTable = SettingModel::select('setting_prgid', 'setting_value', 'setting_type', 'setting_date');
        $growthTable = GrowthRateModel::where('gr_prgid', '=', $request->prgId);

        $tempTable =  clone $settingTable;
        $tempArray = $tempTable->where([
            'setting_prgid' => $request->prgId,
            'setting_type' => 'temperature'
        ])->orderBy('setting_date')->get();

        $humiTable =  clone $settingTable;
        $humiArray = $humiTable->where([
            'setting_prgid' => $request->prgId,
            'setting_type' => 'humidity'
        ])->orderBy('setting_date')->get();

        return response([
            'growthRate' => $growthTable->get(),
            'temperature' => $tempArray,
            'humidity' => $humiArray
        ], 200);
    }
}
