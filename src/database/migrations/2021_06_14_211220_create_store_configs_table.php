<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_configs', function (Blueprint $table) {
            $table->id();

            // Store Config
            $table->boolean('install_completed')->default(false);

            $table->string('store_name')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('sender_email')->nullable();
            $table->string('store_industry')->nullable();

            $table->text('google_analytics')->nullable();
            $table->text('facebook_pixel')->nullable();

            // Contact Information
            $table->string('rfc_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('street')->nullable();
            $table->string('street_num')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            
            // Standard Measures
            $table->string('timezone')->nullable();
            $table->enum('unit_system', ['Sistema Métrico', 'Sistema Imperial']);
            $table->enum('weight_system', ['Kilogramos (Kg)', 'Gramos (g)', 'Libra (Lb)', 'Onza (oz)']);
            $table->integer('currency_id')->nullable();

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
        Schema::dropIfExists('store_configs');
    }
}
