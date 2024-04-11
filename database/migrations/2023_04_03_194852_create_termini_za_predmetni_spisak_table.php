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
        Schema::create('termini_za_predmetni_spisak', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('id_spisak');
            $table->datetime('vreme_pocetak');
            $table->datetime('vreme_kraj');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('termini_za_predmetni_spisak');
    }
};
