<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Mews\Purifier\Facades\Purifier;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|alpha_dash|min:4|max:15|unique:users',
            'email' => 'nullable|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'room_id'  => 'required|integer',
            'mobile'  => 'required',
            'qq'    => 'nullable|integer',
            'nick_name' => 'required|string|min:4|max:10|unique:users',
        ]);
    }


    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        $user->syncRoles('普通会员');

        return $this->registered($request, $user)
            ?: $request->expectsJson()
                ? response()->json(['message' => '会员注册成功', 'data' => User::findOrFail($user->id)], 200)
                :redirect($this->redirectPath());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $data['name'] = strip_tags($data['name']);
        $data['nick_name'] = e($data['nick_name']);
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt(md5($data['password'])),
            'room_id'  => $data['room_id'],
            'mobile'   => $data['mobile'],
            'nick_name' => $data['nick_name'],
            'qq'    => $data['qq'],
            'ip_address' => \request()->getClientIp(),
        ]);
    }
}
