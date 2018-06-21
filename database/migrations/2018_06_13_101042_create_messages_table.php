<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index()->comment('发言用户');
            $table->string('user_name')->comment('用户名称');
            $table->integer('to_user_id')->default(0)->index()->comment('私聊的用户 0:发言用户是公聊');
            $table->string('to_user_name')->nullalbe()->comment('私聊的用户名称');
            $table->integer('room_id')->comment('所属房间');
            $table->text('content')->comment('发言的内容');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
