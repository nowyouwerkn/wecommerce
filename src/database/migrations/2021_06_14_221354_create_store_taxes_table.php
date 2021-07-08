<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_taxes', function (Blueprint $table) {
            $table->id();

            $table->integer('country_id');
            $table->integer('parent_tax_id')->nullable();

            $table->string('tax_rate');
            $table->string('description')->nullable();
            $table->string('option')->nullable();

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
        Schema::dropIfExists('store_taxes');
    }
}
