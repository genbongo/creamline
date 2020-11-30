<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeliveryDateColumnInTableProductReports extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_reports', function (Blueprint $table) {
            $table->date('delivery_date')->after('is_replaced');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_reports', function (Blueprint $table) {
            $table->dropColumn(['delivery_date']);
        });
    }
}
