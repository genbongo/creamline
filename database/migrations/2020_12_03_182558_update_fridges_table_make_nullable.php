<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFridgesTableMakeNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fridges', function (Blueprint $table) {
            DB::statement('ALTER TABLE `fridges` MODIFY `user_id` VARCHAR(100) NULL;');
            DB::statement('ALTER TABLE `fridges` MODIFY `location` VARCHAR(100) NULL;');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fridges', function (Blueprint $table) {
            //
        });
    }
}
