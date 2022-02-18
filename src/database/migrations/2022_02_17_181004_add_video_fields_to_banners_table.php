<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVideoFieldsToBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->boolean('is_promotional')->after('is_active')->default(false)->nullable();
            $table->string('image_responsive')->after('image')->nullable();

            $table->boolean('video_autoplay')->nullable()->default(false)->after('video_background');
            $table->boolean('video_controls')->nullable()->default(false)->after('video_background');
            $table->boolean('video_loop')->nullable()->default(false)->after('video_background');
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
            $table->dropColumn('video_autoplay');
            $table->dropColumn('video_controls');
            $table->dropColumn('video_loop');

            $table->dropColumn('is_promotional');
            $table->dropColumn('image_responsive');
        });
    }
}
