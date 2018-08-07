<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return view('home');
    }

    public function updateUserProfile(Request $request)
    {
        $this->validate($request, [
            'mobile' => ['required', 'max:11'],
            'qq'    => ['required', 'max:20'],
        ]);

        $user = \request()->user();

        if($request->file('image')){
            $image = $request->file('image')->store(date('Ymd'), 'uploads');
            $user->image = $image;
        }

        $user->qq = $request->qq;
        $user->mobile = $request->mobile;
        $user->save();

        if($user->image){
            //$user->image = Storage::disk('uploads')->url($user->image);
        }

        return response()->json(['message'=>'更新成功', 'data'=> $user]);
    }


    public function changePassword(Request $request)
    {
        $this->validate($request, ['password' => 'required|confirmed|min:6', 'oldpassword'=>'required']);
        $user = \request()->user();
        if(Hash::check($request->input('oldpassword'), $user->password)){
            $user->password = Hash::make($request->input('password'));
            $user->setRememberToken(Str::random(60));
            $user->save();
            return response()->json(['message'=>'修改密码成功']);
        }else{
            return response()->json(['message'=>'原有密码错误'], 400);
        }
    }



}
