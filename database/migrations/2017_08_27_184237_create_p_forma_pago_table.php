<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePFormaPagoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_forma_pago', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion',50)->unique();
            $table->boolean('estado')->default(1);
        });

        $clase = new p_forma_pago();
        $clase->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p_forma_pago');
    }
}
