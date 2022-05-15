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
        Schema::create('tiket_akcija_korisnik_pozicijas', function (Blueprint $table) {
            $table->id();
            $table->integer('korisnik_pozicijaId');
            $table->integer('tiket_akcijaId');
            $table->integer('tiket_akcijavrednostId');
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
        Schema::dropIfExists('tiket_akcija_korisnik_pozicijas');
    }
};
