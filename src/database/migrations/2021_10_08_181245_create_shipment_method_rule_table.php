<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipmentMethodRuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipment_method_rules', function (Blueprint $table) {
            $table->id();

            $table->string('type')->nullable();
            $table->string('condition')->nullable();

            // Igual, Identico, No igual, No identico, Menos que, menos que o igual, mayor que, mayor que o igual
            $table->enum('comparison_operator', ['==', '===', '!=', '!===', '<', '<=', '>', '>='])->nullable();

            $table->string('value')->nullable();

            $table->boolean('allow_coupons')->nullable();
            $table->boolean('is_active')->default(true);

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
        Schema::dropIfExists('shipment_method_rules');
    }
}
