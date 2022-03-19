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
        Schema::create('korisnik_radni_status_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('korisnik_radni_statusId');
            $table->integer('korisnikId');
            $table->integer('radni_statusId');
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
        Schema::dropIfExists('korisnik_radni_status_histories');
    }
};
