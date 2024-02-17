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
        Schema::create('dist_licenca_naplatas', function (Blueprint $table) {
            $table->id();
            $table->integer('terminal_lokacijaId');
            $table->integer('distributerId');
            $table->integer('licenca_distributer_cenaId');
            $table->integer('licenca_naplatasId')->nullable();
            $table->integer('dist_mesecId');
            $table->integer('dist_broj_dana');
            $table->decimal('dist_zaduzeno', 13, 2);
            $table->decimal('dist_razduzeno', 13, 2)->nullable();
            $table->date('dist_datum_pocetka_licence')->nullable();
            $table->date('dist_datum_kraj_licence')->nullable();
            $table->date('dist_datum_isteka_prekoracenja')->nullable();
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
        Schema::dropIfExists('dist_licenca_naplatas');
    }
};
