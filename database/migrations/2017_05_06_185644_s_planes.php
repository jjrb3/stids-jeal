<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SPlanes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_planes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_empresa')->unsigned();
            $table->string('nombre',50)->unique();
            $table->string('descripcion',500)->nullable();
            $table->bigInteger('valor');
            $table->foreign('id_empresa')->references('id')->on('s_empresa');
        });

        $clase = new s_planes();
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
        Schema::dropIfExists('s_planes');
    }
}
