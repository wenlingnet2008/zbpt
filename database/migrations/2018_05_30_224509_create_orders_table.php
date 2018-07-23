<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('type_id');
            $table->boolean('doing')->comment('多空 1:做多 0:做空');
            $table->decimal('open_price', 10, 4)->comment('开仓价格');
            $table->decimal('stop_price', 10, 4)->comment('止损价格');
            $table->decimal('earn_price', 10, 4)->comment('止盈价格');
            $table->integer('position')->comment('仓位');
            $table->decimal('profit_loss', 10, 4)->default(0)->comment('盈亏');
            $table->unsignedInteger('room_id')->comment('所属房间');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('type_id')->references('id')->on('order_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
