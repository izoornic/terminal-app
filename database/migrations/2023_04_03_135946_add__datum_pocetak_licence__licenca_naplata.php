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
        Schema::table('licenca_naplatas', function (Blueprint $table) {
            //
            $table->date('datum_pocetka_licence')->nulable();
            $table->date('datum_kraj_licence')->nulable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('licenca_naplatas', function (Blueprint $table) {
            //
        });
    }
};
