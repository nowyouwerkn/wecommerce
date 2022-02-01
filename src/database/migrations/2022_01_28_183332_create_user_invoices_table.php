<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('image')->after('email')->nullable();
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->integer('user_id')->after('id')->unsigned()->nullable();
        });

        Schema::create('user_invoices', function (Blueprint $table) {
            $table->id();

            $table->string('invoice_request_num')->nullable();

            $table->integer('user_id');
            $table->integer('order_id');

            $table->string('rfc_num');
            $table->string('rfc_name')->nullable();
            $table->string('cfdi_use');

            $table->string('email')->nullable();

            $table->string('file_attachment')->nullable();
            $table->string('pdf_file')->nullable();
            $table->string('xml_file')->nullable();

            $table->string('status')->nullable()->default('En Proceso');

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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('image');
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });

        Schema::dropIfExists('user_invoices');
    }
}
