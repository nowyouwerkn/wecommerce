<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSEOSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_e_o_s', function (Blueprint $table) {
            $table->id();

            /* Page General Configuration */
            $table->string('page_title')->nullable();
            $table->text('page_description')->nullable();
            $table->text('page_keywords')->nullable();

            /* Page SEO Options */
            $table->string('page_canonical_url')->nullable();
            $table->string('page_alternate_url')->nullable();
            $table->string('page_theme_color_hex')->nullable();

            /* Page OG SEO Options */
            $table->string('page_og_type')->nullable();
            $table->string('page_og_logo_url')->nullable();

            /* Page Google Analytics Options */
            $table->text('page_google_analytics_code')->nullable();
            
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
        Schema::dropIfExists('s_e_o_s');
    }
}
