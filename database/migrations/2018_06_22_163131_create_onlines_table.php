<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOnlinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('onlines', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id', 30)->unique()->comment('注册用户，游客 ID');
            $table->integer('online_time')->comment('当天在线时间');
            $table->integer('total_time')->comment('在线时间');
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
        Schema::dropIfExists('onlines');
    }
}
