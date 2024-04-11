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
        Schema::create('studenti', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('id_korisnika');
            $table->integer('indeks');
            $table->char('pol');
            $table->integer('telefon')->nullable();
            $table->integer('jmbg');
            $table->integer('job');
            $table->string('ime_roditelja');
            $table->date('datum_rodjenja');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('studenti');
    }
};
