<?php

use Illuminate\Database\Seeder;

class s_departamento extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('s_departamento')->insert(array(
           'id' => 1,
           'id_pais' => 1,
           'nombre' => 'Atlántico',
    	));
    }
}
