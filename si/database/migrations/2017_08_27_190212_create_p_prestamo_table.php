<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePPrestamoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_prestamo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_empresa')->unsigned();
            $table->integer('id_cliente')->unsigned();
            $table->integer('id_forma_pago')->unsigned();
            $table->integer('id_estado_pago')->unsigned();
            $table->string('no_prestamo',10);
            $table->integer('monto_requerido');
            $table->float('intereses',8,2);
            $table->integer('cantidad',3);
            $table->integer('total_intereses');
            $table->integer('total');
            $table->integer('total_pagado');
            $table->dateTime('fecha_pago_inicial');
            $table->dateTime('fecha_ultimo_pago')->nullable();
            $table->longText('observacion')->nullable();
            $table->boolean('estado')->default(1);
            $table->foreign('id_empresa')->references('id')->on('s_empresa');
            $table->foreign('id_cliente')->references('id')->on('p_cliente');
            $table->foreign('id_forma_pago')->references('id')->on('p_forma_pago');
            $table->foreign('id_estado_pago')->references('id')->on('p_estado_pago');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p_prestamo');
    }
}
