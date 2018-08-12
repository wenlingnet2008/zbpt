<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use App\Room;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use PragmaRX\Firewall\Vendor\Laravel\Facade as Firewall;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage_user');
        $this->middleware('fw-block-blacklisted')->only(['index']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $users = User::with('roles', 'room')->when(\request()->user()->isOwner(), function($query){
                        $room = Room::where('owner_id', \request()->user()->id)->first();
                        return $query->where('room_id', $room->id);
                    })->paginate(20);

        $data['users'] = $users;
        return view('admin.member.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::get();
        $data['roles'] = $roles;

        $rooms = Room::get();
        $data['rooms'] = $rooms;

        return view('admin.member.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        
        $user_arr = $request->input('user');
        $user_arr['password'] = bcrypt(md5($request->input('password')));

        if($request->file('user.image')){

            $user_arr['image'] = $request->file('user.image')->store(date('Ymd'), 'uploads');
            Image::make(public_path('storage/'.$user_arr['image']))->resize(100, 100)->save();
        }

        if(!$request->user()->isAdmin()){
            $room = Room::where('owner_id', $request->user()->id)->first();
            $user_arr['room_id'] = $room->id;
        }

        $user = User::create($user_arr);

        if(!$request->user()->isAdmin()){
            $user->syncRoles('普通会员');
        }else{
            $user->syncRoles($request->input('role'));
        }


        $role = Role::findByName($request->input('role'));
        if($role->id == 1){
            $user->is_admin = 1;
            $user->save();
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
        $user = User::findOrFail($id);
        //$user->image = Storage::disk('uploads')->url($user->image);
        $data['user'] = $user;
        $data['user_role'] = $user->roles->first();
        $roles = Role::get();
        $data['roles'] = $roles;

        $rooms = Room::get();
        $data['rooms'] = $rooms;

        return view('admin.member.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->syncRoles($request->input('role'));
        if($request->filled('password')){
            $user->password = bcrypt(md5($request->input('password')));
        }
        $user->name = $request->input('user.name');
        $user->mobile = $request->input('user.mobile');
        $user->introduce = $request->input('user.introduce');
        $user->room_id = $request->input('user.room_id');

        if($request->file('user.image')){
            $image = $request->file('user.image')->store(date('Ymd'), 'uploads');
            $user->image = $image;
            Image::make(public_path('storage/'.$image))->resize(100, null,function($constraint){
                $constraint->aspectRatio();
            })->save();
        }

        $role = Role::findByName($request->input('role'));
        if($role->id == 1){
            $user->is_admin = 1;
        }else{
            $user->is_admin = 0;
        }
        $user->save();

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
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message'=>'删除成功']);
    }
}
