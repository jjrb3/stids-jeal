<?php

use Illuminate\Database\Seeder;

class s_planes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('s_planes')->insert(array(
		   'id' => 1,
		   'id_empresa' => 1,
		   'nombre' => 'Básico',
		   'valor' => 750,
		   'descripcion' => NULL,
		));
        DB::table('s_planes')->insert(array(
		   'id' => 2,
		   'id_empresa' => 1,
		   'nombre' => 'Estándar',
		   'valor' => 950,
		   'descripcion' => NULL,
		));
        DB::table('s_planes')->insert(array(
		   'id' => 3,
		   'id_empresa' => 1,
		   'nombre' => 'Avanzado',
		   'valor' => 1400,
		   'descripcion' => NULL,
		));
        DB::table('s_planes')->insert(array(
		   'id' => 4,
		   'id_empresa' => 1,
		   'nombre' => 'Pro',
		   'valor' => 1800,
		   'descripcion' => NULL,
		));
    }
}
