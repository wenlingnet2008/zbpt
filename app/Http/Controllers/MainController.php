<?php

namespace App\Http\Controllers;

use App\LiveList;
use App\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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


    public function livelist()
    {
        $livelists = LiveList::with(['room'])->where('end_time', '>', date('Y-m-d H:i:s'))
            ->orderBy('start_time', 'asc')->get();

        $livelists->transform(function ($item, $key){
            $item->teacher = $item->room ? $item->room->teacher->name : '';
            $item->image = Storage::disk('uploads')->url($item->image);
            $item->url = route('room.index', ['id'=>$item->room_id]);
            return $item->only(['id','teacher', 'url', 'image', 'start_time', 'end_time', 'name']);
        });

        return response()->json($livelists);
    }


    public function roomList()
    {

        $data['site'] = $this->site;

        $livelists = LiveList::with(['room'])->where('end_time', '>', date('Y-m-d H:i:s'))
                    ->orderBy('start_time', 'asc')->get();

        $livelists->transform(function ($item, $key) {
            if(\Carbon\Carbon::now()->gte(\Carbon\Carbon::parse($item->start_time))){
               $item->onlive = true;
            }else{
                $item->onlive = false;
            }

            return $item;
        });


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
