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
        Schema::table('licenca_distributer_tips', function (Blueprint $table) {
            //
            $table->string('distributer_tr', 32)->nullable();
            $table->string('distributer_banka', 64)->nullable();
            $table->string('distributer_tel', 16)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('licenca_distributer_tips', function (Blueprint $table) {
            //
        });
    }
};
