<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channels', function (Blueprint $table) {
            $table->id();

            $table->string('supplier');

            $table->string('public_key')->nullable();
            $table->string('private_key')->nullable();

            $table->string('email_access')->nullable();
            $table->string('password_access')->nullable();
            $table->string('sandbox_email_access')->nullable();
            $table->string('sandbox_password_access')->nullable();

            $table->boolean('sandbox_mode')->default(false)->nullable();
            $table->string('sandbox_public_key')->nullable();
            $table->string('sandbox_private_key')->nullable();

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
        Schema::dropIfExists('channels');
    }
}
