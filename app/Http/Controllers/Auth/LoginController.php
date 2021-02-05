<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Response;
use App\UserModel;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
//    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function googleRedirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleHandle()
    {
        $user = Socialite::driver('goole')->user();
        $userData = array('id' => $user->getId(), 'name' => $user->getName(), 'token' => $user->token);

        return view("testpage", ['Auth' => json_encode($userData)]);
    }

    public function redirectToProvider($loginType)
    {
        return Socialite::driver($loginType)->redirect();
    }

    public function SocialLogin($id) {
        $user = new UserModel();

        $result = $user->SelectUserData($id);

        if ($result->count() > 0)
            return response('success', 200);
        else
            return response('failed', 404);
    }

    public function AddUser(Request $request) {
        $user = new UserModel();

        $result = $user->InsertUserData([
            'user_id' => $request->input('userId'),
            'user_email' => $request->input('userEmail')
        ]);

        return response('success', 200);
    }

    public function InputLogoutDate($id) {
        $user = new UserModel();

        $user->UpdateUserData($id, Carbon::now());

        return \response('success', 200);
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($loginType)
    {
        $user = Socialite::driver($loginType)->user();

        if (UserModel::where('user_id', $user->getId())->count() == 0)
            return response('', 400);

        return response([
            'id' => $user->getId(),
            'name' => $user->getName(),
            'nickname' => $user->getNickName(),
            'token' => $user->token
        ], 200);
    }



}
