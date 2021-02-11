<?php

use Illuminate\Http\Request;
use App\Http\Controllers\ProgramController;
//use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('farm/custom', 'ProgramController@AddCustomProgram');
Route::get('farm/custom/list', 'ProgramController@CustomList');

Route::get('farm/data', 'ProgramController@GetGraphData');
Route::put('farm/compostname', 'ProgramController@SetCompostName');
Route::get('farm/compostname', 'ProgramController@GetCompostName');
Route::put('farm/period', 'ProgramController@ExtendCustomPeriod');
Route::delete('farm', 'ProgramController@DeleteCustomProgram');
Route::get('farm/startdate', 'ProgramController@GetStartDate');

Route::post('myfarm/list', 'MachineController@GetMachineList');
Route::get('myfarm/data', 'MachineController@GetMachine');
Route::post('myfarm', 'MachineController@AddMachine');
Route::put('myfarm/program', 'MachineController@SetProgram');
Route::delete('myfarm', 'MachineController@DeleteMachine');
Route::put('myfarm/register', 'MachineController@RegisterMachine');
Route::get('myfarm/id', 'UserController@GetMachineId');

Route::get('myfarm/status', 'MachineController@GetIsOn');
Route::put('myfarm/status', 'MachineController@SetIsOn');
Route::get('myfarm/presence', 'MachineController@GetIsPresence');
Route::put('myfarm/presence', 'MachineController@SetIsPresence'); // 하드웨어용

Route::get('mushroom/{type}', 'MushroomController@GetMushRoom');
Route::get('mushroom', 'MushroomController@GetMushRoomAll');
Route::put('myfarm/select', 'UserController@SelectMachine');
Route::get('machine/test', 'MachineController@MachineTest');

Route::get('pin/check', 'PinController@CheckPin');
Route::get('pin/auth', 'PinController@AuthPin');

Route::post('auth', 'UserController@CheckLogin');

Route::post('register', 'UserController@RegisterUser');

Route::post('login', 'UserController@LoginUser');

Route::put('logout', 'UserController@LogoutUser');

Route::get('logout/date', 'UserController@GetLogoutDate');
