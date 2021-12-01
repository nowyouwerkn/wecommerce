<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('legal_texts', function (Blueprint $table) {
            $table->string('title')->after('type')->nullable();
        });

        Schema::table('variants', function (Blueprint $table) {
            $table->string('UPC')->after('type');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->string('coupon_id')->after('payment_id');
            $table->string('shipment_option_id')->after('coupon_id');
        });

        Schema::table('payment_methods', function (Blueprint $table) {
            $table->string('sandbox_merchant_id')->after('merchant_id')->nullable();
            $table->string('sandbox_email_access')->after('password_access')nullable();
            $table->string('sandbox_password_access')->after('sandbox_email_access')->nullable();

            $table->boolean('sandbox_mode')->after('sandbox_password_access')->default(false)->nullable();
            $table->string('sandbox_public_key')->after('sandbox_mode')->nullable();
            $table->string('sandbox_private_key')->after('sandbox_public_key')->nullable();
            $table->string('mercadopago_oxxo')->after('sandbox_private_key')->nullable();
            $table->string('mercadopago_paypal')->after('mercadopago_paypal')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('legal_texts', function (Blueprint $table) {
            $table->dropColumn('title');
        });

        Schema::table('variants', function (Blueprint $table) {
            $table->dropColumn('UPC');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('coupon_id');
            $table->dropColumn('shipment_option_id');
        });

        Schema::table('payment_methods', function (Blueprint $table) {
            $table->dropColumn('sandbox_merchant_id');
            $table->dropColumn('sandbox_email_access');
            $table->dropColumn('sandbox_password_access');
            $table->dropColumn('sandbox_mode');
            $table->dropColumn('sandbox_public_key');
            $table->dropColumn('sandbox_private_key');
            $table->dropColumn('mercadopago_oxxo');
            $table->dropColumn('mercadopago_paypal');
        });
    }
}
