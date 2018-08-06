<?php

namespace App\Http\Controllers;

use App\LiveList;
use App\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    private $site;
    public function __construct()
    {
        $this->site = DB::table('site_configs')->pluck('value', 'name');
    }

    public function index()
    {

        $data['site'] = $this->site;
        return view('mobile.index', $data);
    }


    public function roomList()
    {

        $data['site'] = $this->site;

        $livelists = LiveList::with(['room'])->where('end_time', '>', date('Y-m-d H:i:s'))
                    ->get();

        $data['livelists'] = $livelists;

        return view('mobile.livelist', $data);
    }

    public function login()
    {
        $data['site'] = $this->site;


        return view('mobile.login', $data);
    }


    public function register()
    {
        $data['site'] = $this->site;


        return view('mobile.register', $data);

    }
}
