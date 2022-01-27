<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductRelationshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_relationships', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->string('value')->nullable();
            $table->string('hex_color')->nullable();
            $table->integer('product_id')->unsigned()->nullable();
            $table->integer('base_product_id')->unsigned()->nullable();
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
        Schema::dropIfExists('product_relationships');
    }
}
