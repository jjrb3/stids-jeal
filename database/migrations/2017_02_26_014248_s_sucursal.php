<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SSucursal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_sucursal', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_empresa')->unsigned();
            $table->integer('id_municipio')->unsigned();
            $table->string('codigo',50);
            $table->string('nombre',100);
            $table->string('telefono',50)->nullable();
            $table->string('direccion',60)->nullable();
            $table->text('quienes_somos')->nullable();
            $table->text('que_hacemos')->nullable();
            $table->text('mision')->nullable();
            $table->text('vision')->nullable();
            $table->string('servicios',500)->nullable();
            $table->string('herramientas',500)->nullable();
            $table->string('porque_escogernos',1000)->nullable();
            $table->string('planes',500)->nullable();
            $table->string('clientes',1000)->nullable();
            $table->boolean('estado')->default(1);
            $table->foreign('id_municipio')->references('id')->on('s_municipio');
            $table->foreign('id_empresa')->references('id')->on('s_empresa');
            $table->index(['id_empresa', 'codigo']);
        });

        $clase = new s_sucursal();
        $clase->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('s_sucursal');
    }
}
