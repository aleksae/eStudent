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
        Schema::create('predmeti', function (Blueprint $table) {
            $table->string('sifra')->primary();
            $table->timestamps();
            $table->string('naziv');
            $table->string('fond_casova');
            $table->string('tip_studija');

            $table->integer('espb');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('predmeti');
    }
};
