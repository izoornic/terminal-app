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
        Schema::create('terminal_lokacija_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('terminal_lokacijaId');
            $table->integer('terminalId');
            $table->integer('lokacijaId');
            $table->integer('terminal_statusId');
            $table->integer('korisnikId');
            $table->string('korisnikIme', 128);
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
        Schema::dropIfExists('terminal_lokacija_histories');
    }
};
