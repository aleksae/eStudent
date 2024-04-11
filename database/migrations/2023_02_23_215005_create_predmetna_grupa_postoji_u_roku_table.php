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
        Schema::create('predmetna_grupa_postoji_u_roku', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('id_grupe_za_predmete');
            $table->integer('id_ispitni_rok');
            $table->integer('id_predmetne_obaveze');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('predmetna_grupa_postoji_u_roku');
    }
};
