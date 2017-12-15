<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePClienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_cliente', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_empresa')->unsigned();
            $table->integer('id_tipo_identificacion')->unsigned();
            $table->string('identificacion',15);
            $table->string('nombres',60);
            $table->string('apellidos',60);
            $table->string('direccion',30);
            $table->string('telefono',20)->nullable();
            $table->string('celular',15);
            $table->boolean('estado')->default(1);
            $table->foreign('id_empresa')->references('id')->on('s_empresa');
            $table->foreign('id_tipo_identificacion')->references('id')->on('s_tipo_identificacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p_cliente');
    }
}
