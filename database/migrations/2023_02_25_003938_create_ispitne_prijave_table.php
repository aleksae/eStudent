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
        Schema::create('ispitne_prijave', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('id_slusanje');
            $table->double('cena');
            $table->integer('sala');
            $table->integer('ocena');
            $table->boolean('potvrda_izlaska');
            $table->integer('id_obaveze');

            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ispitne_prijave');
    }
};
