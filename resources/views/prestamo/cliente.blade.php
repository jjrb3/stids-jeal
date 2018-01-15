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
            <br>
            <div  id="pestanhia-cliente" class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#informacion">Información</a></li>
                    <li class=""><a data-toggle="tab" href="#actividad-economica">Actividad economica</a></li>
                    <li class=""><a data-toggle="tab" href="#informacion-financiera">Información financiera</a></li>
                    <li class=""><a data-toggle="tab" href="#referencia-personal">Referencia personal</a></li>
                    <li class=""><a data-toggle="tab" href="#referencia-familiar">Referencia familiar</a></li>
                    <li class=""><a data-toggle="tab" href="#observaciones">Observaciones</a></li>
                </ul>
                <div class="tab-content">
                    <div id="informacion" class="tab-pane active">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Tipo de Identificación.</label>
                                            <div>
                                                <select id="id_tipo_identificacion" name="id_tipo_identificacion" class="select2 form-control m-b" required>
                                                    <option value="">Seleccione...</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Identificación.</label>
                                            <div>
                                                <input id="identificacion" type="text" class="form-control" name="identificacion" placeholder="Digite documento">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Nombres.</label>
                                            <div>
                                                <input id="nombres" type="text" class="form-control m-b" name="nombres" placeholder="Digite los nombres" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Apellidos.</label>
                                            <div>
                                                <input id="apellidos" type="text" class="form-control m-b" name="apellidos" placeholder="Digite los apellidos" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Estado Civil.</label>
                                            <div>
                                                <select id="id_estado_civil" name="id_estado_civil" class="select2 form-control m-b">
                                                    <option>Seleccione...</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Fecha de Nacimiento.</label>
                                            <div>
                                                <input id="fecha_nacimiento" type="date" class="form-control m-b" name="fecha_nacimiento" placeholder="aaaa/mm/dd">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Email Personal.</label>
                                            <div>
                                                <input id="email_personal" type="email" class="form-control m-b" name="email_personal" placeholder="ejemplo@hotmail.com">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Dirección de Residencia.</label>
                                            <div>
                                                <input id="direccion" type="text" class="form-control m-b" name="direccion" placeholder="Digite la dirección" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 ocultar">
                                        <div class="form-group">
                                            <label>País.</label>
                                            <div>
                                                <select id="pais" name="pais" class="select2 form-control m-b" required></select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 ocultar">
                                        <div class="form-group">
                                            <label>Departamento.</label>
                                            <div>
                                                <select id="departamento" name="departamento" class="select2 form-control m-b" required></select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 ocultar">
                                        <div class="form-group">
                                            <label>Ciudad.</label>
                                            <div>
                                                <select id="id_ciudad" name="id_ciudad" class="select2 form-control m-b" required></select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Barrio de Residencia.</label>
                                            <div>
                                                <input id="barrio" type="text" class="form-control m-b" name="barrio" placeholder="Digite el barrio" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Teléfono de Residencia.</label>
                                            <div>
                                                <input id="telefono" type="text" class="form-control m-b" name="telefono" placeholder="Digite el teléfono" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Celular Personal.</label>
                                            <div>
                                                <input id="celular" type="text" class="form-control m-b formato-celular" name="celular" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="actividad-economica" class="tab-pane">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="informacion-financiera" class="tab-pane">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="referencia-personal" class="tab-pane">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="referencia-familiar" class="tab-pane">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="observaciones" class="tab-pane">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
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
                    <div class="col-lg-12 ocultar">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Crear cliente</h5>
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

                                            <div class="col-lg-12">
                                                <br>
                                                <h3 class="modal-title" align="center">Actividad Economica Principal</h3>
                                                <br>
                                                <br>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>Ocupación u Oficio.</label>
                                                    <div>
                                                        <select id="id_ocupacion" name="id_ocupacion" class="select2 form-control m-b">
                                                            <option value="">Seleccione...</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>Nombre de la Empresa.</label>
                                                    <div>
                                                        <input id="empresa_nombre" type="text" class="form-control m-b" name="empresa_nombre" placeholder="Digite la empresa">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>Cargo.</label>
                                                    <div>
                                                        <input id="empresa_cargo" type="text" class="form-control m-b" name="empresa_cargo" placeholder="Digite su cargo actual">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>Area u Dependencia.</label>
                                                    <div>
                                                        <input id="empresa_area" type="text" class="form-control m-b" name="empresa_area" placeholder="Digite la empresa">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-3 ocultar">
                                                <div class="form-group">
                                                    <label>País.</label>
                                                    <div>
                                                        <select id="pais" name="pais" class="select2 form-control m-b" required></select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 ocultar">
                                                <div class="form-group">
                                                    <label>Departamento.</label>
                                                    <div>
                                                        <select id="departamento" name="departamento" class="select2 form-control m-b" required></select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 ocultar">
                                                <div class="form-group">
                                                    <label>Ciudad.</label>
                                                    <div>
                                                        <select id="id_municipio_empresa" name="id_municipio_empresa" class="select2 form-control m-b" required></select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>Barrio.</label>
                                                    <div>
                                                        <input id="empresa_barrio" type="text" class="form-control m-b" name="empresa_barrio" placeholder="Digite el barrio">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>Dirección.</label>
                                                    <div>
                                                        <input id="empresa_direccion" type="text" class="form-control m-b" name="empresa_direccion" placeholder="Digite la dirección">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>Teléfono.</label>
                                                    <div>
                                                        <input id="empresa_telefono" type="text" class="form-control m-b" name="empresa_telefono" placeholder="Digite el teléfono">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>Fecha de Ingreso.</label>
                                                    <div>
                                                        <input id="empresa_fecha_ingreso" type="date" class="form-control m-b" name="empresa_fecha_ingreso" placeholder="Digite la fecha de ingreso">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>Antiguedad en Meses.</label>
                                                    <div>
                                                        <input id="empresa_antiguedad_meses" type="text" class="form-control m-b" name="empresa_antiguedad_meses" placeholder="Digite antiguedad en meses">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <br>
                                                <h3 class="modal-title" align="center">Información Financiera</h3>
                                                <br>
                                                <br>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>Sueldo.</label>
                                                    <div>
                                                        <input id="sueldo" type="text" class="form-control m-b formato-numerico" name="sueldo" placeholder="Digite su sueldo">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>Ingresos.</label>
                                                    <div>
                                                        <input id="ingresos" type="text" class="form-control m-b formato-numerico" name="ingresos" placeholder="Digite sus ingresos">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>Egresos.</label>
                                                    <div>
                                                        <input id="egresos" type="text" class="form-control m-b formato-numerico" name="egresos" placeholder="Digite sus egresos">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <br>
                                                <h3 class="modal-title" align="center">Referencias</h3>
                                                <br>
                                                <br>
                                            </div>

                                            <div class="col-lg-6">
                                                <h3 class="modal-title" align="center">Personal</h3>
                                                <br>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Nombres.</label>
                                                        <div>
                                                            <input id="ref_personal_nombres" type="text" class="form-control m-b" name="ref_personal_nombres" placeholder="Digite los nombres">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Apellidos.</label>
                                                        <div>
                                                            <input id="ref_personal_apellidos" type="text" class="form-control m-b" name="ref_personal_apellidos" placeholder="Digite los apellidos">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 ocultar">
                                                    <div class="form-group">
                                                        <label>País.</label>
                                                        <div>
                                                            <select id="ref_personal_pais" name="ref_personal_pais" class="select2 form-control m-b" required></select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 ocultar">
                                                    <div class="form-group">
                                                        <label>Departamento.</label>
                                                        <div>
                                                            <select id="ref_personal_departamento" name="ref_personal_departamento" class="select2 form-control m-b" required></select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 ocultar">
                                                    <div class="form-group">
                                                        <label>Ciudad.</label>
                                                        <div>
                                                            <select id="id_municipio_ref_personal" name="id_municipio_ref_personal" class="select2 form-control m-b" required></select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Barrio de Residencia.</label>
                                                        <div>
                                                            <input id="ref_personal_barrio" type="text" class="form-control m-b" name="ref_personal_barrio" placeholder="Digite el barrio">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Teléfono de Residencia.</label>
                                                        <div>
                                                            <input id="ref_personal_telefono" type="text" class="form-control m-b" name="ref_personal_telefono" placeholder="Digite el teléfono">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Celular Personal.</label>
                                                        <div>
                                                            <input id="ref_personal_celular" type="text" class="form-control m-b formato-celular" name="ref_personal_celular">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <h3 class="modal-title" align="center">Familiar</h3>
                                                <br>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Nombres.</label>
                                                        <div>
                                                            <input id="ref_familiar_nombres" type="text" class="form-control m-b" name="ref_familiar_nombres" placeholder="Digite los nombres">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Apellidos.</label>
                                                        <div>
                                                            <input id="ref_familiar_apellidos" type="text" class="form-control m-b" name="ref_familiar_apellidos" placeholder="Digite los apellidos">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 ocultar">
                                                    <div class="form-group">
                                                        <label>País.</label>
                                                        <div>
                                                            <select id="ref_familiar_pais" name="ref_familiar_pais" class="select2 form-control m-b" required></select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 ocultar">
                                                    <div class="form-group">
                                                        <label>Departamento.</label>
                                                        <div>
                                                            <select id="ref_familiar_departamento" name="ref_familiar_departamento" class="select2 form-control m-b" required></select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 ocultar">
                                                    <div class="form-group">
                                                        <label>Ciudad.</label>
                                                        <div>
                                                            <select id="id_municipio_ref_familiar" name="id_municipio_ref_familiar" class="select2 form-control m-b" required></select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Barrio de Residencia.</label>
                                                        <div>
                                                            <input id="ref_familiar_barrio" type="text" class="form-control m-b" name="ref_familiar_barrio" placeholder="Digite el barrio">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Teléfono de Residencia.</label>
                                                        <div>
                                                            <input id="ref_familiar_telefono" type="text" class="form-control m-b" name="ref_familiar_telefono" placeholder="Digite el teléfono">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Celular Personal.</label>
                                                        <div>
                                                            <input id="ref_familiar_celular" type="text" class="form-control m-b formato-celular" name="ref_familiar_celular">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <br>
                                                <h3 class="modal-title" align="center">Observaciones</h3>
                                                <br>
                                                <textarea id="observaciones" name="observaciones" class="form-control m-b" rows="5"></textarea>
                                            </div>

                                            <div class="col-lg-12" id="divGuardar" align="center">
                                                <div class="form-group">
                                                    <label></label>
                                                    <div>
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
                                                </div>
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
                                        <div class="col-lg-12" id="cliente-mensaje"></div>
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
    <!-- Fin contenido de la pagina -->

    <!-- Modals -->
    <!-- Detalle y codeudores -->
    <div id="modal-detalle" class="modal fade" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title">&nbsp;Detalle del cliente <span id="nombre-cliente"></span></h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <strong>Identificación. </strong>
                            <span id="identificacion"></span>
                            &nbsp;&nbsp;&nbsp;
                            <strong>Dirección. </strong>
                            <span id="direccion"></span>
                            &nbsp;&nbsp;&nbsp;
                            <strong>Teléfono. </strong>
                            <span id="telefono"></span>
                            &nbsp;&nbsp;&nbsp;
                            <strong>Celular. </strong>
                            <span id="celular"></span>&nbsp;
                        </div>&nbsp;&nbsp;&nbsp;

                        <!-- Formulario de codeudores -->
                        <br>
                        <br>
                        <h3 class="modal-title" align="center">Crear codeudor</h3>
                        <br>
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
                        <!-- Fin formulario de codeudores -->

                        <!-- Listado de codeudores -->
                        <div class="col-lg-12">
                            <div id="mensaje-crud"></div>
                            <div id="mensaje"></div>
                            <br>
                            <h3 class="modal-title" align="center">Listado de Codeudores</h3>
                            <br>
                            <div class="table-responsive" id="tabla-codeudores">
                                <table class="table table-bordered table-hover table-striped tablesorter">
                                    <thead>
                                    <tr>
                                        <th>Cedula</th>
                                        <th>Fecha de expedición</th>
                                        <th>Nombres</th>
                                        <th>Apellidos</th>
                                        <th>Dirección</th>
                                        <th>Teléfono</th>
                                        <th>Celular</th>
                                        <th>Opciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
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
    <!-- Fin detalle y codeudores -->
    <!-- Fin modal -->
@endsection

@section('script')
    <script type="text/javascript" src="{{asset('js/si/prestamo/cliente.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/si/prestamo/codeudor.js')}}"></script>

    <script>
        Api.permisos = [{{$permisos}}];
        Api.Cliente.constructor();
    </script>
@endsection