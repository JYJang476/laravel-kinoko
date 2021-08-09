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

    public function GetImageHistory($id) {
        $mush = MushRoomImageModel::select([
            'id', 'mushimg_mrid', 'mushimg_date'
        ])->where('mushimg_mrid', '=', $id);

        if($mush->count() == 0)
            return response('버섯 이미지가 없습니다.', 404);

        return response($mush->get()->toArray(), 200);
    }

    public function UploadImage(Request $request) {

        $path = $request->file('mushroom')->store('images');

        $mush = MushroomModel::where('id', '=', $request->mushroomId);

        $programs = ProgramModel::select('Programs.id', 'Dates.date_start', 'Programs.prg_dateid')
                        ->join('Dates', 'Programs.prg_dateid', 'Dates.id')
                        ->where('Programs.id', '=', $mush->first()->mr_prgid)->first();

        $nowDate = Carbon::now()->addHour(9);
        $diffDay = Carbon::createFromFormat('Y-m-d H:i:s', $programs->date_start)->diffInDays($nowDate);

        $result = MushRoomImageModel::insert([
            'mushimg_mrid' => $request->mushroomId,
            'mushimg_url' => $path,
            'mushimg_date' => $diffDay
        ]);

        $uploadMushId = MushRoomImageModel::all()->last()->id;

        $meta = json_decode($mush->first()->mr_metadata);
        $meta->x = $request->x;
        $meta->y = $request->y;

        $mush->update([
            'mr_imgid' => $uploadMushId,
            'mr_metadata' => json_encode($meta)
        ]);
        
        if(!$result)
            return response('업로드에 실패하였습니다.', 403);

        return response($uploadMushId, 201);
    }
}
