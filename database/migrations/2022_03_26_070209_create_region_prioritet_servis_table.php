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
        Schema::create('region_prioritet_servis', function (Blueprint $table) {
            $table->id();
            $table->integer('regionId');
            $table->integer('lokacija_p1Id');
            $table->integer('lokacija_p2Id')->nullable();
            $table->integer('lokacija_p3Id')->nullable();
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
        Schema::dropIfExists('region_prioritet_servis');
    }
};
