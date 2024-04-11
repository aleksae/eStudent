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
        Schema::create('table_predmetne_obaveze', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('id_drzanje');
            $table->string('naziv');
            $table->integer('broj_poena');
            $table->integer('procenat_ocene');
            $table->boolean('jeste_ispit');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_predmetne_obaveze');
    }
};
