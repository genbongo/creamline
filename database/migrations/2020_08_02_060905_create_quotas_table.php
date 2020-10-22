<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotas', function (Blueprint $table) {
            $table->id();
            $table->integer('year');
            $table->integer('jan');
            $table->integer('feb');
            $table->integer('mar');
            $table->integer('apr');
            $table->integer('may');
            $table->integer('jun');
            $table->integer('jul');
            $table->integer('aug');
            $table->integer('sep');
            $table->integer('oct');
            $table->integer('nov');
            $table->integer('dev');
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
        Schema::dropIfExists('quotas');
    }
}
