<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 30)->unique();
            $table->string('password');

            $table->string('email', 150)->nullable();
            $table->string('nick_name')->nullable()->comment('昵称');
            $table->string('image')->nullable()->comment('用户头像');
            $table->string('mobile', 11)->nullable();
            $table->string('qq', 20)->nullable();
            $table->string('weixin', 30)->nullable();
            $table->string('true_name', 30)->nullable()->comment('真实姓名');
            $table->string('invite_code', 128)->nullable()->comment('邀请码');
            $table->string('area_name', 20)->nullable()->comment('地区');
            $table->boolean('forbid_talk')->default(0)->comment('禁止发言');
            $table->boolean('is_admin')->default(0)->comment('1:超级管理员 0:非超级管理员');
            $table->unsignedInteger('room_id')->default(0)->index()->comment('所属房间');
            $table->text('introduce')->nullable();

            $table->rememberToken();
            $table->timestamps();

            //$table->foreign('room_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
