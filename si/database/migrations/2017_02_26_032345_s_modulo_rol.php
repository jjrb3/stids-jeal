<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SModuloRol extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_modulo_rol', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_rol')->unsigned();
            $table->integer('id_modulo')->unsigned();
            $table->foreign('id_rol')->references('id')->on('s_rol');
            $table->foreign('id_modulo')->references('id')->on('s_modulo');
        });

        $clase = new s_modulo_rol();
        $clase->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('s_modulo_rol');
    }
}
