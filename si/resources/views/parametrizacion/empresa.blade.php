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
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins" style="display:none;">
                            <div class="ibox-title">
                                <h5>Crear Empresa</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content inspinia-timeline" style="display: block;">
                                <div class="timeline-item">
                                    <div class="row">
                                        <div id="mensajeGuardar"></div>
                                        <form id="formulario">
                                            <div class="col-lg-3">
                                                <select id="id_tema" name="id_tema" class="form-control m-b" required></select>
                                            </div>
                                            <div class="col-lg-3">
                                                <input id="nit" type="text" class="form-control m-b" name="nit" placeholder="Digite el NIT" required>
                                            </div>
                                            <div class="col-lg-3">
                                                <input id="nombre_cabecera" type="text" class="form-control m-b" name="nombre_cabecera" placeholder="Digite el nombre de la cabecera de la plataforma" required>
                                            </div>
                                            <div class="col-lg-3">
                                                <input id="nombre" type="text" class="form-control m-b" name="nombre" placeholder="Digite el nombre de la empresa" required>
                                            </div>

                                            <div class="col-lg-3" id="divGuardar">
                                                <button id="botonGuardar" class="btn btn-primary " type="button" onClick="guardar(false,'')" style="display:none;">
                                                    <i class="fa fa-floppy-o"></i>&nbsp;
                                                    Guardar
                                                </button>
                                                <button id="botonCancelar" class="btn btn-default " type="button" onclick="cancelarGuardar('formulario')" style="display:none;">
                                                    <i class="fa fa-times"></i> 
                                                    Cancelar
                                                </button>
                                                <button id="botonActualizar" class="btn btn-primary " type="button" onClick="guardar(false,'')" style="display:none;">
                                                    <i class="fa fa-floppy-o"></i>&nbsp;
                                                    Actualizar
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>       
                            </div>
                        </div>
                    </div>
                
                    <div class="col-lg-9">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Lista de Empresas</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content inspinia-timeline" style="display: block;">
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

                    <!-- IMAGEN DE LOGO -->
                    <div class="col-lg-3" id="imagenLogo" style="display:none;">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Imagen de logo</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content inspinia-timeline" style="display: block;">
                                <div class="timeline-item">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div id="mensajeImagen"></div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div id="bloqueImagen"></div>
                                            <br>
                                        </div>
                                        <form id="imagen" enctype="multipart/form-data" accept-charset="UTF-8">
                                            <div class="col-lg-6">
                                                <input id="imagen_logo" type="file" class="form-control m-b" name="imagen_logo" required>
                                            </div>
                                            <div class="col-lg-6">
                                                <button id="botonActualizarImagen" class="btn btn-primary " type="button" onclick="actualizarImagen()" style="display:none;">
                                                    <i class="fa fa-floppy-o"></i>&nbsp;
                                                    Actualizar
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>       
                            </div>
                        </div>
                    </div>

                    <!-- SUCURSAL -->
                    <div class="col-lg-6" id="sucursal" style="display:none;">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Sucursal de la Empresa</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content inspinia-timeline" style="display: block;">
                                <div class="timeline-item">
                                    <div class="row">
                                        <div id="mensajeSucursal"></div>
                                        <form id="formularioSucursal">
                                            <div class="col-lg-4">
                                                <select id="id_pais" class="form-control m-b" onChange="_selectDepartamento(this.value)" required></select>
                                            </div>
                                            <div class="col-lg-4">
                                                <select id="id_departamento" onChange="_selectMunicipio(this.value)" class="form-control m-b" required>
                                                    <option value="">Seleccione un Departamento...</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-4">
                                                <select id="id_municipio" name="id_municipio" class="form-control m-b" required>
                                                    <option value="">Seleccione un Municipio...</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-6">
                                                <input id="sucursal_codigo" type="text" class="form-control m-b" name="codigo" placeholder="Digite el codigo" required>
                                            </div>
                                            <div class="col-lg-6">
                                                <input id="sucursal_nombre" type="text" class="form-control m-b" name="nombre" placeholder="Digite el nombre" required>
                                            </div>
                                            <div class="col-lg-6">
                                                <input id="telefono" type="text" class="form-control m-b" name="telefono" placeholder="Digite el teléfono" required>
                                            </div>
                                            <div class="col-lg-6">
                                                <input id="direccion" type="text" class="form-control m-b" name="direccion" placeholder="Digite el dirección" required>
                                            </div>
                                            <div class="col-lg-6">
                                                <textarea id="quienes_somos" class="form-control m-b"  name="quienes_somos" placeholder="Quienes somos?" rows="6"></textarea>
                                            </div>
                                            <div class="col-lg-6">
                                                <textarea id="que_hacemos" class="form-control m-b"  name="que_hacemos" placeholder="Que hacemos?" rows="6"></textarea>
                                            </div>
                                            <div class="col-lg-6">
                                                <textarea id="mision" class="form-control m-b"  name="mision" placeholder="Misión" rows="6"></textarea>
                                            </div>
                                            <div class="col-lg-6">
                                                <textarea id="vision" class="form-control m-b"  name="vision" placeholder="Visión" rows="6"></textarea>
                                            </div>
                                            <div class="col-lg-12">
                                                @if($permisoGuardar == true)
                                                    <button id="botonActualizarSucursal" class="btn btn-primary " type="button" onclick="guardar(true,'')">
                                                        <i class="fa fa-floppy-o"></i>&nbsp;
                                                        Actualizar
                                                    </button>
                                                @endif
                                            </div>
                                        </form>                                   
                                    </div>
                                </div>       
                            </div>
                        </div>
                    </div>

                    <!-- VALORES -->
                    <div class="col-lg-3" id="valores" style="display:none;">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Valores de la Empresa</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content inspinia-timeline" style="display: block;">
                                <div class="timeline-item">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div id="mensajeValores"></div>   
                                        </div>
                                        <div class="col-lg-12">
                                            @if($permisoGuardar == true)
                                                <input type="text" id="formulario-valores" class="form-control" style="width:300px" placeholder="Digite valor para crear" onkeypress="enterValores(event)">
                                                <br>
                                            @endif
                                        </div>      
                                    </div> 
                                    <div class="row">
                                        <div id="bloqueValores"></div>                       
                                    </div>
                                </div>       
                            </div>
                        </div>
                    </div>

                    <!-- CORREOS -->
                    <div class="col-lg-3" id="correoSucursal" style="display:none;">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Correos de la Sucursal</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content inspinia-timeline" style="display: block;">
                                <div class="timeline-item">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div id="mensajeCorreos"></div>     
                                        </div>
                                        <div class="col-lg-12">
                                            @if($permisoGuardar == true)
                                                <input type="text" id="formulario-correo" class="form-control" style="width:300px" placeholder="Digite correo para crear" onkeypress="enterCorreo(event)">
                                                <br>
                                            @endif
                                        </div>  
                                    </div>
                                    <div class="row">
                                        <div id="bloqueCorreos"></div>                                   
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
    <script type="text/javascript" src="{{asset('js/si/parametrizacion/empresa.js')}}"></script>
    <script>listado();llenarInputsGuardar();</script>
@endsection