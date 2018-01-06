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

    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content">
                <div class="row">

                    @if($pg && in_array('1',$pg['id']))
                    <div class="col-lg-8">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>
                                    <i class="fa fa-area-chart"></i>
                                    Transacciones de usuarios
                                </h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content inspinia-timeline" style="display: block;">
                                <div class="timeline-item">
                                    <div class="row">
                                        <canvas id="grafica-usuario-transacciones" height="120" width="450" style="display: block; width: 466px; height: 217px;"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($pg && in_array('2',$pg['id']))
                    <div class="col-lg-4">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>
                                    <i class="fa fa-pie-chart"></i>
                                    Total de usuarios
                                </h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content inspinia-timeline" style="display: block;">
                                <div class="timeline-item">
                                    <div class="row">
                                        <canvas id="grafica-usuario-total" height="265" style="display: block; width: 466px; height: 217px;" width="466"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="col-lg-12 pad-bot-20">
                        <div id="pestanhia-usuario" class="tabs-container">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#listado"> Lista de usuarios</a></li>
                                <li class=""><a data-toggle="tab" href="#crear-editar">Crear o Editar</a></li>
                                <li class=""><a data-toggle="tab" href="#detalle">Detalle</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="listado" class="tab-pane active">
                                    <div class="panel-body ">
                                        <div class="row">
                                            <div class="col-lg-12" id="tabla-usuario"></div>
                                        </div>
                                    </div>
                                </div>
                                <div id="crear-editar" class="tab-pane">
                                    <div class="panel-body ">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <form id="formulario-usuario">
                                                    <input type="hidden" id="id">
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Tipo de identificación.</label>
                                                            <select id="tipo-identificacion" name="identificacion" class="form-control m-b chosen-select" required></select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>No. Documento.</label>
                                                            <input id="no-documento" type="text" class="form-control" name="documento" placeholder="Digite documento">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Rol.</label>
                                                            <select id="id-rol-usuario" name="id-rol-usuario" class="form-control m-b chosen-select" required></select>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Usuario.</label>
                                                            <input id="usuario" type="text" class="form-control m-b" name="usuario" placeholder="Digite el usuario" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Contraseña.</label>
                                                            <input id="clave" type="password" class="form-control m-b" name="clave" placeholder="Digite la contraseña" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Nombres.</label>
                                                            <input id="nombres" type="text" class="form-control m-b" name="nombres" placeholder="Digite los nombres" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Apellidos.</label>
                                                            <input id="apellidos" type="text" class="form-control m-b" name="apellidos" placeholder="Digite los apellidos" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Sexo.</label>
                                                            <select id="sexo" name="sexo" class="form-control m-b chosen-select" required></select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Ciudad.</label>
                                                            <input id="ciudad" type="text" class="form-control autocompletar-ciudades" data-id="id-municipio" data-name="municipio">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Email.</label>
                                                            <input id="email" type="email" class="form-control m-b" name="correo" placeholder="Digite el correo" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Fecha de nacimiento.</label>
                                                            <div class="input-group">
                                                                <input id="fecha-nacimiento" type="text" class="form-control m-b datepicker" name="fechaNacimiento" placeholder="Digite la fecha de nacimiento" required>
                                                                <span class="input-group-addon icono-calendario"><i class="fa fa-calendar"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Teléfono.</label>
                                                            <input id="telefono" type="text" class="form-control m-b" name="telefono" placeholder="Digite el teléfono" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Celular.</label>
                                                            <input id="celular" type="text" class="form-control m-b formato-celular" name="celular" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group" id="ca-botones-usuario">
                                                            <br style="">
                                                            @if($op->guardar)
                                                            <button id="btn-guardar" class="btn btn-primary" type="button" onClick="Api.Usuario.crear()">
                                                                <i class="fa fa-floppy-o"></i>&nbsp;
                                                                Guardar
                                                            </button>
                                                            @endif
                                                            @if($op->actualizar)
                                                            <button id="btn-cancelar" class="btn ocultar" type="button" onclick="Api.Herramientas.cancelarCA('usuario')">
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
                                                </form>
                                                <br>
                                            </div>
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
                                            <div class="col-lg-4">
                                                <label>Logo de la empresa.</label>
                                                <br>
                                                <img id="info-logo" src="" width="100%">
                                                <br>
                                                <br>
                                                <label>Dashboard Habilitado.</label>
                                                <br>
                                                <div id="info-dashboard">
                                                    <a id="info-modulo" class="btn btn-white">
                                                        <i class="fa fa-list-alt"></i>
                                                        Módulos
                                                    </a>
                                                    <a id="info-grafica" class="btn btn-white">
                                                        <i class="fa fa-line-chart"></i>
                                                        Gráficas
                                                    </a>
                                                </div>
                                                <br>
                                                <br>

                                                <label>Modulos habilitados.</label>
                                                <br>
                                                <div id="info-modulos-habilitados" style="padding: 2px"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer">
                <div class="pull-right">
                    <strong>Copyright </strong> Stids Jeal &copy; 2017
                </div>
            </div>
        </div>
    </div>
    <!-- Fin contenido de la pagina -->
@endsection

@section('script')
    <script type="text/javascript" src="{{asset('js/si/parametrizacion/usuario.js')}}"></script>

    @if($pg)
        <script type="text/javascript" src="{{asset('js/si/graficas/parametrizacion/usuario.js')}}"></script>
    @endif

    <script>
        Api.permisos = [{{$permisos}}];
        Api.Graficas.permisos = [{{$permisosGraficas}}];
        Api.Usuario.ie = parseInt('{{$id_empresa}}');
        Api.Usuario.constructor('crear-editar #mensaje',[{{$permisosGraficas}}]);
    </script>
@endsection