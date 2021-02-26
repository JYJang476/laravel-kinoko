<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HelpImageModel;
use Illuminate\Support\Facades\Storage;

class HelpImageController extends Controller
{
    public function GetImage($id) {
        $mrImage = HelpImageModel::where('id', $id)->first();

        if($mrImage == null)
            return response('파일 없음', 404);

        return Storage::get($mrImage->url);
    }

    public function UploadImage(Request $request) {

        $path = $request->file('helpimage')->store('help');

        $result = HelpImageModel::insert([
            'url' => $path
        ]);

        if(!$result)
            return response('업로드에 실패하였습니다.', 403);

        return response('업로드 성공', 201);
    }
}
