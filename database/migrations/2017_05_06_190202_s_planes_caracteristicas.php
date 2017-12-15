<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SPlanesCaracteristicas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_planes_caracteristicas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_planes')->unsigned();
            $table->string('titulo',50);
            $table->string('descripcion',500);
            $table->foreign('id_planes')->references('id')->on('s_planes');
        });

        $clase = new s_planes_caracteristicas();
        $clase->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('s_planes_caracteristicas');
    }
}
