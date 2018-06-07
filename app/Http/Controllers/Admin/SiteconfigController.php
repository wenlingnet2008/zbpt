<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SiteconfigController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:site_config');
    }

    public function index(){
        $site_configs = DB::table('site_configs')->get();
        $site_configs = $site_configs->pluck('value', 'name');
        $site_configs['logo'] = Storage::disk('uploads')->url($site_configs['logo']);
        $data['site_configs'] = $site_configs;

        return view('admin.siteconfig', $data);
    }



    public function update(Request $request)
    {
        $this->validate($request, [
            'logo' =>  ['nullable', 'image', 'max:2048'],
        ]);
        foreach($request->input('setting') as $name => $value){
            DB::table('site_configs')->where('name', $name)->update(['value' => $value]);
        }

        if($request->file('logo')){
            $logo = $request->file('logo')->store(date('Ymd'), 'uploads');
            DB::table('site_configs')->where('name', 'logo')->update(['value' => $logo]);
        }

        return back()->with(['status' => '更新成功']);
    }
}
