<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SettingModel;
use Illuminate\Support\Facades\DB;
use Validator;

class SettingController extends Controller
{
    function GetDataToHour(Request $request) {
        $validator = Validator::make($request->all(),[
            "prgId" => "required",
        ]);

        if($validator->fails())
            return response($validator->errors(), 400);

        $settingTable = SettingModel::select('setting_prgid', 'setting_value', 'setting_type', 'setting_date');

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
            'temperature' => $tempArray,
            'humidity' => $humiArray
        ], 200);
    }
}
