<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('room_number')->nullable()->unqiue()->comment('房间号, 现在还未用到，留作拓展');
            $table->string('name', 50)->comment('房间名称');
            $table->text('content')->nullable()->comment('房间介绍');
            $table->string('logo', 255)->nullable()->comment('Logo');
            $table->boolean('open')->defalut(1)->comment('房间状态 1:开启 0:关闭');
            $table->string('access_password', 50)->nullable()->comment('房间访问密码');
            $table->string('time_limit')->nullable()->comment('限时时间');
            $table->string('limit_groups')->nullable()->comment('限时访问组');
            $table->text('pc_code')->nullable()->comment('PC 端 直播代码');
            $table->text('mobile_code')->nullable()->comment('移动端直播代码');
            $table->unsignedInteger('online_service_id')->default(0)->comment('在线客服');
            $table->unsignedInteger('user_id')->comment('房间讲师');
            $table->unsignedInteger('owner_id')->default(0)->comment('房间的所有者, 代理商');
            $table->boolean('robot_open')->default(0)->comment('机器人 1:开启 0:关闭');
            $table->integer('say_limit')->default(60)->comment('每分钟发言的次数');

            //$table->foreign('online_service_id')->references('id')->on('online_services');

            //$table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rooms');
    }
}
