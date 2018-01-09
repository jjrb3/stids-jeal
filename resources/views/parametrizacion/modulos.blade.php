@extends('temas.'.$empresa['nombre_administrador'])

@section('content')
    @php($idPadre = $_REQUEST['padre'])
    @php($idHijo = $_REQUEST['hijo'])
    <input type="hidden" id="idPadre" value="{{$idPadre}}">
    <input type="hidden" id="idHijo" value="{{$idHijo}}">

    <div class="row  border-bottom white-bg dashboard-header">
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

    <div id="contenedor-modulos" class="row wrapper-content">
        <div class="col-lg-12 pad-bot-20">
            <div id="pestanhia-modulos-sesiones" class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class=""><a data-toggle="tab" href="#modulos-sesiones"> Modulos & Sesiones</a></li>
                    <li class="active"><a data-toggle="tab" href="#crear-editar">Crear o Editar</a></li>
                    <li class=""><a data-toggle="tab" href="#detalle">Detalle</a></li>
                </ul>
                <div class="tab-content">
                    <div id="listado" class="tab-pane">
                        <div class="panel-body ">
                            <div class="row">
                                <div class="col-lg-12" id="modulos-sesiones-tabla"></div>
                            </div>
                        </div>
                    </div>
                    <div id="crear-editar" class="tab-pane active">
                        <div class="panel-body ">
                            <div class="row">
                                <form id="formulario-modulos">
                                    <div class="col-lg-8">
                                        <div class="col-lg-6 form-group">
                                            <label>Tipo.</label>
                                            <select id="tipo" class="form-control m-b chosen-select">
                                                <option value="1">Administrador</option>
                                                <option value="2">Usuario</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label>Módulo padre.</label>
                                            <select id="id-modulo" class="form-control m-b chosen-select"></select>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Nombre.</label>
                                            <input type="text" id="nombre" class="form-control m-b" placeholder="Digite un nombre">
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Enlace.</label>
                                            <input type="text" id="enlace" class="form-control m-b" placeholder="Digite el enlace para acceder">
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Icono.</label>
                                            <div class="input-group">
                                                <input id="icono" type="text" class="form-control m-b" placeholder="Digite el codigo del icono" value="fa-smile-o">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-smile-o"></i>
                                                </span>
                                            </div>
                                            <br>
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <label>Etiqueta.</label>
                                            <select id="id-etiqueta" class="form-control m-b chosen-select"></select>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group" id="ca-botones-modulo-sesion">
                                                <br style="">
                                                @if($op->guardar)
                                                    <button id="btn-guardar" class="btn btn-primary" type="button" onClick="Api.Usuario.crear()">
                                                        <i class="fa fa-floppy-o"></i>&nbsp;
                                                        Guardar
                                                    </button>
                                                @endif
                                                @if($op->actualizar)
                                                    <button id="btn-cancelar" class="btn ocultar" type="button" onclick="Api.Herramientas.cancelarCA('modulo-sesion')">
                                                        <i class="fa fa-times"></i>
                                                        Cancelar
                                                    </button>
                                                    <button id="btn-actualizar" class="btn btn-success ocultar" type="button" onClick="Api.Usuario.actualizar()">
                                                        <i class="fa fa-pencil-square-o"></i>&nbsp;
                                                        Actualizar
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Descripción.</label>
                                        <textarea id="descripcion" class="form-control" placeholder="Digite la descripción para continuar" style="height: 177px"></textarea>
                                    </div>
                                </form>
                                <div class="col-lg-12" id="mensaje-crear-editar"></div>
                            </div>
                        </div>
                    </div>
                    <div id="detalle" class="tab-pane">
                        <div class="panel-body ">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-striped tablesorter">
                                            <thead>
                                            <tr>
                                                <th class="centrado" colspan="2">Información de usuario</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td><strong>Empresa.</strong></td>
                                                <td width="60%" id="info-empresa"></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Usuario.</strong></td>
                                                <td id="info-usuario"></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Tipo de identificación.</strong></td>
                                                <td id="info-tipo-identificacion"></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Documento.</strong></td>
                                                <td id="info-documento"></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Nombres.</strong></td>
                                                <td id="info-nombres"></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Apellidos.</strong></td>
                                                <td id="info-apellidos"></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Email.</strong></td>
                                                <td id="info-email"></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Rol</strong></td>
                                                <td id="info-rol"></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Localización</strong></td>
                                                <td id="info-localizacion"></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Sexo.</strong></td>
                                                <td id="info-sexo"></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Número teléfonico.</strong></td>
                                                <td id="info-telefono"></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Número de Celular.</strong></td>
                                                <td id="info-celular"></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Estado.</strong></td>
                                                <td id="info-estado">
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Fin contenido de la pagina -->


@endsection

@section('script')
    <script type="text/javascript" src="{{asset('js/si/parametrizacion/modulo.js')}}"></script>

    <script>
        Api.permisos = [{{$permisos}}];
        Api.Modulo.constructor();
    </script>
@endsection