<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $request->expectsJson()
            ? response()->json(['message'=>'退出成功'], 200)->withCookie(Cookie::make('access_token', ''))
            : redirect('/')->withCookie(Cookie::make('access_token', ''));
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        $user = $this->guard()->user();

        $user->ip_address = $request->getClientIp();
        $user->save();

        if($user->image){
            //$user->image = Storage::disk('uploads')->url($user->image);
        }

        return $this->authenticated($request, $this->guard()->user())
            ?: $request->expectsJson()
                ? response()->json(['message' => '会员登录成功', 'data' => $user], 200)
                : redirect()->intended($this->redirectPath());
    }

    protected function credentials(Request $request)
    {
        $password = md5($request->password);
        return ["{$this->username()}" => $request->{$this->username()}, "password" => $password];
        //return $request->only($this->username(), 'password');
    }


    public function username()
    {
        return 'name';
    }


}
