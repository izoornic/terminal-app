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
            $table->integer('broj_licenci');
            $table->integer('broj_terminala');
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
