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
        Schema::create('prostorije', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('id_zgrade');
            $table->string('pun_naziv');
            $table->string('skraceni_naziv');
            $table->string('lokacija');
            $table->string('opis');
            $table->integer('kapacitet');
            $table->integer('kapacitet_ispit')->nullable();
            $table->boolean('ispitna');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prostorije');
    }
};
