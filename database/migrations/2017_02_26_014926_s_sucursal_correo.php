<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SSucursalCorreo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_sucursal_correo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_sucursal')->unsigned();
            $table->string('correo',60)->nullable();
            $table->foreign('id_sucursal')->references('id')->on('s_sucursal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('s_sucursal_correo');
    }
}
