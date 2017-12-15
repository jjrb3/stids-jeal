<?php

use Illuminate\Database\Seeder;

class s_tipo_identificacion extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('s_tipo_identificacion')->insert(array(
		   'id' => 1,
		   'nombre' => 'Cédula de Ciudadania',
		   'estado' => 1,
		));
		DB::table('s_tipo_identificacion')->insert(array(
		   'id' => 2,
		   'nombre' => 'Documento de Identidad',
		   'estado' => 1,
		));
		DB::table('s_tipo_identificacion')->insert(array(
		   'id' => 3,
		   'nombre' => 'NIT',
		   'estado' => 0,
		));
	}
}
