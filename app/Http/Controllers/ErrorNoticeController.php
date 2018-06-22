<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorNoticeController extends Controller
{
    public function firewall()
    {
        return view('admin.error_notice', ['permission'=>'IP禁止访问']);
    }

    public function online()
    {
        return view('admin.error_notice', ['permission'=>'在其他客户端登陆']);
    }
}
