<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SNivelConocimiento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_nivel_conocimiento', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_empresa')->unsigned();
            $table->string('nombre',50)->unique();
            $table->string('color',7);
            $table->double('porcentaje', 5, 2);
            $table->foreign('id_empresa')->references('id')->on('s_empresa');
        });

        $clase = new s_nivel_conocimiento();
        $clase->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('s_nivel_conocimiento');
    }
}
