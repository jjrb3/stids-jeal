@extends('temas.'.$empresa['nombre_administrador'])

@section('content') 
    
    <div class="row  border-bottom white-bg dashboard-header">
        <div class="col-lg-12">
            <div class="text-center animated fadeInDown">
                <h1>Sin acceso</h1>
                <h3 class="font-bold">El contenido de la pagina no puede ser visto</h3>

                <div class="error-desc">
                    Esta intentando acceder a un contenido en el cual no tiene permiso. <br>
                    Puede volver a la pagina principal: <br><a href="../inicio" class="btn btn-primary m-t">Inicio Stids Jeal</a>
                </div>
            </div>
        </div>
    </div>

@endsection
