<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PinModel;
use App\MachineModel;

class PinController extends Controller
{
    public function AddPin(Request $request) {
        $result = PinModel::insert([
            'pin_value' => $request->value,
            'pin_pw' => $request->pw
        ]);

        if(!$result)
            return response('핀 생성 실패', 403);

        return response('핀 생성 성공', 201);
    }

    public function CheckPin(Request $request) {
        $pinResult = PinModel::where('pin_value', '=', $request->pin)->first();

        if(!$pinResult)
            return response("핀 번호 없음", 404);

        if($pinResult->pin_machineid != 1)
            return response("이미 등록된 핀번호", 401);

        return response("사용가능 핀 번호", 200);
    }

    public function AuthPin(Request $request) {
        $pinResult = PinModel::where([
            'pin_value' => $request->pin,
            'pin_pw' => $request->pw
        ]);

        if($pinResult->count() == 0)
            return response("인증 실패", 401);

        return response("인증 성공", 200);
    }

    public function DeletePin(Request $request) {

        $result = PinModel::delete()->where('id', '=', $request->id);

        if(!result)
            return response('핀 삭제 실패', 403);

        return response('핀 삭제 성공', 200);
    }

    public function GetPinNumber(Request $request) {

        $result = PinModel::where('id', '=', $request->id)->first();

        if(!$result)
            return response("해당 데이터가 없습니다.", 404);

        return response($result->pin_value, 200);
    }
}
