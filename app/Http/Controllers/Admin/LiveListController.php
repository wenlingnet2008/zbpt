<?php

namespace App\Http\Controllers\Admin;

use App\LiveList;
use App\Room;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LiveListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['livelists'] = LiveList::with(['room'])->get();
        return view('admin.livelist.index', $data);
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

        return view('admin.livelist.create', $data);
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
            'live.name' => ['required'],
            'live.room_id' => ['required', 'integer', 'min:1'],
            'live.image' => ['required'],
            'live.start_time' => ['required'],
            'live.end_time' => ['required']
        ]);

        $live_arr = $request->live;

        if($request->file('live.image')){
            $live_arr['image'] = $request->file('live.image')->store(date('Ymd'), 'uploads');
        }

        LiveList::create($live_arr);

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
        $live = LiveList::findOrFail($id);
        $data['live'] = $live;

        $rooms = Room::get();
        $data['rooms'] = $rooms;

        return view('admin.livelist.edit', $data);


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
            'live.name' => ['required'],
            'live.room_id' => ['required', 'integer', 'min:1'],
            'live.start_time' => ['required'],
            'live.end_time' => ['required']
        ]);

        $live = LiveList::findOrFail($id);

        $live_arr = $request->live;

        if($request->file('live.image')){
            $live_arr['image'] = $request->file('live.image')->store(date('Ymd'), 'uploads');
        }

        $live->fill($live_arr);
        $live->save();

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
        $live = LiveList::findOrFail($id);

        $live->delete();

        return response()->json(['message'=>'删除成功']);
    }
}
