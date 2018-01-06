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

                    <!-- IMAGEN DE LOGO -->
                    <div class="col-lg-12" id="imagenLogo">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Agregar modulo</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content inspinia-timeline">
                                <div class="timeline-item">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div id="mensajeGuardar"></div>
                                        </div>
                                        <form id="formulario" accept-charset="UTF-8">
                                            <div class="col-lg-3">
                                                <input type="text" id="nombre" name="nombre" class="form-control m-b" placeholder="Digite el nombre">
                                            </div>
                                            <div class="col-lg-6">
                                                <input type="text" id="descripcion" name="descripcion" class="form-control m-b" placeholder="Descripcion">
                                            </div>
                                            <div class="col-lg-3">
                                                <input type="text" id="icono" name="incono" class="form-control m-b" placeholder="Icono">
                                            </div>
                                            <div class="col-lg-3">
                                                <input type="text" id="enlace_administrador" name="enlace_administrador" class="form-control m-b" placeholder="Enlace administrador">
                                            </div>
                                            <div class="col-lg-3">
                                                <input type="text" id="enlace_usuario" name="enlace_usuario" class="form-control m-b" placeholder="Enlace usuario">
                                            </div>
                                            <div class="col-lg-3">
                                                <select name="es_nuevo" id="es_nuevo" class="form-control m-b">
                                                    <option>Seleccione si es nuevo...</option>
                                                    <option value="1">Sí</option>
                                                    <option value="0">No</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-3">
                                                <select name="es_nuevo" id="es_nuevo" class="form-control m-b">
                                                    <option>Seleccione estado...</option>
                                                    <option value="1">Activo</option>
                                                    <option value="0">Inactivo</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-3">
                                                <button id="botonGuardar" class="btn btn-primary " type="button" onClick="guardar(false,'')" style="display:none;">
                                                    <i class="fa fa-floppy-o"></i>&nbsp;
                                                    Guardar
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Lista de modulos</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content inspinia-timeline">
                                <div class="timeline-item">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <select id="tipo-modulo" class="form-control m-b" onchange="listado()">
                                                <option>Administrador</option>
                                                <option>Usuario</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-9">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div id="mensajeTabla"></div>
                                        <div id='tabla'></div>
                                        <div id='paginacion'></div>
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
                    <input type="hidden" id="idActualizar">
                    <input type="hidden" id="id-sucursal">
                </div>
            </div>
        </div>
    </div>
    <!-- Fin contenido de la pagina -->

    <!-- Modal de imagen -->
    <div id="modal-imagen" class="modal fade" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12" style="text-align:center">
                            <h3 class="m-t-none m-b">Diseño del tema</h3>
                            <div>
                                <img id="urlImagenTema" src="" width="100%">
                                <button data-dismiss="modal" class="btn btn-sm btn-default m-t-n-xs"><strong>Cerrar</strong></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin del Modal de Eliminar -->
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="{{asset('js/si/parametrizacion/modulos.js')}}"></script>
@endsection