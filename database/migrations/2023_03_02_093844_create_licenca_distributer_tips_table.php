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
        Schema::create('licenca_distributer_tips', function (Blueprint $table) {
            $table->id();
            $table->string('distributer_naziv', 256);
            $table->string('distributer_adresa', 256);
            $table->string('distributer_zip', 16);
            $table->string('distributer_mesto', 64);
            $table->string('distributer_email', 128);
            $table->string('distributer_pib', 16);
            $table->string('distributer_mb', 16);
            $table->string('broj_ugovora', 64);
            $table->date('datum_ugovora');
            $table->date('datum_kraj_ugovora');
            $table->integer('dani_prekoracenja_licence');      
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
        Schema::dropIfExists('licenca_distributer_tips');
    }
};
