<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeaderbandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('headerbands', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('text');
            $table->string('band_link')->nullable();
            $table->string('priority')->nullable();
            $table->string('hex_text')->nullable();
            $table->string('hex_background')->nullable();
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
        Schema::dropIfExists('headerbands');
    }
}
