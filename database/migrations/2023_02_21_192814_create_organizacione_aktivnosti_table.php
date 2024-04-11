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
        Schema::create('organizacione_aktivnosti', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('naziv');
            $table->datetime('pocetak');
            $table->datetime('kraj');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organizacione_aktivnosti');
    }
};
