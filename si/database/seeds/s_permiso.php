<?php

use Illuminate\Database\Seeder;

class s_permiso extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('s_permiso')->insert(array(
		   'id' => 1,
		   'nombre' => 'Crear',
		   'estado' => 1,
		));
		DB::table('s_permiso')->insert(array(
		   'id' => 2,
		   'nombre' => 'Actualizar',
		   'estado' => 1,
		));
		DB::table('s_permiso')->insert(array(
		   'id' => 3,
		   'nombre' => 'Activar y desactivar',
		   'estado' => 1,
		));
		DB::table('s_permiso')->insert(array(
		   'id' => 4,
		   'nombre' => 'Eliminar',
		   'estado' => 1,
		));
		DB::table('s_permiso')->insert(array(
		   'id' => 5,
		   'nombre' => 'Exportar archivo',
		   'estado' => 1,
		));
		DB::table('s_permiso')->insert(array(
		   'id' => 6,
		   'nombre' => 'Importar archivo',
		   'estado' => 1,
		));
    }
}
