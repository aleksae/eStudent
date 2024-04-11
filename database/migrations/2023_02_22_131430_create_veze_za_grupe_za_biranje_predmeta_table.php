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
        Schema::create('veze_za_grupe_za_biranje_predmeta', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('id_grupa1');
            $table->integer('id_grupa2');
            $table->integer('min');
            $table->integer('max');
            $table->longtext('poruka');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('veze_za_grupe_za_biranje_predmeta');
    }
};
