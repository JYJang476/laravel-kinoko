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

        $mush = MushroomModel::all()->last();

        return response($mush->id, 200);
    }

    public function SetMetadata(Request $request) {
        $validator = Validator::make($request->all(),[
            "id" => "required",
            "x" => "required",
            "y" => "required",
            "width" => "required",
            "height" => "required"
        ]);

        if($validator->fails())
            return response($validator->errors(), 400);

        $mush = MushroomModel::where('id', '=', $request->id);

        if($mush->count() == 0)
            return response('해당 버섯이 없습니다.', 404);

        $metadata = json_decode($mush->first()->mr_metadata);

        $metadata->x = $request->x;
        $metadata->y = $request->y;
        $metadata->width = $request->width;
        $metadata->height = $request->height;

        $mush->update([
            'mr_metadata' => json_encode($metadata)
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

    public function GetMushroomForRotation(Request $request) {
        $validator = Validator::make($request->all(),[
            "prgId" => "required",
            "rotation" => "required",
        ]);

        if($validator->fails())
            return response($validator->errors(), 400);


        $mush = MushroomModel::select(['Mushrooms.id', 'Mushrooms.mr_prgid', 'Mushrooms.mr_imgid',
                            'Mushrooms.mr_status', 'Mushrooms.mr_metadata', 'Mushrooms.mr_date', 'Mushrooms.mr_size', 'Mushrooms.mr_growthrate'])
                            ->join('Mushroom_images', 'Mushrooms.mr_imgid', 'Mushroom_images.id')
                            ->where([
                                ['Mushrooms.mr_prgid', '=', $request->prgId],
                                ['Mushrooms.mr_metadata', 'like', '%"rotation":"'.$request->rotation.'"%']
                            ]);

        if($mush->count() == 0)
            return response('데이터가 없습니다.', 404);

        return response($mush->get()->toArray(), 200);
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
