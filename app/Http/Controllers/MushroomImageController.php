<?php

namespace App\Http\Controllers;

use App\MushroomModel;
use App\ProgramModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\MushRoomImageModel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Validator;

class MushroomImageController extends Controller
{
    public function GetImage($id) {
        $mrImage = MushRoomImageModel::where('id', $id)->first();

        if($mrImage == null)
            return response('파일 없음', 404);

        return Storage::get($mrImage->mushimg_url);
    }

    public function UploadImage(Request $request) {

        $path = $request->file('mushroom')->store('images');

        $mush = MushroomModel::where('id', '=', $request->mushroomId)->first();

        $programs = ProgramModel::select('Programs.id', 'Dates.date_start', 'Programs.prg_dateid')
                        ->join('Dates', 'Programs.prg_dateid', 'Dates.id')
                        ->where('Programs.id', '=', $mush->mr_prgid)->first();

        $nowDate = Carbon::now()->addHour(9);
        $diffDay = Carbon::createFromFormat('Y-m-d H:i:s', $programs->date_start)->diffInDays($nowDate);

        $result = MushRoomImageModel::insert([
            'mushimg_mrid' => $request->mushroomId,
            'mushimg_url' => $path,
            'mushimg_date' => $diffDay // 나중에 $diffDay로 교체(지금은 임시값)
        ]);

        if(!$result)
            return response('업로드에 실패하였습니다.', 403);

        return response('업로드 성공', 201);
    }
}
