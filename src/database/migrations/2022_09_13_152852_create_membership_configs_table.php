<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembershipConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('membership_configs', function (Blueprint $table) {
            $table->id();

            /*ESTADO DE MEMBRESIAS*/
            $table->boolean('is_active')->default(false);

            /*DATOS GENERALES*/
            $table->string('minimum_purchase')->nullable();
            $table->string('qty_for_points')->nullable();
            $table->string('earned_points')->nullable();
            $table->string('point_value')->nullable();

            /*DURACIÓN DE PUNTOS*/
            $table->boolean('has_expiration_time')->nullable()->default(false);
            $table->string('point_expiration_time')->nullable();

            $table->boolean('has_cutoff')->nullable()->default(false);
            $table->datetime('cutoff_date')->nullable();

            /*TIPOS DE CLIENTES*/
            $table->boolean('vip_clients')->nullable()->default(false);

            $table->boolean('has_vip_minimum_points')->nullable()->default(false);
            $table->string('vip_minimum_points')->nullable();

            $table->boolean('has_vip_minimum_orders')->nullable()->default(false);
            $table->string('vip_minimum_orders')->nullable();

            /*TIPO DE ADQUISIÓN DE PUNTOS*/
            $table->boolean('on_account_creation')->nullable()->default(false);
            $table->string('points_account_created')->nullable();

            $table->boolean('on_birthday')->nullable()->default(false);
            $table->string('points_birthdays')->nullable();

            $table->boolean('on_vip_account')->nullable()->default(false);
            $table->string('points_vip_accounts')->nullable();

            $table->boolean('on_review')->nullable()->default(false);
            $table->string('points_review')->nullable();

            $table->boolean('on_review_with_image')->nullable()->default(false);
            $table->string('points_review_with_image')->nullable();

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
        Schema::dropIfExists('membership_configs');
    }
}
