<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $role = Role::create( ['name' => '管理员', 'type'=>'系统']);
        $role->givePermissionTo('admin_login');
        $role->givePermissionTo('role');
        $role->givePermissionTo('permission');
        Role::insert( ['id'=>2, 'name' => '普通会员', 'type'=>'系统', 'guard_name'=>'web']);
        Role::insert( ['id'=>5, 'name' => '游客', 'type'=>'系统', 'guard_name'=>'web']);
        Role::insert( ['id'=>6, 'name' => '讲师', 'type'=>'系统', 'guard_name'=>'web']);
        Role::insert( ['id'=>7, 'name' => '代理商', 'type'=>'系统', 'guard_name'=>'web']);
        Role::insert( ['id'=>8, 'name' => '客服', 'type'=>'系统', 'guard_name'=>'web']);
        Role::insert( ['id'=>9, 'name' => '机器人', 'type'=>'系统', 'guard_name'=>'web']);
    }
}
