<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class SSexo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_sexo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',10)->unique();
            $table->boolean('estado')->default(1);
        });

        $clase = new s_sexo();
        $clase->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('s_sexo');
    }
}
