<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();

            $table->string('code');
            $table->text('description')->nullable();

            $table->enum('type', ['percentage_amount', 'fixed_amount', 'free_shipping']);
            $table->string('qty')->nullable()->default('1');

            $table->boolean('is_free_shipping')->nullable();
            
            // Minimum Requierements
            $table->enum('minimum_requirements', ['none', 'min_amount', 'min_products'])->nullable();
            $table->string('minimum_requirements_value')->nullable();

            /* Usage Restrictions */
            $table->boolean('individual_use')->nullable();
            $table->boolean('exclude_discounted_items')->nullable();

            /* Limit Restrictions */
            $table->string('usage_limit_per_code')->nullable();
            $table->string('usage_limit_per_user')->nullable();

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

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
        Schema::dropIfExists('coupons');
    }
}
