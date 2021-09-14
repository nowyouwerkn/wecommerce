<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInfoToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->enum('age_group', ['adult', 'all ages', 'teen', 'kids', 'toddler', 'infant', 'newborn'])->after('search_tags')->default('all ages')->nullable();
            $table->string('brand')->after('search_tags')->nullable();
            $table->enum('gender', ['male', 'female', 'unisex'])->after('search_tags')->default('unisex')->nullable();

            $table->enum('availability', ['in stock', 'out of stock', 'available for order', 'discontinued'])->after('search_tags')->default('in stock')->nullable();
            $table->enum('condition', ['new', 'refurbished', 'used'])->after('search_tags')->default('new')->nullable();
            $table->enum('visibility', ['published', 'staging', 'hidden', 'whitelist_only'])->after('search_tags')->nullable();

            // International Category System
            $table->string('product_type')->after('search_tags')->nullable();
            $table->string('fb_product_category')->after('search_tags')->nullable();
            $table->string('google_product_category')->after('search_tags')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('age_group');
            $table->dropColumn('brand');
            $table->dropColumn('gender');
            $table->dropColumn('availability');
            $table->dropColumn('visibility');
            $table->dropColumn('condition');
            $table->dropColumn('product_type');
            $table->dropColumn('fb_product_category');
            $table->dropColumn('google_product_category');
        });
    }
}
