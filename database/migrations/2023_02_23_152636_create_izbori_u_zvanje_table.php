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
        Schema::create('izbori_u_zvanje', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('id_nastavnika');
            $table->integer('id_zvanja');
            $table->string('naucna_oblast');
            $table->string('strucno_zvanje');
            $table->date('datum_izbora');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('izbori_u_zvanje');
    }
};
