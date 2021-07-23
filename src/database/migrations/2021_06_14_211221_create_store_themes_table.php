<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreThemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_themes', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('url')->nullable();
            $table->string('image')->nullable();
            $table->string('description')->nullable();
            $table->string('version')->nullable();
            $table->boolean('is_active')->default(false);

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
        Schema::dropIfExists('store_themes');
    }
}
