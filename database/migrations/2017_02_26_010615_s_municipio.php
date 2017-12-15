<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SMunicipio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_municipio', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_departamento')->unsigned();
            $table->string('nombre',150)->unique();
            $table->foreign('id_departamento')->references('id')->on('s_departamento');
        });

        $clase = new s_municipio();
        $clase->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('s_municipio');
    }
}
