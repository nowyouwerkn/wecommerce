<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToShipmentOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shipment_options', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });

        Schema::table('shipment_options', function (Blueprint $table) {
            $table->string('type')->after('name')->nullable();
            $table->text('location')->after('icon')->nullable();
            $table->boolean('is_active')->after('delivery_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shipment_options', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('location');
            $table->dropColumn('is_active');
        });

        Schema::table('shipment_options', function (Blueprint $table) {
            $table->boolean('is_active')->after('delivery_time');
        });
    }
}
