<?php

use Illuminate\Database\Seeder;

class p_forma_pago extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('p_forma_pago')->insert(array(
            'id' => 1,
            'descripcion' => 'Diario',
            'estado' => 1,
        ));
        DB::table('p_forma_pago')->insert(array(
            'id' => 2,
            'descripcion' => 'Semanal',
            'estado' => 1,
        ));
        DB::table('p_forma_pago')->insert(array(
            'id' => 3,
            'descripcion' => 'Quincenal',
            'estado' => 1,
        ));
        DB::table('p_forma_pago')->insert(array(
            'id' => 4,
            'descripcion' => 'Mensual',
            'estado' => 1,
        ));
        DB::table('p_forma_pago')->insert(array(
            'id' => 5,
            'descripcion' => 'Trimestral',
            'estado' => 1,
        ));
        DB::table('p_forma_pago')->insert(array(
            'id' => 6,
            'descripcion' => 'Semestral',
            'estado' => 1,
        ));
        DB::table('p_forma_pago')->insert(array(
            'id' => 7,
            'descripcion' => 'Anual',
            'estado' => 1,
        ));
    }
}
