<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->integer('client_id');
            $table->date('delivery_date');
            $table->integer('store_id');
            $table->integer('product_id');
            $table->string('size');
            $table->string('flavor');
            $table->integer('quantity_ordered');
            $table->double('ordered_total_price', 8, 2);
            $table->integer('quantity_received');
            $table->double('received_total_price', 8, 2);
            $table->boolean('is_replacement');
            $table->boolean('is_approved');
            $table->boolean('is_cancelled');
            $table->boolean('is_rescheduled');
            $table->boolean('is_completed');
            $table->integer('attempt');
            $table->string('reason');
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
        Schema::dropIfExists('orders');
    }
}
