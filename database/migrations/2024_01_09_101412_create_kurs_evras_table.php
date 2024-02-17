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
        Schema::create('kurs_evras', function (Blueprint $table) {
            $table->id();
            $table->decimal('kupovni_kurs', 13, 4);
            $table->decimal('srednji_kurs', 13, 4);
            $table->decimal('prodajni_kurs', 13, 4);
            $table->date('datum_preuzimanja');
            $table->date('datum_kursa');
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
        Schema::dropIfExists('kurs_evras');
    }
};
