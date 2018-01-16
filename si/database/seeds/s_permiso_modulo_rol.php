<?php

use Illuminate\Database\Seeder;

class s_permiso_modulo_rol extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		for ($i=1;$i<=13;$i++) {

			for ($j=1;$j<=5;$j++) {

				DB::table('s_permiso_modulo_rol')->insert(array(
				   'id' => NULL,
				   'id_modulo_rol' => $i,
				   'id_permiso' => $j,
				));
			}
		}	
	}
}
