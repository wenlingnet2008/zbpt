<?php

namespace App\Http\Controllers\Admin;

use App\Course;
use App\Room;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:manage_course');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::with(['room'])->get();
        $data['courses'] = $courses;

        return view('admin.courses.index', $data);
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

        return view('admin.courses.create', $data);
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
            'course.name' => ['required'],
            'course.room_id' => ['required', 'integer', 'min:1'],
            'course.content' => ['required'],
        ]);

        $course_arr = $request->input('course');

        Course::create($course_arr);

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
        $course = Course::findOrFail($id);
        $data['course'] = $course;
        $rooms = Room::get();
        $data['rooms'] = $rooms;

        return view('admin.courses.edit', $data);
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
            'course.name' => ['required'],
            'course.room_id' => ['required', 'integer', 'min:1'],
            'course.content' => ['required'],
        ]);

        $course = Course::findOrFail($id);

        $course_arr = $request->input('course');

        $course->fill($course_arr);
        $course->save();

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
        $course = Course::findOrFail($id);
        $course->delete();

        return response()->json(['message'=>'删除成功']);
    }
}
