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
        Schema::create('korisnik_radni_odnos_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('korisnik_radni_odnosId');
            $table->integer('korisnikId');
            $table->integer('radni_odnosId');
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
        Schema::dropIfExists('korisnik_radni_odnos_histories');
    }
};
