@extends('temas.'.$empresa['nombre_administrador'])

@section('content') 
    @php($idPadre = $_REQUEST['padre'])
    @php($idHijo = $_REQUEST['hijo'])
    <input type="hidden" id="rutaImagen" value="../../../temas/{{$empresa['tema_nombre']}}">
    <input type="hidden" id="idPadre" value="{{$idPadre}}">
    <input type="hidden" id="idHijo" value="{{$idHijo}}">

    <div class="row  border-bottom white-bg dashboard-header">
        <div class="col-sm-12">
            <h2 style="font-weight: 500;">{{$menuAdministrador['menu'][$idPadre]['submenu'][$idHijo]['nombre']}}</h2>
            <small>{{$menuAdministrador['menu'][$idPadre]['submenu'][$idHijo]['descripcion']}}</small>
            <div style="float:right;">
                @php($cnt = 0)
                @php($idsPermiso = '')
                @php($permisoGuardar = false)
                @foreach($permisos as $permiso)
                    @if($cnt>0)
                        @php($idsPermiso .= ',' . $permiso['id_permiso'])
                    @else
                        @php($idsPermiso .= $permiso['id_permiso'])
                    @endif

                    @if($permiso['id_permiso'] == 1)
                        <button type="button" class="btn btn-primary" title="Crear"><i class="fa fa-floppy-o"></i></button>
                        @php($permisoGuardar = true)
                    @elseif($permiso['id_permiso'] == 2)
                        <button type="button" class="btn btn-success" title="Rapida actualización"><i class="fa fa-pencil"></i></button>
                        <button type="button" class="btn btn-success" title="Actualizar"><i class="fa fa-pencil-square-o"></i></button>
                    @elseif($permiso['id_permiso'] == 3)
                        <button type="button" class="btn btn-warning" title="Activar y desactivar"><i class="fa fa-toggle-on"></i></button>
                    @elseif($permiso['id_permiso'] == 4)
                        <button type="button" class="btn btn-danger" title="Eliminar"><i class="fa fa-trash"></i></button>
                    @elseif($permiso['id_permiso'] == 5)
                        <button type="button" class="btn btn-info" title="Exportar archivo"><i class="fa fa-cloud-download"></i></button>
                    @elseif($permiso['id_permiso'] == 6)
                        <button type="button" class="btn btn-info" title="Importar archivo"><i class="fa fa-cloud-upload"></i></button>
                    @endif

                    @php($cnt++)
                @endforeach   
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
                                <h5>Crear plan</h5>
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
                                            <div class="col-lg-6">
                                                <input type="text" id="nombre" name="nombre" class="form-control m-b" placeholder="Digite el nombre">
                                                <input type="text" id="valor" name="valor" class="form-control m-b numerico" placeholder="Valor" min="0">
                                                <button id="botonGuardar" class="btn btn-primary " type="button" onClick="guardar(false,'')" style="display:none;">
                                                    <i class="fa fa-floppy-o"></i>&nbsp;
                                                    Guardar
                                                </button>
                                            </div>
                                            <div class="col-lg-6">
                                                <textarea id="descripcion" class="form-control m-b"  name="descripcion" placeholder="Descripción del Slider" rows="6"></textarea>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <div class="col-lg-6">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Lista de planes</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content inspinia-timeline">
                                <div class="timeline-item">
                                    <div class="row">
                                        <div id="mensajeTabla"></div>
                                        <div id='tabla'></div>   
                                        <div id='paginacion'></div>                                        
                                    </div>
                                </div>       
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Detalle del plan</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content inspinia-timeline">
                                <div class="timeline-item">
                                    <div class="row">
                                        <form id="formularioDetalle" accept-charset="UTF-8">
                                            <input type="hidden" name="id_planes_caracteristicas" id="id_planes_caracteristicas">
                                            <div class="col-lg-4">
                                                <input type="text" id="titulo" name="titulo" class="form-control m-b" placeholder="Digite el titulo">
                                            </div>
                                            <div class="col-lg-4">
                                                <input type="text" id="descripcion" name="descripcion" class="form-control m-b" placeholder="Digite la descripción">
                                            </div>
                                            <div class="col-lg-2">
                                                <button id="" class="btn btn-primary " type="button" onClick="guardarPlanDetalle(false,'')">
                                                    <i class="fa fa-floppy-o"></i>&nbsp;
                                                    Guardar
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="row">
                                        <div id="mensajeTablaDetalle"></div>
                                        <div id='bloqueDetalle'></div>
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
    <script>var globalPermisos = [{{$idsPermiso}}]</script>
    <script type="text/javascript" src="{{asset('js/si/pagina_publica/planes.js')}}"></script>
    <script>_verificarPermisos();listado();</script>
@endsection