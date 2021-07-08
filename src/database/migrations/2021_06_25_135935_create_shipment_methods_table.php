<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipmentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipment_methods', function (Blueprint $table) {
            $table->id();

            $table->enum('type', ['auto', 'manual']);
            $table->string('supplier');

            $table->string('merchant_id')->nullable();
            
            $table->string('public_key')->nullable();
            $table->string('private_key')->nullable();

            $table->string('email_access')->nullable();
            $table->string('password_access')->nullable();

            $table->boolean('sandbox_mode')->default(true)->nullable();

            $table->boolean('is_active')->nullable();

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
        Schema::dropIfExists('shipment_methods');
    }
}
