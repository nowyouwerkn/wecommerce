<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBannerTableFeatures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->string('video_background')->after('link')->nullable();
            $table->string('hex_text_title')->after('hex')->nullable();
            $table->string('hex_text_subtitle')->after('hex_text_title')->nullable();
            $table->string('hex_button')->after('hex_text_subtitle')->nullable();
            $table->string('hex_text_button')->after('hex_button')->nullable();
            $table->string('position')->after('hex_text_button')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn('video_background');
            $table->dropColumn('hex_text_title');
            $table->dropColumn('hex_text_subtitle');
            $table->dropColumn('hex_button');
            $table->dropColumn('hex_text_button');
            $table->dropColumn('position');
        });
    }
}
