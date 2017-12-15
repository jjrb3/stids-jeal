<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class STelefono extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_telefono', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_sucursal')->unsigned();
            $table->string('telefono',20)->unique();
            $table->foreign('id_sucursal')->references('id')->on('s_sucursal');
        });

        $clase = new s_telefono();
        $clase->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('s_telefono');
    }
}
