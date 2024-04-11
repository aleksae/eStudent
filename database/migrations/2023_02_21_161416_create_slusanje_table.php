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
        Schema::create('slusanje', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('id_drzanje');
            $table->integer('id_upis');
            $table->integer('put');
            $table->integer('cena')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slusanje');
    }
};
