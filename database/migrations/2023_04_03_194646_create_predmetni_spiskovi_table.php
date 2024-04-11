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
        Schema::create('predmetni_spiskovi', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('id_drzanje');
            $table->integer('id_predmetna_grupa');
            $table->string('naziv');
            $table->string('poruka');
            $table->datetime('kraj_prijava');
            $table->integer('id_autor');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('predmetni_spiskovi');
    }
};
