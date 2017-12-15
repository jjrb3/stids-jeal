<?php

use Illuminate\Database\Seeder;

class s_municipio extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('s_municipio')->insert(array(
		   'id' => 1,
		   'id_departamento' => 1,
		   'nombre' => 'Barranquilla',
		));
		DB::table('s_municipio')->insert(array(
		   'id' => 2,
		   'id_departamento' => 1,
		   'nombre' => 'Soledad',
		));
	}
}
