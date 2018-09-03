<?php

namespace App\Http\Controllers\Admin;

use App\Robot;
use App\Room;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class RobotController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:manage_robots');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $robots = Robot::paginate(20);
        $data['robots'] = $robots;

        return view('admin.robots.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rooms = Room::get();
        $data['rooms'] = $rooms;
        return view('admin.robots.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'robot.user_name' => ['required', 'max:30', 'unique:robots,user_name'],
            'rooms' => ['required'],
            'robot.up_time' => ['required'],
            'robot.end_time' => ['required'],
        ]);

        $robot_arr = $request->input('robot');
        if($request->file('robot.image')){
            $robot_arr['image'] = $request->file('robot.image')->store(date('Ymd'), 'uploads');
            Image::make(public_path('storage/'.$robot_arr['image']))->resize(100, 100)->save();
        }

        $robot_arr['user_id'] = uniqid('robot_');

        $robot = Robot::create($robot_arr);

        $rooms = Room::find($request->rooms);
        $robot->rooms()->saveMany($rooms);


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

        $rooms = Room::get();
        $data['rooms'] = $rooms;
        $robot = Robot::with('rooms')->findOrFail($id);
        //$robot->image = Storage::disk('uploads')->url($robot->image);
        $data['robot'] = $robot;

        return view('admin.robots.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'robot.user_name' => ['required', 'max:30', Rule::unique('robots', 'user_name')->ignore($id)],
            'rooms' => ['required'],
            'robot.up_time' => ['required'],
            'robot.end_time' => ['required'],
        ]);

        $robot = Robot::findOrFail($id);
        $robot_arr = $request->input('robot');
        if($request->file('robot.image')){
            $robot_arr['image'] = $request->file('robot.image')->store(date('Ymd'), 'uploads');
            Image::make(public_path('storage/'.$robot_arr['image']))->resize(100, 100)->save();
        }

        $robot->fill($robot_arr);
        $robot->save();

        $robot->rooms()->detach();
        $rooms = Room::find($request->rooms);
        $robot->rooms()->saveMany($rooms);

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
        $robot = Robot::findOrFail($id);
        $robot->delete();

        return response()->json(['message'=>'删除成功 ']);
    }
}
