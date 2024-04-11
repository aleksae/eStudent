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
        Schema::create('drze_se', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('sifra_predmeta');
            $table->integer('id_modula');
            $table->integer('semestar');
            $table->char('status'); //obavezan, izborni
            $table->integer('id_smer');

            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drze_se');
    }
};
