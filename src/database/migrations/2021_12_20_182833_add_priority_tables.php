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
            $table->string('priority')->after('image')->nullable();
            });
         Schema::table('banners', function (Blueprint $table) {
            $table->string('priority')->after('link')->nullable();
            });
         Schema::table('legal_texts', function (Blueprint $table) {
            $table->string('priority')->after('description')->nullable();
            });
         Schema::table('user_addresses', function (Blueprint $table) {
            $table->string('references')->after('between_streets')->nullable();
            $table->boolean('is_billing')->after('references')->nullable();
            });
          Schema::table('orders', function (Blueprint $table) {
            $table->string('billing_shipping_id')->after('action_by')->after('shipping_option')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('priority');
        });
      Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn('priority');
        });
      Schema::table('legal_texts', function (Blueprint $table) {
            $table->dropColumn('priority');
        });
      Schema::table('user_addresses', function (Blueprint $table) {
            $table->dropColumn('references');
            $table->dropColumn('is_billing');
        });
      Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('billing_shipping_id');
        });
    }
}
