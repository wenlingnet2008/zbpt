<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ImportUserController extends Controller
{
    public function updateUserPassword()
    {
        $users = User::get();
        foreach($users as $user){
            $user->password = bcrypt(md5('111111'));
            $user->save();
        }
        return response()->json(['message'=>'更新所有帐号密码为111111']);
    }
}
