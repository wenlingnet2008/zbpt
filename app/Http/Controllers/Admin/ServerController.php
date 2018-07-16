<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServerController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage_server');
    }

    public function index(Request $request, $service = null, $action = null)
    {
        if($service == 'chat'){
            exec("/usr/bin/php ".base_path('gatewayworker/start.php')." restart -d >> /dev/null");
            return redirect()->route('admin.server')->with(['status'=>'重启聊天服务成功']);
        }elseif ($service == 'robot'){
            exec('/usr/bin/php '.base_path('artisan').' workerman:client restart --daemonize >> /dev/null');
            return redirect()->route('admin.server')->with(['status'=>'重启机器人服务成功']);
        }

        return view('admin.server');
    }

}
