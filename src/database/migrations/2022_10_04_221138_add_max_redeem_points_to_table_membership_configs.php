<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMaxRedeemPointsToTableMembershipConfigs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('membership_configs', function (Blueprint $table) {
            $table->string('max_redeem_points')->after('point_value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('membership_configs', function (Blueprint $table) {
            $table->dropColumn('max_redeem_points');
        });
    }
}
