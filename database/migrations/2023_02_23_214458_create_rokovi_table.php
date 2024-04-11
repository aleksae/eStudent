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
        Schema::create('rokovi', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('naziv');
            $table->string('naziv_skraceno');
            $table->dateTime('pocetak_prijave');
            $table->dateTime('kraj_prijave');
            $table->dateTime('pocetka_roka');
            $table->dateTime('kraj_roka');

            $table->boolean('ispitni');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rokovi');
    }
};
