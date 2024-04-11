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
        Schema::create('upisi', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('id_program');
            $table->integer('id_student');
            $table->integer('godina');
            $table->integer('id_sk');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('upisi');
    }
};
