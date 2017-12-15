<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class STipoIdentificacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_tipo_identificacion', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',50)->unique();
            $table->boolean('estado')->default(1);
        });

        $clase = new s_tipo_identificacion();
        $clase->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('s_tipo_identificacion');
    }
}
