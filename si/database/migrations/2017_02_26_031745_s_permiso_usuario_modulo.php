<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SPermisoUsuarioModulo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_permiso_usuario_modulo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_usuario')->unsigned();            
            $table->integer('id_modulo')->unsigned();            
            $table->integer('id_permiso')->unsigned();            
            $table->foreign('id_usuario')->references('id')->on('s_usuario');
            $table->foreign('id_modulo')->references('id')->on('s_modulo');
            $table->foreign('id_permiso')->references('id')->on('s_permiso');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('s_permiso_usuario_modulo');
    }
}
