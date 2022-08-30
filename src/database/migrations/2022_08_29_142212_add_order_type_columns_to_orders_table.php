<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderTypeColumnsToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('type')->after('id')->default('single_payment')->nullable();
            $table->boolean('suscription_status')->after('status')->nullable();

            $table->integer('suscription_id')->after('cart')->nullable();

            $table->string('stripe_subscription_id')->after('payment_id')->nullable();
            $table->string('stripe_customer_id')->after('client_name')->nullable();
            $table->string('stripe_plan_id')->after('payment_id')->nullable();

            $table->datetime('subscription_period_start')->after('status')->nullable();
            $table->datetime('subscription_period_end')->after('status')->nullable();
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
            $table->dropColumn('type');
            $table->dropColumn('subscription_status');
            $table->dropColumn('stripe_subscription_id');
            $table->dropColumn('stripe_customer_id');
            $table->dropColumn('stripe_plan_id');
            $table->dropColumn('subscription_period_start');
            $table->dropColumn('subscription_period_end');
        });
    }
}
