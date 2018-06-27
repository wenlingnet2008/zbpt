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

    public function __construct()
    {
        $this->middleware('permission:room');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = Room::with(['owner', 'teacher'])->paginate(20);
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
        //获取所有讲师
        $teachers = User::getAllTeacher();
        $data['teachers'] = $teachers;

        //获取所有代理商
        $owners = User::getAllOwner();
        $data['owners'] = $owners;



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
        if($request->filled('room.limit_groups')){
            $room_arr['limit_groups'] = implode("|", $request->input('room.limit_groups'));
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
        //获取所有讲师
        $teachers = User::getAllTeacher();
        $data['teachers'] = $teachers;

        $owners = User::getAllOwner();
        $data['owners'] = $owners;


        $roles = Role::where('id', '>', 1)->get();
        $data['roles'] = $roles;
        $room = Room::with(['roles', 'teacher', 'owner'])->findOrFail($id);

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

        $room->name = $request->input('room.name');
        $room->content = $request->input('room.content');
        if($request->file('room.logo')){
            $room->logo = $request->file('room.logo')->store(date('Ymd'), 'uploads');
        }
        $room->open = $request->input('room.open');
        $room->access_password = $request->input('room.access_password');
        $room->pc_code = $request->input('room.pc_code');
        $room->mobile_code = $request->input('room.mobile_code');
        $room->user_id = $request->input('room.user_id');
        $room->owner_id = $request->input('room.owner_id');
        $room->time_limit = $request->input('room.time_limit');
        $room->robot_open = $request->input('room.robot_open');
        $room->say_limit = $request->input('room.say_limit');
        if($request->filled('room.limit_groups')){
            $room->limit_groups = implode("|", $request->input('room.limit_groups'));
        }
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
