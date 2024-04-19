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
        Schema::table('licenca_parametar_terminals', function (Blueprint $table) {
            //
            $table->integer('terminal_lokacijaId')->nullable();
            $table->integer('distributerId')->nullable();
            $table->integer('licenca_distributer_cenaId')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('licenca_parametar_terminals', function (Blueprint $table) {
            //
        });
    }
};
