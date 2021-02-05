<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\User;

class TestClass {
    private $m_tt;
}

class TaskController extends Controller
{
    private $tasks;

    /**
     * @return mixed
     */

    public function list3($id, Request $req) {
        $users = DB::table('users')->increment("title");
        echo $users;
        return view('task.list3');
    }

}

?>