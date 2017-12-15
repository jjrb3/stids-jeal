<?php

use Illuminate\Database\Seeder;

class s_rol extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('s_rol')->insert(array(
		   'id' => 1,
		   'id_empresa' => 1,
		   'nombre' => 'Administrador',
		   'estado' => 1,
		));
        DB::table('s_rol')->insert(array(
		   'id' => 2,
		   'id_empresa' => 1,
		   'nombre' => 'Usuario',
		   'estado' => 1,
		));
        DB::table('s_rol')->insert(array(
		   'id' => 3,
		   'id_empresa' => 1,
		   'nombre' => 'Soporte',
		   'estado' => 1,
		));
    }
}
