<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToSizeChartsAndCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('size_charts', function (Blueprint $table) {
            $table->string('value')->after('category_id')->nullable();
            $table->string('name')->after('category_id')->nullable();

            $table->integer('parent_id')->after('id')->unsigned()->nullable();
            $table->string('image')->after('id')->nullable();
        });

        Schema::table('coupons', function (Blueprint $table) {
            $table->integer('made_for_user')->after('code')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('size_charts', function (Blueprint $table) {
            $table->dropColumn('image');
            $table->dropColumn('parent_id');
            $table->dropColumn('value');
            $table->dropColumn('name');
        });

        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn('made_for_user');
        });
    }
}
