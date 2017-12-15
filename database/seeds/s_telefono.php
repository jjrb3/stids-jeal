<?php

use Illuminate\Database\Seeder;

class s_telefono extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('s_telefono')->insert(array(
		   'id' => NULL,
		   'id_sucursal' => 1,
		   'telefono' => '(+57) 301 495 4136',
		));
        DB::table('s_telefono')->insert(array(
		   'id' => NULL,
		   'id_sucursal' => 1,
		   'telefono' => '(+57) 301 759 7689',
		));
    }
}
