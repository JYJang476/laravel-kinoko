<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MushRoomImageModel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MushroomImageController extends Controller
{
    public function GetImage($id) {
        $mrImage = MushRoomImageModel::where('id', $id)->first();

        return Storage::get($mrImage->mrimg_url);
    }

    public function UploadImage(Request $request) {
        $path = $request->file('mushroom')->store('images');

        $result = MushRoomImageModel::insert([
            'mushimg_mrid' => $request->mushroomId,
            'mushimg_url' => $path,
            'mushimg_date' => $request->date
        ]);

        if(!$result)
            return response('업로드에 실패하였습니다.', 403);

        return respone('업로드 성공', 201);
    }
}
