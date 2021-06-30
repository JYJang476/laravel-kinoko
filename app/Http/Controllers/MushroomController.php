<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MushroomModel;
use Validator;

class MushroomController extends Controller
{
    public function AddMushRoom(Request $request) {
        $validator = Validator::make($request->all(),[
            "prgId" => "required",
            "size" => "required",
            "metaJSON" => "required"
        ]);

        if($validator->fails())
            return response($validator->errors(), 400);

        MushroomModel::insert([
            'mr_prgid' => $request->prgId,
            'mr_size' => $request->size,
            'mr_imgid' => 0,
            'mr_metadata' => $request->metaJSON
        ]);

        return response('성공', 200);
    }

    public function SetMushroomSize(Request $request) {
        $validator = Validator::make($request->all(),[
            "id" => "required",
            "value" => "required"
        ]);

        if($validator->fails())
            return response($validator->errors(), 400);

        $mush = MushroomModel::where('id', '=', $request->id);

        if($mush->count() == 0)
            return response('버섯이 없습니다.', 404);

        $mush->update([
            'mr_size' => $request->value
        ]);

        return response('성공', 200);
    }

    public function GetMushRoomAll(Request $request) {
        $validator = Validator::make($request->all(),[
            "prgId" => "required",
        ]);

        if($validator->fails())
            return response($validator->errors(), 400);

        $mushroom = MushroomModel::where('mr_prgid', '=', $request->prgId);

        if($mushroom->count() == 0)
            return response('해당 데이터를 찾지 못했습니다.', 404);

        return response($mushroom->get()->toArray(), 200);
    }

    public function GetMushRoom(Request $request, $type) {
        $validator = Validator::make($request->all(),[
            "prgId" => "required",
        ]);

        if($validator->fails())
            return response($validator->errors(), 400);

        $mushroom = MushroomModel::where([
            'mr_prgid' => $request->prgId,
            'mr_status' => $type
        ]);

        if(!$mushroom)
            return response('해당 데이터를 찾지 못했습니다.', 404);

        return response($mushroom->get()->toArray(), 200);
    }

    public function GetMushForStatus($prgId, $status='growing')
    {
        $mushrooms = MushroomModel::where([
            'mr_status' => $status,
            'mr_prgid' => $prgId
        ]);

        return response($mushrooms->toArray(), 200);
    }
}
