<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PragmaRX\Firewall\Vendor\Laravel\Facade as Firewall;

class FirewallController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:manage_firewall');
    }

    public function index()
    {
        $firewalls = DB::table('firewall')->get();
        $data['firewalls'] = $firewalls;
        return view('admin.firewall.index', $data);
    }



    public function store(Request $request)
    {
        $this->validate($request, [
            'ip_address' => ['required', 'max:39'],
        ]);

        Firewall::blacklist($request->input('ip_address'));

        return back()->with(['status'=>'添加成功']);
    }

    public function delete(Request $request)
    {
        $this->validate($request, [
            'ips' => ['required', 'array'],
        ], [
            'ips.required' => '选择要删除的ip',
        ]);

        foreach ($request->input('ips') as $ip){
            if (Firewall::whichList($ip) !== false)
            {
                Firewall::remove($ip);
            }
        }

        return back()->with(['status'=>'删除成功']);
    }
}
