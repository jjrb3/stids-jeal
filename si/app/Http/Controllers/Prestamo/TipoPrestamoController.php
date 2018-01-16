<?php

namespace App\Http\Controllers\Prestamo;

use App\Models\Prestamo\TipoPrestamo;


class TipoPrestamoController extends Controller
{
    public static function ConsultarActivos() {

        return TipoPrestamo::consultarActivo();
    }
}