<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImportUserController extends Controller
{
    public function updateUserPassword()
    {
//        $users = User::get();
//        foreach($users as $user){
//            $user->password = bcrypt(md5('111111'));
//            $user->save();
//        }
//        return response()->json(['message'=>'更新所有帐号密码为111111']);
    }


    public function index()
    {
        ini_set('max_execution_time', 300);
        $chat_members = DB::table('chat_members')->where('password', '!=', '')->get();


        foreach($chat_members as $member){
            if(!$member->username) continue;
            $user = [
                'name' => $member->username,
                'email' => null,
                'password' => bcrypt($member->password),
                'room_id' => 1,
                'mobile' => $member->phone,
            ];
            if(!User::where('name', $member->username)->first()){
                User::create($user);
            }

        }
        return response()->json(['message'=>'导入老数据成功']);
    }
}
