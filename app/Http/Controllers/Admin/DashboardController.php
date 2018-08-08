<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use LaraMall\Admin\Sysinfo\Facades\Sysinfo;

class DashboardController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        return view('admin.index');
    }

    public function left()
    {
        return view('admin.left');
    }


    public function password(){
        return view('admin.password');
    }

    public function changePassword(Request $request){

        $this->validate($request, ['password' => 'required|confirmed|min:6', 'oldpassword'=>'required']);
        $user = \request()->user();
        if(Hash::check(md5($request->input('oldpassword')), $user->password)){
            $user->password = Hash::make(md5($request->input('password')));
            $user->setRememberToken(Str::random(60));
            $user->save();
        }else{
            return view('admin.error_notice')->withErrors(['oldpassword'=>'原有密码错误']);
        }

        return view('admin.error_notice')->with(['status' => '修改成功']);

    }

    public function main(Request $request){
        $user = $request->user();
        $role = $user->roles->first();
        $data['role'] = $role;
        $data['user'] = $user;


        $data['sysinfo'] = [
            'server' => Sysinfo::server(),
            'memory' => Sysinfo::memory(),
            'laraver' => Sysinfo::laraver(),
            'timezone' => Sysinfo::timezone(),
            'upload_max_filesize' => Sysinfo::upload_max_filesize(),
            'mysql' => last(DB::select('select version() as mysql_version'))->mysql_version,
            'php'   => Sysinfo::php(),
            'ip'    => Sysinfo::ip(),
            'webserver' => Sysinfo::webserver(),

        ];


        $site_name = DB::table('site_configs')->where('name', 'site_name')->first();
        $data['site_name'] = $site_name;

        return view('admin.dashboard', $data);
    }
}
