<?php

use Illuminate\Database\Seeder;

class s_empresa_valores extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('s_empresa_valores')->insert(array(
		   'id' => NULL,
		   'id_empresa' => 1,
		   'nombre' => 'Comprometidos.',
		));
        DB::table('s_empresa_valores')->insert(array(
		   'id' => NULL,
		   'id_empresa' => 1,
		   'nombre' => 'Trabajo en equipo.',
		));
        DB::table('s_empresa_valores')->insert(array(
		   'id' => NULL,
		   'id_empresa' => 1,
		   'nombre' => 'Seguridad.',
		));
        DB::table('s_empresa_valores')->insert(array(
		   'id' => NULL,
		   'id_empresa' => 1,
		   'nombre' => 'Creativos.',
		));
        DB::table('s_empresa_valores')->insert(array(
		   'id' => NULL,
		   'id_empresa' => 1,
		   'nombre' => 'Respeto.',
		));
        DB::table('s_empresa_valores')->insert(array(
		   'id' => NULL,
		   'id_empresa' => 1,
		   'nombre' => 'Honestidad.',
		));
    }
}
