@extends('temas.'.$empresa['nombre_administrador'])

@section('content') 
    @php($idPadre = $_REQUEST['padre'])
    @php($idHijo = $_REQUEST['hijo'])
    <input type="hidden" id="idPadre" value="{{$idPadre}}">
    <input type="hidden" id="idHijo" value="{{$idHijo}}">

    <div class="row  border-bottom white-bg dashboard-header">
        <div class="col-sm-12">
            <h2 style="font-weight: 500;">{{$menuAdministrador['menu'][$idPadre]['submenu'][$idHijo]['nombre']}}</h2>
            <small>{{$menuAdministrador['menu'][$idPadre]['submenu'][$idHijo]['descripcion']}}</small>
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
                    <!-- Primer bloque de prestañas -->
                    <div class="col-lg-12 pad-bot-20 ocultar">
                        <div id="pestanhia-empresa" class="tabs-container">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#informacion"> Información</a></li>
                                <li class=""><a data-toggle="tab" href="#crear-editar">Crear o Editar</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="informacion" class="tab-pane active">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-12" id="tabla-empresa"></div>
                                        </div>
                                    </div>
                                </div>
                                <div id="crear-editar" class="tab-pane">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                Complete el siguiente formulario para crear u modificar la información de la empresa que seleccionó.
                                                <br>
                                                <br>
                                            </div>
                                            <form id="formulario-empresa">
                                                <div class="col-lg-3 form-group">
                                                    <label>Tema de la plataforma.</label>
                                                    <select id="tema" class="form-control m-b chosen-select" required></select>
                                                </div>
                                                <div class="col-lg-3 form-group">
                                                    <label>NIT.</label>
                                                    <input id="nit" type="text" class="form-control m-b" placeholder="Digite el NIT" required>
                                                </div>
                                                <div class="col-lg-3 form-group">
                                                    <label>Cabecera plataforma.</label>
                                                    <input id="nombre-cabecera" type="text" class="form-control m-b" placeholder="Digite el nombre de la cabecera" required>
                                                </div>
                                                <div class="col-lg-3 form-group">
                                                    <label>Nombre de la Empresa.</label>
                                                    <input id="nombre" type="text" class="form-control m-b" placeholder="Digite el nombre de la empresa" required>
                                                </div>
                                                <div class="col-lg-6 form-group">
                                                    <label>Frase.</label>
                                                    <input id="frase" type="text" class="form-control m-b" placeholder="Digite el nombre de la empresa" required>
                                                </div>

                                                <div class="col-lg-6 form-group pad-t-22" id="ca-botones-empresa">
                                                    @if($op->guardar && $id_empresa === 1)
                                                        <button id="btn-guardar" class="btn btn-primary" type="button" onClick="Api.Empresa.crearActualizar()">
                                                            <i class="fa fa-floppy-o"></i>&nbsp;
                                                            Guardar
                                                        </button>
                                                    @endif
                                                    @if($op->actualizar)
                                                        <button id="btn-cancelar" class="btn ocultar" type="button" onclick="Api.Herramientas.cancelarCA('empresa')">
                                                            <i class="fa fa-times"></i>
                                                            Cancelar
                                                        </button>
                                                        <button id="btn-actualizar" class="btn btn-success ocultar" type="button" onClick="Api.Empresa.crearActualizar()">
                                                            <i class="fa fa-pencil-square-o"></i>&nbsp;
                                                            Actualizar
                                                        </button>
                                                    @endif
                                                </div>
                                            </form>
                                            <div class="col-lg-12" id="mensaje"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Segundo bloque de prestañas a la izquierda -->
                    <div class="col-lg-12 ocultar" id="bloque-detalle">
                        <div class="tabs-container">
                            <div class="tabs-left">
                                <ul class="nav nav-tabs">
                                    <li class=""><a data-toggle="tab" href="#detalle"> Detalle</a></li>
                                    <li class="active"><a data-toggle="tab" href="#modulos-sesiones">Módulos y sesiones</a></li>
                                    <li class=""><a data-toggle="tab" href="#rol">Roles</a></li>
                                    <li class=""><a data-toggle="tab" href="#permisos">Permisos</a></li>
                                    <li class=""><a data-toggle="tab" href="#usuario">Usuarios</a></li>
                                    <li class=""><a data-toggle="tab" href="#logo">Logo</a></li>
                                    <li class=""><a data-toggle="tab" href="#valores">Valores</a></li>
                                    <li class=""><a data-toggle="tab" href="#email">Emails</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div id="detalle" class="tab-pane">
                                        <div class="panel-body">
                                            <div class="row ml-none">
                                                <div class="col-lg-12">
                                                    <div class="col-lg-2 form-group">
                                                        <label>Código.</label>
                                                        <input id="codigo" type="text" class="form-control" maxlength="10">
                                                    </div>
                                                    <div class="col-lg-4 form-group">
                                                        <label>Ciudad.</label>
                                                        <input id="ciudad" type="text" class="form-control autocompletar-ciudades" data-id="id-municipio" data-name="municipio">
                                                    </div>
                                                    <div class="col-lg-6 form-group">
                                                        <label>Nombre Sucursal.</label>
                                                        <input id="nombre" type="text" class="form-control" placeholder="Digite el nombre de la sucursal" maxlength="50">
                                                    </div>
                                                    <div class="col-lg-6 form-group">
                                                        <label>Teléfono.</label>
                                                        <input id="telefono" type="text" class="form-control" placeholder="Digite el teléfono de la sucursal" maxlength="50">
                                                    </div>
                                                    <div class="col-lg-6 form-group">
                                                        <label>Dirección.</label>
                                                        <input id="direccion" type="text" class="form-control" placeholder="Digite el nombre de la sucursal" maxlength="60">
                                                    </div>
                                                    <div class="col-lg-6 form-group">
                                                        <label>¿Quienes somos?</label>
                                                        <textarea id="quienes-somos" class="form-control m-b" placeholder="Digite quienes son?" rows="6"></textarea>
                                                    </div>
                                                    <div class="col-lg-6 form-group">
                                                        <label>¿Que hacemos?</label>
                                                        <textarea id="que-hacemos" class="form-control m-b" placeholder="Digite que hacen?" rows="6"></textarea>
                                                    </div>
                                                    <div class="col-lg-6 form-group">
                                                        <label>Misión</label>
                                                        <textarea id="mision" class="form-control m-b" placeholder="Cuál es su Misión?" rows="6"></textarea>
                                                    </div>
                                                    <div class="col-lg-6 form-group">
                                                        <label>Visión</label>
                                                        <textarea id="vision" class="form-control m-b" placeholder="Cuál es su Visión?" rows="6"></textarea>
                                                    </div>
                                                    <div class="col-lg-5">
                                                        @if($op->guardar)
                                                            <button id="botonActualizarSucursal" class="btn btn-success" type="button" onclick="Api.Sucursal.actualizar()">
                                                                <i class="fa fa-pencil-square-o"></i>&nbsp;
                                                                Actualizar
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="modulos-sesiones" class="tab-pane active">
                                        <div class="panel-body">
                                            <div class="row ml-none">
                                                <div class="col-lg-12">
                                                    <div class="alert alert-dismissable alert-info justificado">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                        <label>
                                                            Información.
                                                        </label>
                                                        <p>
                                                            Seleccione los módulos y las sesiones que desea habilitar para esta empresa.
                                                            Los módulos y sesiones que estén habilitados aparecerán en verde.
                                                        </p>
                                                    </div>
                                                </div>
                                                <div id="modulos" class="col-lg-12">
                                                    <div class="col-lg-5">
                                                        <h3 align="center">Módulos</h3>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-lg-12" id="tabla-modulo"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 vertical text-center">
                                                        <div style="padding-top: 150px">
                                                            <button class="btn btn-white btn-bitbucket" type="button" onclick="Api.Dashboard.agregarModulo()">
                                                                <i class="fa fa-plus verde"></i>
                                                                <span class="bold">Agregar</span>
                                                            </button>
                                                        </div>
                                                        <br>
                                                        <div>
                                                            <button class="btn btn-white btn-bitbucket" type="button" onclick="Api.Dashboard.quitarModulo()">
                                                                <i class="fa fa-close rojo"></i>
                                                                <span class="bold">Quitar</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5">
                                                        <h3 align="center">Sesiones</h3>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-lg-12" id="tabla-sesion"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div id="rol" class="tab-pane">
                                        <div class="panel-body">
                                        </div>
                                    </div>
                                    <div id="permisos" class="tab-pane">
                                        <div class="panel-body">
                                        </div>
                                    </div>
                                    <div id="usuario" class="tab-pane">
                                        <div class="panel-body">
                                        </div>
                                    </div>
                                    <div id="logo" class="tab-pane">
                                        <div class="panel-body">
                                        </div>
                                    </div>
                                    <div id="valores" class="tab-pane">
                                        <div class="panel-body">
                                            <div class="row ml-none">
                                                <div class="col-lg-12">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="email" class="tab-pane">
                                        <div class="panel-body">
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <br>
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
                                            @if($op->guardar)
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
                                            @if($op->guardar)
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
    <script type="text/javascript" src="{{asset('js/si/parametrizacion/empresa.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/si/parametrizacion/modulos.js')}}"></script>

    <script>
        Api.permisos = [{{$permisos}}];
        Api.Empresa.ie = parseInt('{{$id_empresa}}');
        Api.Empresa.constructor();
        Api.Empresa.detalle(4);
    </script>
@endsection