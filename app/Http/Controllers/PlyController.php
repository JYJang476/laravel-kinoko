<?php

namespace App\Http\Controllers;

use App\MushRoomImageModel;
use App\MushroomModel;
use App\ProgramModel;
use App\UserModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\PlyModel;
use Validator;
use Illuminate\Support\Facades\Storage;

class  PlyController extends Controller
{
    public function GetFile($id) {
        $user = UserModel::where('id', '=', '1')->first();

        if($user->token == "false")
            return response('허가나지 않음', 403);

        $plyImage = PlyModel::where('machineid', $id);

        if($plyImage == null)
            return response('파일 없음', 404);

        $responseData = Storage::get($plyImage->first()->url);
        
//        Storage::delete($plyImage->first()->url);
//
//        if(!$plyImage->delete())
//            return response('파일 삭제 실패', 403);

        return response($responseData, 200);
    }

    public function IsAccess(Request $request) {
        $user = UserModel::where('id', '=', '1')->first();

        if($user->token == "false")
            return response('허가나지 않음', 404);

        return response("OK", 200);
    }

    public function UploadFile(Request $request) {
        // 파라미터의 유효성 검사
        $validator = Validator::make($request->all(),[
            "machineid" => "required"
        ]);

        if($validator->fails())
            return response($validator->errors(), 400);

        $path = $request->file('ply')->store('ply');

        $result = PlyModel::insert([
            'machineid' => $request->machineid,
            'url' => $path,
        ]);

        if(!$result)
            return response('업로드에 실패하였습니다.', 403);

        return response('업로드 성공', 201);
    }
}
