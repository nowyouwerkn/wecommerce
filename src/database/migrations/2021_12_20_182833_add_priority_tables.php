<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriorityTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('categories', function (Blueprint $table) {
            $table->string('priority')->nullable();
            });
         Schema::table('banners', function (Blueprint $table) {
            $table->string('priority')->nullable();
            });
         Schema::table('legal_texts', function (Blueprint $table) {
            $table->string('priority')->nullable();
            });
         Schema::table('user_addrasses', function (Blueprint $table) {
            $table->string('references')->nullable();
            $table->boolean('is_billing')->nullable();
            });
          Schema::table('orders', function (Blueprint $table) {
            $table->string('billing_shipping_id')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
