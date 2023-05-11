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
        Schema::create('licence_za_terminals', function (Blueprint $table) {
            $table->id();
            $table->integer('terminal_lokacijaId');
            $table->integer('distributerId');
            $table->integer('licenca_distributer_cenaId');
            $table->integer('mesecId');
            $table->string('terminal_sn', 24);
            $table->date('datum_pocetak');
            $table->date('datum_kraj');
            $table->date('datum_prekoracenja');
            $table->text('signature');
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
        Schema::dropIfExists('licence_za_terminals');
    }
};
