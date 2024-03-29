<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_inventory', function (Blueprint $table) {
            $table->id();

            $table->integer('branch_id')->unsigned();
            $table->integer('product_id')->unsigned();

            $table->string('stock')->nullable();
            $table->string('entry_stock')->nullable();
            $table->string('commited_stock')->nullable();

            $table->timestamps();
        });

        Schema::table('product_variants', function (Blueprint $table) {
            $table->string('branch_id')->after('id')->nullable();
            $table->string('entry_stock')->after('stock')->nullable();
            $table->string('commited_stock')->after('stock')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('branch_inventory');

        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropColumn('branch_id');
            $table->dropColumn('entry_stock');
            $table->dropColumn('commited_stock');
        });
    }
}
