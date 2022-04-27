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
        Schema::create('tiket_opis_akcija_indices', function (Blueprint $table) {
            $table->id();
            $table->integer('tiket_opis_kvaraId');
            $table->integer('tiket_kvar_akcijaId');
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
        Schema::dropIfExists('tiket_opis_akcija_indices');
    }
};
