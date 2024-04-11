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
        Schema::table('slusanje', function (Blueprint $table) {
            $table->integer('grupa_predavanja');
            $table->integer('grupa_vezbe');
            $table->integer('grupa_don');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('slusanje', function (Blueprint $table) {
            //
        });
    }
};
