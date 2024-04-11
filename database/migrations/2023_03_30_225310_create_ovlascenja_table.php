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
        Schema::create('ovlascenja', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('id_ovlastioca');
            $table->integer('id_ovlascenog');
            $table->string('ovlascenje');
            $table->date('pocetak');
            $table->date('kraj');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ovlascenja');
    }
};
