<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class STransacciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_transacciones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_empresa');
            $table->integer('id_usuario');
            $table->integer('id_permiso');
            $table->integer('id_modulo');
            $table->integer('id_alterado');
            $table->integer('nombre_tabla');
            $table->dateTime('fecha_alteracion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('s_transacciones');
    }
}
