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
            $table->integer('licenca_dist_terminalId')->nullable();
            $table->date('datum_zaduzenja')->nullable();
            $table->date('datum_razduzenja')->nullable();
            $table->decimal('dist_zaduzeno', 13, 2)->nullable();
            $table->date('dist_datum_zaduzenja')->nullable();
            $table->decimal('dist_razduzeno', 13, 2)->nullable();
            $table->date('dist_datum_razduzenja')->nullable();

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
