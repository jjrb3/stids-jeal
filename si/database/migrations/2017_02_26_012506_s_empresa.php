<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SEmpresa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_empresa', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_tema')->unsigned();
            $table->string('nit',20)->nullable()->unique();
            $table->string('nombre_cabecera',50)->nullable();
            $table->string('nombre',30)->unique();
            $table->string('frase',100)->nullable();
            $table->string('imagen_logo',50)->nullable();
            $table->boolean('estado')->default(1);
            $table->foreign('id_tema')->references('id')->on('s_tema');
        });

        $clase = new s_empresa();
        $clase->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('s_rol');
        Schema::dropIfExists('s_empresa');
    }
}
