<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->integer('user_id');
            $table->text('cart');

            $table->string('sub_total')->nullable();
            $table->string('shipping_rate')->nullable();
            $table->string('tax_rate')->nullable();
            $table->string('discounts')->nullable();
            $table->string('total')->nullable();
            
            $table->string('cart_total')->nullable();

            $table->string('payment_total')->nullable();

            /* Address */
            $table->string('street');
            $table->string('street_num');
            $table->string('country');
            $table->string('state');
            $table->string('city');
            $table->string('postal_code');
            $table->string('suburb')->nullable();
            $table->string('between_streets')->nullable();

            $table->string('card_digits')->nullable();
            $table->string('references')->nullable();

            $table->string('phone');
            $table->string('client_name');
            $table->string('payment_id');

            $table->boolean('is_completed')->nullable();
            $table->string('status')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
