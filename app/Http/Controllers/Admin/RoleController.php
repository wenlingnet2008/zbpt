<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:role');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::get();
        $data['roles'] = $roles;

        return view('admin.roles.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::get();
        $data['permissions'] = $permissions;
        return view('admin.roles.create', $data);
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
            'role.name' => ['required'],
            'role.type' => ['required', Rule::in(['系统', '自定义'])],
        ]);

        $role = Role::create($request->input('role'));


        if($request->filled('permissions')){
            $permissions = $request->input('permissions');
            $role->givePermissionTo($permissions);
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
        $role = Role::find($id);
        $role_permissions =  $role->permissions;

        $permissions = Permission::get();

        $data['role'] = $role;
        $data['role_permissions'] = $role_permissions->pluck('name')->toArray();
        $data['permissions'] = $permissions;
        return view('admin.roles.edit', $data);
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

        $permissions = $request->input('permissions') ? $request->input('permissions') : [];
        $role = Role::findById($id);

        $role->syncPermissions($permissions);
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
        $role = Role::find($id);
        if($role->type == '系统'){
            return response()->json(['message'=>'系统用户组，无法删除']);
        }
        $role->delete();
        return response()->json(['message'=>'删除成功 ']);
    }
}
