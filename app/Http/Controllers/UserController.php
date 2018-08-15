<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('mobile.user_profile');
    }

    public function changePassword()
    {
        return view('mobile.chang_password');
    }

    public function updateUserProfile(Request $request)
    {
        $user = \request()->user();

        $this->validate($request, [
            'mobile' => ['required', 'max:11'],
            'qq'    => ['nullable', 'max:20'],
            'nick_name' => ['required', 'min:4', 'max:10', Rule::unique('users', 'nick_name')->ignore($user->id)],
        ]);



        if($request->file('image')){
            $image = $request->file('image')->store(date('Ymd'), 'uploads');
            $user->image = $image;
        }
        $user->nick_name = e($request->nick_name);
        $user->qq = $request->qq;
        $user->mobile = $request->mobile;
        $user->save();

        if($user->image){
            //$user->image = Storage::disk('uploads')->url($user->image);
        }

        return response()->json(['message'=>'更新成功', 'data'=> $user]);
    }


    public function updatePassword(Request $request)
    {
        $this->validate($request, ['password' => 'required|confirmed|min:6', 'oldpassword'=>'required']);
        $user = \request()->user();
        if(Hash::check(md5($request->input('oldpassword')), $user->password)){
            $user->password = Hash::make(md5($request->input('password')));
            $user->setRememberToken(Str::random(60));
            $user->save();
            return response()->json(['message'=>'修改密码成功']);
        }else{
            return response()->json(['message'=>'原有密码错误'], 400);
        }
    }



}
