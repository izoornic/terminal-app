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
        Schema::create('licenca_distributer_terminals', function (Blueprint $table) {
            $table->id();
            $table->integer('distributerId');
            $table->integer('terminal_lokacijaId');
            $table->integer('licenca_distributer_cenaId');
            $table->date('datum_pocetak');
            $table->date('datum_kraj');
            $table->integer('nenaplativ');
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
        Schema::dropIfExists('licenca_distributer_terminals');
    }
};
