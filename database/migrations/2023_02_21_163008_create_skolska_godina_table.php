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
        Schema::create('skolska_godina', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('naziv');
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
        Schema::dropIfExists('skolska_godina');
    }
};
