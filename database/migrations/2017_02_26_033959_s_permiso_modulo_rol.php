<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SPermisoModuloRol extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_permiso_modulo_rol', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_modulo_rol')->unsigned();
            $table->integer('id_permiso')->unsigned();
            $table->foreign('id_modulo_rol')->references('id')->on('s_modulo_rol');
            $table->foreign('id_permiso')->references('id')->on('s_permiso');
        });

        $clase = new s_permiso_modulo_rol();
        $clase->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('s_permiso_modulo_rol');
    }
}
