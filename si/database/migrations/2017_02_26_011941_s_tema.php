<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class STema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_tema', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',45)->unique();
            $table->string('nombre_usuario',50);
            $table->string('nombre_administrador',50);
            $table->string('nombre_logueo',50);
        });

        $clase = new s_tema();
        $clase->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('s_tema');
    }
}
