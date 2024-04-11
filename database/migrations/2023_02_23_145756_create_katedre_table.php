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
        Schema::create('katedre', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('naziv');
            $table->integer('id_sef')->nullable();
            $table->integer('id_zamenik')->nullable();
            $table->integer('id_sekretar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('katedre');
    }
};
