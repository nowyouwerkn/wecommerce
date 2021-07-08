<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();

            $table->integer('user_id')->unsigned();
            $table->string('name');

            $table->string('phone')->nullable();

            /* Address */
            $table->string('street');
            $table->string('street_num');
            $table->string('country');
            $table->string('state');
            $table->string('city');
            $table->string('postal_code');
            $table->string('suburb')->nullable();
            $table->string('between_streets')->nullable();

            
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
        Schema::dropIfExists('user_addresses');
    }
}
