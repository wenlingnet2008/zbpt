<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\OrderRequest;
use App\Order;
use App\OrderType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:order')->except(['show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with(['order_type', 'user'])
                        ->when(\request()->user()->isTeacher(), function($query){
                            return $query->where('user_id', \request()->user()->id);
                        })
                ->paginate(20);

        $data['orders'] = $orders;
        return view('admin.orders.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $order_types = OrderType::get();
        $data['order_types'] = $order_types;

        $roles = Role::where('id', '>', 1)->get();
        $data['roles'] = $roles;

        return view('admin.orders.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {

        $order_arr = $request->input('order');
        $order_arr['user_id'] = $request->user()->id;
        $order = Order::create($order_arr);

        if($request->filled('roles')){
            $order->syncRoles($request->input('roles'));
        }

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
        $order = Order::find($id);
        $this->authorize('view', $order);
        dd($order->toArray());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        $data['order'] = $order;
        $this->authorize('update', $order);

        $order_types = OrderType::get();
        $data['order_types'] = $order_types;

        $roles = Role::where('id', '>', 1)->get();
        $data['roles'] = $roles;




        $data['order_roles'] = $order->roles->pluck('name')->toArray();


        return view('admin.orders.edit', $data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OrderRequest $request, $id)
    {
        $order = Order::findOrFail($id);
        $this->authorize('update', $order);
        $order->type_id = $request->input('order.type_id');
        $order->doing = $request->input('order.doing');
        $order->open_price = $request->input('order.open_price');
        $order->stop_price = $request->input('order.stop_price');
        $order->earn_price = $request->input('order.earn_price');
        $order->position = $request->input('order.position');
        $order->profit_loss = $request->input('order.profit_loss');
        $order->save();

        if($request->filled('roles')){
            $order->syncRoles($request->input('roles'));
        }

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
        $order = Order::findOrFail($id);
        $this->authorize('delete', $order);
        $order->delete();
        return response()->json(['message'=>'删除成功']);
    }
}
