<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SDepartamento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_departamento', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_pais')->unsigned();
            $table->string('nombre',150)->unique();
            $table->foreign('id_pais')->references('id')->on('s_pais');
        });

        $clase = new s_departamento();
        $clase->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('s_departamento');
    }
}
