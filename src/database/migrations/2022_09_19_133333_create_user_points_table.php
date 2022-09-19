<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_points', function (Blueprint $table) {
            $table->id();

            $table->string('type'); //in o out
            $table->string('value'); // Valor en puntos
            $table->integer('order_id')->nullable(); // Orden relacionada
            $table->integer('user_id'); // Usuario relacionado
            $table->datetime('valid_until')->nullable(); //Fecha de validez

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
        Schema::dropIfExists('user_points');
    }
}
