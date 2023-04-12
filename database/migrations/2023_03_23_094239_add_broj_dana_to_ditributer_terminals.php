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
        Schema::table('licenca_distributer_terminals', function (Blueprint $table) {
            //
            $table->integer('licenca_broj_dana');
            $table->integer('auto_obnova')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('licenca_distributer_terminals', function (Blueprint $table) {
            //
        });
    }
};
