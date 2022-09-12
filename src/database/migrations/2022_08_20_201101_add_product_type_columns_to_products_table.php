<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductTypeColumnsToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('terms_conditions')->after('materials')->nullable();
            $table->string('type')->after('id')->default('physical')->nullable();
            $table->string('payment_frecuency')->after('discount_price')->nullable();

            $table->string('image_file')->after('image')->nullable();
            $table->string('doc_file')->after('image')->nullable();
            $table->string('download_link')->after('image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('terms_conditions');
            $table->dropColumn('type');
            $table->dropColumn('payment_frecuency');
            $table->dropColumn('image_file');
            $table->dropColumn('doc_file');
            $table->dropColumn('download_link');
        });
    }
}
