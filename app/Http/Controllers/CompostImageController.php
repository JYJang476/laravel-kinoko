<?php

namespace App\Http\Controllers;

use App\MushRoomImageModel;
use App\MushroomModel;
use App\ProgramModel;
use App\CompostImageModel;
use App\UserModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use function foo\func;

class CompostImageController extends Controller
{
    public function GetImage($id) {
        $compostImage = CompostImageModel::where('id', $id)->first();

        if($compostImage == null)
            return response('파일 없음', 404);

        return Storage::get($compostImage->compostimg_url);
    }

    public function GetImageClusterList($page, $id) {
        $compostImage = CompostImageModel::selectRaw('id, count(*) as count, compostimg_date')
            ->where('compostimg_userid', '=', $id)
            ->groupByRaw('floor(day(compostimg_date)/3)');

        if($compostImage->count() == 0)
            return response('클러스터 없음', 404);

        $result = $compostImage->get()->forPage($page, 3)->map(function($compost) {
            $members = CompostImageModel::select('id')->where('id', '>', $compost->id)
                ->get()->forPage(1, $compost->count)->map(function($item) {
                    return $item->id;
                });

            return [
                'id' => $compost->id,
                'date' => $compost->compostimg_date,
                'members' => $members
            ];
        });

        return response($result, 200);
    }


    public function UploadImage(Request $request) {

        $path = $request->file('compost')->store('compost');

        $user = UserModel::where('user_machineid', '=', $request->machineid)->first();
        if($user == null)
            return response('해당 기기가 등록된 계정을 찾을 수 없습니다.', 404);

        $result = CompostImageModel::insert([
            'compostimg_userid' => $user->id,
            'compostimg_url' => $path,
        ]);

        if(!$result)
            return response('업로드에 실패하였습니다.', 403);

        return response('업로드 성공', 201);
    }
}
