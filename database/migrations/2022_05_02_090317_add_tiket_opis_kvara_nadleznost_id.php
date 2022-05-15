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
        Schema::table('tiket_opis_kvara_tips', function (Blueprint $table) {
            //
            $table->integer('tok_dodela_nadleznostiId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tiket_opis_kvara_tips', function (Blueprint $table) {
            //
        });
    }
};
