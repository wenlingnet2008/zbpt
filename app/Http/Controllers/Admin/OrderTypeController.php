<?php

namespace App\Http\Controllers\Admin;

use App\OrderType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class OrderTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:order');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order_types = OrderType::get();
        $data['order_types'] = $order_types;
        return view('admin.orders.type_index', $data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.orders.type_create');
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
            'name' => ['required', 'max:100', 'unique:order_types,name'],
        ]);

        $order_type = new OrderType();
        $order_type->name = $request->input('name');
        $order_type->save();

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
        $data['order_type'] = OrderType::findOrFail($id);
        return view('admin.orders.type_create', $data);
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
            'name' => ['required', 'max:100', Rule::unique('order_types','name')->ignore($id)],
        ]);

        $order_type = OrderType::findOrFail($id);
        $order_type->name = $request->input('name');
        $order_type->save();


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
        $order_type = OrderType::findOrFail($id);
        $order_type->delete();

        return response()->json(['message'=>'删除成功']);
    }
}
