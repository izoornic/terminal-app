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
        Schema::create('tiket_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('tiketId');
            $table->integer('tremina_lokacijalId');
            $table->integer('tiket_statusId');
            $table->integer('opis_kvaraId')->nullable();
            $table->integer('korisnik_prijavaId')->nullable();
            $table->integer('korisnik_dodeljenId')->nullable();
            $table->text('opis');
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
        Schema::dropIfExists('tiket_histories');
    }
};
