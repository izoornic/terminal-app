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
        Schema::create('licenca_distributer_mesecs', function (Blueprint $table) {
            $table->id();
            $table->integer('distributerId');
            $table->integer('mesecId');
            $table->decimal('sum_zaduzeno', 13, 2);
            $table->date('datum_zaduzenja');
            $table->integer('predracun_email');
            $table->string('predracun_pdf', 256);
            $table->decimal('sum_razaduzeno', 13, 2)->nulable();
            $table->date('datum_razaduzenja')->nulable();
            $table->integer('racun_email')->nulable();
            $table->string('racun_pdf', 256)->nulable();
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
        Schema::dropIfExists('licenca_distributer_mesecs');
    }
};
