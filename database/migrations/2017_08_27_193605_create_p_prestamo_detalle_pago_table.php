<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePPrestamoDetallePagoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_prestamo_detalle_pago', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_prestamo_detalle')->unsigned();
            $table->integer('id_estado_pago')->unsigned();
            $table->integer('monto_pagado');
            $table->longText('observacion')->nullable();
            $table->boolean('estado')->default(1);
            $table->foreign('id_prestamo_detalle')->references('id')->on('p_prestamo_detalle');
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
        Schema::dropIfExists('p_prestamo_detalle_pago');
    }
}
