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
        Schema::create('sale_za_termine_za_predmetni_spisak', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('id_termin');
            $table->integer('id_prostorija');
            $table->integer('kapacitet');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_za_termine_za_predmetni_spisak');
    }
};
