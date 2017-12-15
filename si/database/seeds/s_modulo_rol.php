<?php

use Illuminate\Database\Seeder;

class s_modulo_rol extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// Administrador todos los permisos
    	for ($i=1;$i<=13;$i++) {

			DB::table('s_modulo_rol')->insert(array(
			   'id' => $i,
			   'id_rol' => 1,
			   'id_modulo' => $i,
			));
		}
	}
    	
}
