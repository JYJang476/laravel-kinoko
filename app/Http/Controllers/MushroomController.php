<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MushroomModel;
use App\MushRoomImageModel;

class MushroomController extends Controller
{
    public function AddMushRoom(Request $request) {

        MushroomModel::insert([
            'mr_prgid' => $request->prgId,
            'mr_size' => 0,
            'mr_imgid' => 0
        ]);

//        $mushroom = MushroomModel::all()->last()->get();

//        MushRoomImageModel::insert([
//            'mushimg_mrid' => $mushroom->id,
//            'mushimg_url' => "/image/".$mushroom->id
//        ]);
    }

    public function GetMushRoomAll(Request $request) {

        $mushroom = MushroomModel::where('mr_prgid', '=', $request->prgId);

        if($mushroom->count() == 0)
            return response('해당 데이터를 찾지 못했습니다.', 404);

        return response($mushroom->get()->toArray(), 200);
    }

    public function GetMushRoom(Request $request, $type) {

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
