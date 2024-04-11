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
        Schema::create('nastavnici', function (Blueprint $table) {
           
            $table->timestamps();
            $table->integer('id_korisnik');
            $table->integer('id_katedra');
            $table->string('zvanje');
            $table->integer('id_prostorija');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nastavnici');
    }
};
