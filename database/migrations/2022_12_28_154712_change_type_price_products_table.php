<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->bigInteger('supplier_id')->unsigned()->nullable()->change();
            $table->string('status')->nullable()->change();
            $table->bigInteger('cost')->nullable()->change();
            $table->integer('sale_off')->nullable()->change();
            $table->bigInteger('sale_price')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
};