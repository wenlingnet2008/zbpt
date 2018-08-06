<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::insert([
            [
                'name' => 'admin_login',
                'desc' => '后台登录',
                'guard_name' => 'web',
            ],
            [
                'name' => 'permission',
                'desc' => '权限管理',
                'guard_name' => 'web',
            ],
            [
                'name' => 'role',
                'desc' => '会员组管理',
                'guard_name' => 'web',
            ],
            [
                'name' => 'site_config',
                'desc' => '网站基本设置',
                'guard_name' => 'web',
            ],
            [
                'name' => 'order',
                'desc' => '喊单管理',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manage_user',
                'desc' => '会员管理',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manage_firewall',
                'desc' => 'IP屏蔽管理',
                'guard_name' => 'web',
            ],
            [
                'name' => 'kick',
                'desc' => '前台房间踢人,屏蔽IP',
                'guard_name' => 'web',
            ],
            [
                'name' => 'mute',
                'desc' => '前台房间禁止发言',
                'guard_name' => 'web',
            ],
            [
                'name' => 'unmute',
                'desc' => '前台房间解除禁言',
                'guard_name' => 'web',
            ],
            [
                'name' => 'room',
                'desc' => '房间管理',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manage_message',
                'desc' => '聊天信息管理',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manage_robots',
                'desc' => '机器人管理',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manage_server',
                'desc' => '服务重启管理',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manage_course',
                'desc' => '课程管理',
                'guard_name' => 'web',
            ],
            [
                'name' => 'front_view_user',
                'desc' => '前台查看用户',
                'guard_name' => 'web',
            ],
            [
                'name' => 'front_robot_say',
                'desc' => '前台机器人手动发言',
                'guard_name' => 'web',
            ],

        ]);
    }
}
