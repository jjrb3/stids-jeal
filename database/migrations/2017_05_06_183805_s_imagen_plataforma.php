<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SImagenPlataforma extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_imagen_plataforma', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_empresa')->unsigned();
            $table->integer('id_tipo_imagen')->unsigned();
            $table->string('titulo',100)->nullable();
            $table->string('descripcion',500)->nullable();
            $table->string('nombre_boton',50)->nullable();
            $table->string('enlace',50)->nullable();
            $table->string('posicion_horizontal',20)->nullable();
            $table->string('posicion_vertical',20)->nullable();
            $table->foreign('id_empresa')->references('id')->on('s_empresa');
            $table->foreign('id_tipo_imagen')->references('id')->on('s_tipo_imagen');
            $table->index(['id_empresa', 'id_tipo_imagen','titulo']);
        });

        $clase = new s_imagen_plataforma();
        $clase->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('s_imagen_plataforma');
    }
}
