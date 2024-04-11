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
        Schema::create('predmetne_obaveze', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('sifra_predmeta');
            $table->string('naziv');
            $table->integer('maks_broj_poena');
            $table->integer('procenat_u_ukupnoj_oceni');
            $table->integer('broj_prilika_za_polaganje');
            $table->longText('opis_pravila')->nullable();
            $table->integer('id_sk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('predmetne_obaveze');
    }
};
