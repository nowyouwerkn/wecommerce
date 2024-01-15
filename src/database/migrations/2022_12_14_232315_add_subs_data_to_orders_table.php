<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubsDataToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('conekta_subscription_id')->after('stripe_subscription_id')->nullable();
            $table->string('customer_id')->after('stripe_customer_id')->nullable();
            $table->string('plan_id')->after('stripe_plan_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('subscription_id');
            $table->dropColumn('customer_id');
            $table->dropColumn('plan_id');
        });
    }
}
