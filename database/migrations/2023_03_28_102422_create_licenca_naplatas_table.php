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
        Schema::create('licenca_naplatas', function (Blueprint $table) {
            $table->id();
            $table->integer('terminal_lokacijaId');
            $table->integer('distributerId');
            $table->integer('licenca_distributer_cenaId');
            $table->integer('mesecId');
            $table->integer('broj_dana');
            $table->decimal('zaduzeno', 13, 2);
            $table->decimal('razduzeno', 13, 2)->nulable();
            $table->date('datum_isteka_prekoracenja')->nulable();
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
        Schema::dropIfExists('licenca_naplatas');
    }
};
