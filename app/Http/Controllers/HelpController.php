<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\helpModel;

class HelpController extends Controller
{
    // 목록 가져오기
    function GetHelpList(Request $request){
        $help = helpModel::all();

        return response($help, 200);
    }
    // 정보 가져오기
    function GetHelpData($id) {
        $helpData = helpModel::where("id", "=", $id)->first();

        return response($helpData, 200);
    }

}
