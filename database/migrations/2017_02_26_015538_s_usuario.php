<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SUsuario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_usuario', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_empresa')->unsigned();
            $table->integer('id_tipo_identificacion')->unsigned();
            $table->integer('id_rol')->unsigned();
            $table->integer('id_municipio')->unsigned();
            $table->integer('id_sexo')->unsigned();
            $table->string('usuario',50)->unique();
            $table->string('clave',255);
            $table->string('no_documento',15);
            $table->string('nombres',100);
            $table->string('apellidos',100);
            $table->string('correo',80);
            $table->date('fecha_nacimiento')->nullable();
            $table->string('telefono',50)->nullable();
            $table->string('celular',50)->nullable();
            $table->boolean('estado')->default(1);
            $table->foreign('id_empresa')->references('id')->on('s_empresa');
            $table->foreign('id_tipo_identificacion')->references('id')->on('s_tipo_identificacion');
            $table->foreign('id_rol')->references('id')->on('s_rol');
            $table->foreign('id_municipio')->references('id')->on('s_municipio');
            $table->foreign('id_sexo')->references('id')->on('s_sexo');
        });

        $clase = new s_usuario();
        $clase->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('s_usuario');
    }
}
