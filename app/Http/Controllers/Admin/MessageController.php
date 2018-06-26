<?php

namespace App\Http\Controllers\Admin;

use App\Message;
use App\Room;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage_message');
    }

    public function index()
    {
        $messages = Message::with('room')->when(\request()->user()->isTeacher(), function($query){
                        $rooms = Room::where('user_id', \request()->user()->id)->pluck('id')->toArray();
                        return $query->where([
                            ['to_user_id' , '=', 0],
                        ])->whereIn('room_id', $rooms);
                    })->orderBy('id', 'desc')->paginate(100);
        $data['messages'] = $messages;

        return view('admin.messages.index', $data);
    }

    public function getNewMessages(Request $request){
        $id = $request->input('id');
        $messages = Message::with('room')->when(\request()->user()->isTeacher(), function($query) use($id){
            $rooms = Room::where('user_id', \request()->user()->id)->pluck('id')->toArray();
            return $query->where([
                ['to_user_id' , '=', 0],
            ])->whereIn('room_id', $rooms);
        })->where([
            ['id' , '>', $id],
        ])->orderBy('id', 'asc')->get();

        return response()->json(['data'=>$messages]);
    }
}
