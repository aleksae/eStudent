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
        Schema::create('predmet_pripada_grupi_za_biranje', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('sifra_predmeta');
            $table->integer('sifra_grupe');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('predmet_pripada_grupi_za_biranje');
    }
};
