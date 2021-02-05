<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Validator;

class Controller extends BaseController
{
    public static function ValidateRequest(Request $request, $items) {
        $validator = Validator::make($request->all(), $items);

        if($validator->fails())
            return response($validator->errors(), 400);
    }
}
