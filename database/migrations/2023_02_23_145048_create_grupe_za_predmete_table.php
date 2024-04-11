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
        Schema::create('grupe_za_predmete', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('id_predmeta');
            $table->string('tip');
            $table->integer('broj');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grupe_za_predmete');
    }
};
