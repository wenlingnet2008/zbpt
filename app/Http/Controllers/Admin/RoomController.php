<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RoomRequest;
use App\Room;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = Room::paginate(20);
        $data['rooms'] = $rooms;
        return view('admin.rooms.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('id', '>', 1)->get();
        $data['roles'] = $roles;

        $teachers = User::whereHas('roles',function ($query) {
            $query->where('id', 6);
        })->get();
        $data['teachers'] = $teachers;

        return view('admin.rooms.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoomRequest $request)
    {
        $room_arr = $request->input('room');
        if($request->file('room.logo')){
            $room_arr['logo'] = $request->file('room.logo')->store(date('Ymd'), 'uploads');
        }
        $room = Room::create($room_arr);

        $room->syncRoles($request->input('roles'));

        return back()->with(['status'=>'添加成功']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $teachers = User::whereHas('roles',function ($query) {
            $query->where('id', 6);
        })->get();
        $data['teachers'] = $teachers;
        $roles = Role::where('id', '>', 1)->get();
        $data['roles'] = $roles;
        $room = Room::with(['roles', 'teacher'])->findOrFail($id);
        $data['room'] = $room;
        $data['room_roles'] = $room->roles->pluck('name')->toArray();


        return view('admin.rooms.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoomRequest $request, $id)
    {
        $room = Room::findOrFail($id);

        $room->name = $request->input('room.content');
        $room->content = $request->input('room.content');
        if($request->file('room.logo')){
            $room->logo = $request->file('room.logo')->store(date('Ymd'), 'uploads');
        }
        $room->open = $request->input('room.open');
        $room->access_password = $request->input('room.access_password');
        $room->pc_code = $request->input('room.pc_code');
        $room->mobile_code = $request->input('room.mobile_code');
        $room->user_id = $request->input('room.user_id');
        $room->save();

        $room->syncRoles($request->input('roles'));

        return back()->with(['status'=>'更新成功']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
