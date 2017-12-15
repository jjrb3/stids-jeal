<?php

namespace App\Http\Controllers\Prestamo;

use App\Models\Prestamo\FormaPago;


class FormaPagoController extends Controller
{
    public static function ConsultarActivos() {

        return FormaPago::consultarActivo();
    }
}