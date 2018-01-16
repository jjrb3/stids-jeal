@extends('temas.'.$empresa['nombre_administrador'])

@section('content') 
    @php($idPadre = $_REQUEST['padre'])
    @php($idHijo = $_REQUEST['hijo'])
    <input type="hidden" id="idPadre" value="{{$idPadre}}">
    <input type="hidden" id="idHijo" value="{{$idHijo}}">

    <div class="row border-bottom white-bg dashboard-header">
        <div class="col-sm-8">
            <h2 style="font-weight: 500;">{{$menuAdministrador['menu'][$idPadre]['submenu'][$idHijo]['nombre']}}</h2>
            <small>{{$menuAdministrador['menu'][$idPadre]['submenu'][$idHijo]['descripcion']}}</small>
            <br><br>
            <ol class="breadcrumb">
                <li>
                    <a href="../inicio"><i class="fa fa-home"></i> Inicio</a>
                </li>
                @if(isset($navegacion['padre']))
                    @if(!isset($navegacion['hijo']))
                        <li class="active">
                            <strong>{{$navegacion['padre']['nombre']}}</strong>
                        </li>
                    @else
                        <li><a href="../{{$navegacion['padre']['enlace']}}">{{$navegacion['padre']['nombre']}}</a></li>
                    @endif
                @endif
                @if(isset($navegacion['hijo']))
                    <li class="active">
                        <strong>{{$navegacion['hijo']['nombre']}}</strong>
                    </li>
                @endif
            </ol>
        </div>
        <div class="col-sm-4">
            <div class="float-right">
                @if($op->guardar)
                    <button type="button" class="btn btn-primary" title="Crear"><i class="fa fa-floppy-o"></i></button>
                @endif
                @if($op->actualizar)
                    <button type="button" class="btn btn-success" title="Actualizar"><i class="fa fa-pencil-square-o"></i></button>
                @endif
                @if($op->estado)
                    <button type="button" class="btn btn-warning" title="Activar y desactivar"><i class="fa fa-toggle-on"></i></button>
                @endif
                @if($op->eliminar)
                    <button type="button" class="btn btn-danger" title="Eliminar"><i class="fa fa-trash"></i></button>
                @endif
                @if($op->exportar)
                    <button type="button" class="btn btn-info" title="Exportar archivo"><i class="fa fa-cloud-download"></i></button>
                @endif
                @if($op->importar)
                    <button type="button" class="btn btn-info" title="Importar archivo"><i class="fa fa-cloud-upload"></i></button>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <br>
        <div class="col-lg-12">
            <div class="alert alert-dismissable alert-info justificado">
                <label>
                    Información.
                </label>
                <p>
                    En las siguientes pestañas podrá crear o actualizar la información personal, actividad economica,
                    información financiera, referencia personal, referencia familiar y observaciones de un cliente.
                    Recuerde llenar todos los datos que se requieren para poder realizar alguna acción.
                </p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <form id="formulario-cliente"></form>
            <div id="pestanhia-cliente" class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#informacion">Información</a></li>
                    <li class=""><a data-toggle="tab" href="#actividad-economica">Actividad economica</a></li>
                    <li class=""><a data-toggle="tab" href="#informacion-financiera">Información financiera</a></li>
                    <li class=""><a data-toggle="tab" href="#referencia-personal">Referencia personal</a></li>
                    <li class=""><a data-toggle="tab" href="#referencia-familiar">Referencia familiar</a></li>
                    <li class=""><a data-toggle="tab" href="#observacion">Observaciones</a></li>
                </ul>
                <div class="tab-content">
                    <div id="informacion" class="tab-pane active">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-3">
                                    <label>Tipo de Identificación.</label>
                                    <select id="id-tipo-identificacion" class="form-control m-b chosen-select" form="formulario-cliente"></select>
                                </div>
                                <div class="col-lg-3">
                                    <label>Identificación.</label>
                                    <input id="identificacion" type="text" class="form-control" placeholder="Digite documento" form="formulario-cliente">
                                </div>
                                <div class="col-lg-3">
                                    <label>Nombres.</label>
                                    <input id="nombres" type="text" class="form-control m-b" placeholder="Digite los nombres" form="formulario-cliente">
                                </div>
                                <div class="col-lg-3">
                                    <label>Apellidos.</label>
                                    <input id="apellidos" type="text" class="form-control m-b" placeholder="Digite los apellidos" form="formulario-cliente">
                                </div>
                                <div class="col-lg-3">
                                    <label>Estado Civil.</label>
                                    <select id="id-estado-civil" class="form-control m-b chosen-select" form="formulario-cliente"></select>
                                </div>
                                <div class="col-lg-3">
                                    <label>Fecha de nacimiento.</label>
                                    <div class="input-group">
                                        <input id="fecha-nacimiento" type="text" class="form-control m-b datepicker" placeholder="Digite la fecha de nacimiento" form="formulario-cliente">
                                        <span class="input-group-addon icono-calendario"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <label>Email Personal.</label>
                                    <input id="email-personal" type="email" class="form-control m-b" name="email_personal" placeholder="ejemplo@hotmail.com" form="formulario-cliente">
                                </div>
                                <div class="col-lg-3 form-group">
                                    <label>Ciudad.</label>
                                    <input id="ciudad" type="text" class="form-control autocompletar-ciudades" data-id="id-municipio" data-name="municipio" form="formulario-cliente">
                                </div>
                                <div class="col-lg-3">
                                    <label>Dirección de Residencia.</label>
                                    <input id="direccion" type="text" class="form-control m-b" placeholder="Digite la dirección" form="formulario-cliente">
                                </div>
                                <div class="col-lg-3">
                                    <label>Barrio de Residencia.</label>
                                    <input id="barrio" type="text" class="form-control m-b" name="barrio" placeholder="Digite el barrio" form="formulario-cliente">
                                </div>
                                <div class="col-lg-3">
                                    <label>Teléfono de Residencia.</label>
                                    <input id="telefono" type="text" class="form-control m-b" name="telefono" placeholder="Digite el teléfono" form="formulario-cliente">
                                </div>
                                <div class="col-lg-3">
                                    <label>Celular Personal.</label>
                                    <input id="celular" type="text" class="form-control m-b formato-celular" name="celular" form="formulario-cliente">
                                </div>
                                <div class="col-lg-12" id="ca-botones-cliente">
                                    <br>
                                    @if($op->guardar)
                                        <button id="btn-guardar" class="btn btn-primary" type="button" onClick="Api.Cliente.crearActualizar()">
                                            <i class="fa fa-floppy-o"></i>&nbsp;
                                            Guardar
                                        </button>
                                    @endif
                                    @if($op->actualizar)
                                        <button id="btn-cancelar" class="btn ocultar" type="button" onclick="Api.Herramientas.cancelarCA('cliente')">
                                            <i class="fa fa-times"></i>
                                            Cancelar
                                        </button>
                                        <button id="btn-actualizar" class="btn btn-success ocultar" type="button" onClick="Api.Cliente.crearActualizar()">
                                            <i class="fa fa-pencil-square-o"></i>&nbsp;
                                            Actualizar
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="actividad-economica" class="tab-pane">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-3">
                                    <label>Ocupación u Oficio.</label>
                                    <select id="id-ocupacion" class="chosen-select form-control m-b" form="formulario-cliente"></select>
                                </div>
                                <div class="col-lg-3">
                                    <label>Nombre de la Empresa.</label>
                                    <input id="empresa-nombre" type="text" class="form-control m-b" placeholder="Digite la empresa" form="formulario-cliente">
                                </div>
                                <div class="col-lg-3">
                                    <label>Cargo.</label>
                                    <input id="empresa-cargo" type="text" class="form-control m-b" placeholder="Digite su cargo actual" form="formulario-cliente">
                                </div>
                                <div class="col-lg-3">
                                    <label>Area u Dependencia.</label>
                                    <input id="empresa-area" type="text" class="form-control m-b" placeholder="Digite la empresa" form="formulario-cliente">
                                </div>
                                <div class="col-lg-3">
                                    <label>Barrio.</label>
                                    <input id="empresa-barrio" type="text" class="form-control m-b" placeholder="Digite el barrio" form="formulario-cliente">
                                </div>
                                <div class="col-lg-3">
                                    <label>Dirección.</label>
                                    <input id="empresa-direccion" type="text" class="form-control m-b" placeholder="Digite la dirección" form="formulario-cliente">
                                </div>
                                <div class="col-lg-3">
                                    <label>Teléfono.</label>
                                    <input id="empresa-telefono" type="text" class="form-control m-b" placeholder="Digite el teléfono" form="formulario-cliente">
                                </div>
                                <div class="col-lg-3">
                                    <label>Fecha de Ingreso.</label>
                                    <input id="empresa-fecha-ingreso" type="text" class="form-control m-b datepicker" placeholder="Digite la fecha de ingreso" form="formulario-cliente">
                                </div>
                                <div class="col-lg-3">
                                    <label>Antiguedad en Meses.</label>
                                    <input id="empresa-antiguedad-meses" type="text" class="form-control m-b numerico" placeholder="Digite antiguedad en meses" form="formulario-cliente">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="informacion-financiera" class="tab-pane">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-3">
                                    <label>Banco.</label>
                                    <select id="id-banco-cliente" class="form-control m-b chosen-select" form="formulario-cliente"></select>
                                </div>
                                <div class="col-lg-3">
                                    <label>Cuenta de Ahorro.</label>
                                    <input id="no-cuenta" type="text" class="form-control m-b formato-numerico" placeholder="Digite número de cuenta" form="formulario-cliente">
                                </div>
                                <div class="col-lg-3">
                                    <label>Sueldo.</label>
                                    <input id="sueldo" type="text" class="form-control m-b formato-numerico" placeholder="Digite su sueldo" form="formulario-cliente">
                                </div>
                                <div class="col-lg-3">
                                    <label>Ingresos.</label>
                                    <input id="ingresos" type="text" class="form-control m-b formato-numerico" placeholder="Digite sus ingresos" form="formulario-cliente">
                                </div>
                                <div class="col-lg-3">
                                    <label>Egresos.</label>
                                    <input id="egresos" type="text" class="form-control m-b formato-numerico" placeholder="Digite sus egresos" form="formulario-cliente">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="referencia-personal" class="tab-pane">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-3">
                                    <label>Nombres.</label>
                                    <input id="ref-personal-nombres" type="text" class="form-control m-b" placeholder="Digite los nombres" form="formulario-cliente">
                                </div>
                                <div class="col-lg-3">
                                    <label>Apellidos.</label>
                                    <input id="ref-personal-apellidos" type="text" class="form-control m-b" placeholder="Digite los apellidos" form="formulario-cliente">
                                </div>
                                <div class="col-lg-3">
                                    <label>Barrio de Residencia.</label>
                                    <input id="ref-personal-barrio" type="text" class="form-control m-b" placeholder="Digite el barrio" form="formulario-cliente">
                                </div>
                                <div class="col-lg-3">
                                    <label>Teléfono de Residencia.</label>
                                    <input id="ref-personal-telefono" type="text" class="form-control m-b" placeholder="Digite el teléfono" form="formulario-cliente">
                                </div>
                                <div class="col-lg-3">
                                    <label>Celular Personal.</label>
                                    <input id="ref-personal-celular" type="text" class="form-control m-b formato-celular" form="formulario-cliente">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="referencia-familiar" class="tab-pane">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-3">
                                    <label>Nombres.</label>
                                    <input id="ref-familiar-nombres" type="text" class="form-control m-b" placeholder="Digite los nombres" form="formulario-cliente">
                                </div>
                                <div class="col-lg-3">
                                    <label>Apellidos.</label>
                                    <input id="ref-familiar-apellidos" type="text" class="form-control m-b" placeholder="Digite los apellidos" form="formulario-cliente">
                                </div>
                                <div class="col-lg-3">
                                    <label>Barrio de Residencia.</label>
                                    <input id="ref-familiar-barrio" type="text" class="form-control m-b" placeholder="Digite el barrio" form="formulario-cliente">
                                </div>
                                <div class="col-lg-3">
                                    <label>Teléfono de Residencia.</label>
                                    <input id="ref-familiar-telefono" type="text" class="form-control m-b" placeholder="Digite el teléfono" form="formulario-cliente">
                                </div>
                                <div class="col-lg-3">
                                    <label>Celular Personal.</label>
                                    <input id="ref-familiar-celular" type="text" class="form-control m-b formato-celular" form="formulario-cliente">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="observacion" class="tab-pane">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <label>Observaciones.</label>
                                    <textarea id="observaciones" class="form-control m-b" rows="5" form="formulario-cliente"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Lista de clientes</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content inspinia-timeline" style="display: block;">
                                <div class="timeline-item">
                                    <div class="row">
                                        <div class="col-lg-12" id="cliente-tabla"></div>
                                    </div>
                                </div>       
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modals -->
    <!-- Detalle y codeudores -->
    <div id="modal-codeudor" class="modal fade" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" style="color:#fff">&times;</button>
                    <h3 class="modal-title">&nbsp;Codeudores de <span id="nombre-completo"></span></h3>
                </div>
                <div class="modal-body gray-bg">
                    <div class="row">
                        <div id="pestanhia-cliente" class="tabs-container">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#lista">Listado</a></li>
                                <li class=""><a data-toggle="tab" href="#crear-actualizar">Crear o Actualizar</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="lista" class="tab-pane active">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-12" id="codeudor-tabla"></div>
                                        </div>
                                    </div>
                                </div>
                                <div id="crear-actualizar" class="tab-pane">
                                    <div class="panel-body">
                                        <div class="row">
                                            <form id="form-codeudores">
                                                <div class="form-group col-lg-3">
                                                    <label>Cedula:</label>
                                                    <input type="text" class="form-control" id="cedula" name="cedula" required>
                                                </div>
                                                <div class="form-group col-lg-3">
                                                    <label>Fecha de expedición:</label>
                                                    <input type="date" class="form-control" id="fecha_expedicion" name="fecha_expedicion" required>
                                                </div>
                                                <div class="form-group col-lg-3">
                                                    <label>Nombres:</label>
                                                    <input type="text" class="form-control" id="nombres" name="nombres" required>
                                                </div>
                                                <div class="form-group col-lg-3">
                                                    <label>Apellidos:</label>
                                                    <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                                                </div>
                                                <div class="form-group col-lg-3">
                                                    <label>Dirección:</label>
                                                    <input type="text" class="form-control" id="direccion" name="direccion" required>
                                                </div>
                                                <div class="form-group col-lg-3">
                                                    <label>Teléfono:</label>
                                                    <input type="text" class="form-control" id="telefono" name="telefono">
                                                </div>
                                                <div class="form-group col-lg-3">
                                                    <label>Celular:</label>
                                                    <input type="text" class="form-control" id="celular" name="celular">
                                                </div>
                                                <div class="form-group col-lg-6">
                                                    <button id="btn-cancelar" class="btn btn-default " type="button" onclick="Api.Cliente.cancelarEditarCodeudor('#form-codeudores')" style="display: none">
                                                        <i class="fa fa-times"></i>
                                                        Cancelar
                                                    </button>
                                                    <button class="btn btn-primary btn-guardar" type="button" onclick="Api.Codeudor.agregar('#form-codeudores ','modal-detalle #mensaje')" style="display: none">
                                                        <i class="fa fa-floppy-o"></i>&nbsp;
                                                        Guardar
                                                    </button>
                                                </div>
                                                <input type="hidden" id="id_cliente" name="id_cliente">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin detalle y codeudores -->
    <!-- Fin modal -->
@endsection

@section('script')
    <script type="text/javascript" src="{{asset('js/si/prestamo/cliente.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/si/prestamo/codeudor.js')}}"></script>

    <script>
        Api.permisos = [{{$permisos}}];
        Api.Cliente.constructor();
        Api.Codeudor.constructor(7,{"nombres":"Alvaro","apellidos":"Perez"});
    </script>
@endsection