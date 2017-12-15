<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePPrestamoDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_prestamo_detalle', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_empresa')->unsigned();
            $table->integer('id_cliente')->unsigned();
            $table->integer('id_prestamo')->unsigned();
            $table->integer('id_forma_pago')->unsigned();
            $table->integer('id_estado_pago')->unsigned();
            $table->string('no_cuota',10);
            $table->dateTime('fecha_pago')->nullable();
            $table->integer('monto_cuota');
            $table->integer('monto_pagado');
            $table->longText('observacion')->nullable();
            $table->boolean('estado')->default(1);
            $table->foreign('id_empresa')->references('id')->on('s_empresa');
            $table->foreign('id_cliente')->references('id')->on('p_cliente');
            $table->foreign('id_prestamo')->references('id')->on('p_prestamo');
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
        Schema::dropIfExists('p_prestamo_detalle');
    }
}
