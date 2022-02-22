<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWkZipCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wk_zip_codes', function (Blueprint $table) {
            $table->id();

            $table->integer('country_id')->nullable()->unsigned();
            $table->string('int_code')->nullable();
            $table->string('zip_code');
            $table->string('suburb');
            $table->string('state');
            $table->string('municipality')->nullable();
            $table->string('city')->nullable();

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
        Schema::dropIfExists('wk_zip_codes');
    }
}
