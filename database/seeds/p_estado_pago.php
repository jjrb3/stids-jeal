<?php

use Illuminate\Database\Seeder;

class p_estado_pago extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('p_estado_pago')->insert(array(
            'id' => 1,
            'descripcion' => 'Mora',
            'estado' => 1,
        ));
        DB::table('p_estado_pago')->insert(array(
            'id' => 2,
            'descripcion' => 'Entregado',
            'estado' => 1,
        ));
        DB::table('p_estado_pago')->insert(array(
            'id' => 3,
            'descripcion' => 'Completado',
            'estado' => 1,
        ));
        DB::table('p_estado_pago')->insert(array(
            'id' => 4,
            'descripcion' => 'Autorizado',
            'estado' => 1,
        ));
        DB::table('p_estado_pago')->insert(array(
            'id' => 5,
            'descripcion' => 'Cancelado',
            'estado' => 1,
        ));
        DB::table('p_estado_pago')->insert(array(
            'id' => 6,
            'descripcion' => 'Rechazado',
            'estado' => 1,
        ));
        DB::table('p_estado_pago')->insert(array(
            'id' => 7,
            'descripcion' => 'En revisión',
            'estado' => 1,
        ));
        DB::table('p_estado_pago')->insert(array(
            'id' => 8,
            'descripcion' => 'Solicitado',
            'estado' => 1,
        ));
    }
}
