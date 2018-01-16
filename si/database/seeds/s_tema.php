<?php

use Illuminate\Database\Seeder;

class s_tema extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('s_tema')->insert(array(
		   'id' => 1,
		   'nombre' => 'stids',
		   'nombre_usuario' => 'stids_usuario',
		   'nombre_administrador' => 'stids_administrador',
		   'nombre_logueo' => 'stids_logueo',
		));
	}
}
