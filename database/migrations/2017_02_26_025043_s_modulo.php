<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SModulo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_modulo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_padre')->nullable();
            $table->string('nombre',100);
            $table->string('descripcion',200)->nullable();
            $table->string('enlace_administrador',100)->nullable();
            $table->string('enlace_usuario',100)->nullable();
            $table->string('icono',50)->nullable();
            $table->integer('orden');
            $table->boolean('es_nuevo')->default(1);
            $table->boolean('estado')->default(1);
            $table->index(['id_padre', 'nombre']);
        });

        $clase = new s_modulo();
        $clase->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('s_modulo');
    }
}
