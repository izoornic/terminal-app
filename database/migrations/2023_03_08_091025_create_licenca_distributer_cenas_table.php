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
        Schema::create('licenca_distributer_cenas', function (Blueprint $table) {
            $table->id();
            $table->integer('distributerId');
            $table->integer('licenca_tipId');
            $table->decimal('licenca_zeta_cena', 13, 2);
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
        Schema::dropIfExists('licenca_distributer_cenas');
    }
};
