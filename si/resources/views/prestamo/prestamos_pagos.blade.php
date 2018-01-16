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
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Crear un prestamo</h5>
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
                                    </div>
                                        <form id="formulario" class="formulario-prestamo">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Clientes</label>
                                                        <div>
                                                            <select id="id_cliente" name="id_cliente" class="form-control m-b" required></select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label>Tipo prestamo</label>
                                                        <div>
                                                            <select id="id_tipo_prestamo" name="id_tipo_prestamo" class="form-control m-b" required></select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-1" style="display:none">
                                                    <div class="form-group">
                                                        <label>Mora %</label>
                                                        <div>
                                                            <div class="input-group">
                                                                <input id="mora" type="text" class="form-control m-b simple-field-data-mask" data-mask="00.0" data-mask-reverse="true" name="mora" value="0" placeholder="00.0" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <label>Monto solicitado</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon1">$</span>
                                                            <input id="monto_solicitado" type="text" class="form-control m-b" placeholder="000,000,000" required>
                                                            <input id="monto_requerido" name="monto_requerido" type="hidden">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-1">
                                                    <div class="form-group">
                                                        <label>Intereses</label>
                                                        <div class="input-group">
                                                            <input id="intereses" type="text" class="form-control m-b simple-field-data-mask" data-mask="00.0" data-mask-reverse="true" name="interes" placeholder="00.0" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label>Forma de pago</label>
                                                        <select id="id_forma_pago" name="id_forma_pago" class="form-control m-b" required></select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-1">
                                                    <div class="form-group">
                                                        <label>Cuotas</label>
                                                        <div class="input-group">
                                                            <input id="no_cuotas" type="text" class="form-control m-b simple-field-data-mask" data-mask="000" placeholder="0" name="no_cuotas" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-1">
                                                    <div class="form-group" align="center">
                                                        <label>Total %</label>
                                                        <div id="total-intereses" style="line-height: 30px;">
                                                            $0
                                                        </div>
                                                        <input type="hidden" name="total_intereses" id="total_intereses">
                                                    </div>
                                                </div>
                                                <div class="col-lg-1">
                                                    <div class="form-group" align="center">
                                                        <label>Total</label>
                                                        <div id="total-general" style="line-height: 30px;">
                                                            $0
                                                        </div>
                                                        <input type="hidden" name="total" id="total">
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <label>Fecha del pago inicial</label>
                                                        <div class="input-group">
                                                            <input id="fecha_pago_inicial" type="date" class="form-control m-b " name="fecha_pago_inicial" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12" id="divGuardar">
                                                    <button id="botonSimular" class="btn btn-success " type="button">
                                                        <i class="fa fa-list-alt"></i>&nbsp;
                                                        Simular prestamo
                                                    </button>
                                                    <button id="botonGuardar" class="btn btn-primary " type="button" onClick="guardar(false,'')" style="display:none;">
                                                        <i class="fa fa-floppy-o"></i>&nbsp;
                                                        Crear prestamo
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
                                        </form>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Lista de prestamos</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content inspinia-timeline" style="display: block;">
                                <div class="timeline-item">
                                    <div class="row" id="tabla-prestamo">
                                        <div id="mensajeTabla"></div>
                                        <div id='tabla'></div>   
                                        <div id='paginacion'></div>                                        
                                    </div>
                                </div>       
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-9" id="bloque-detalle" style="display:none">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Detalle del prestamo</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content inspinia-timeline">
                                <div class="timeline-item" id="tabla-detalle">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <strong>No. Prestamo.</strong>
                                            <span id="detalle-no-prestamo"></span>
                                        </div>
                                        <div class="col-lg-4">
                                            <strong>Cliente.</strong>
                                            <span id="detalle-cliente"></span>
                                        </div>

                                        <div class="col-lg-4">
                                            <strong>Tipo de prestamo.</strong>
                                            <span id="detalle-tipo-prestamo"></span>
                                        </div>
                                        <div class="col-lg-4">
                                            <strong>Forma de pago.</strong>
                                            <span id="detalle-forma-pago"></span>
                                        </div>
                                        <div class="col-lg-4">
                                            <strong>Estado de pago.</strong>
                                            <span id="detalle-estado-pago"></span>
                                        </div>

                                        <div class="col-lg-4">
                                            <strong>Intereses.</strong>
                                            <span id="detalle-intereses"></span>
                                        </div>
                                        <div class="col-lg-4">
                                            <strong>No. Cuotas.</strong>
                                            <span id="detalle-no-cuotas"></span>
                                        </div>
                                        <div class="col-lg-4">
                                            <strong>Monto solicitado.</strong>
                                            <span id="detalle-monto"></span>
                                        </div>

                                        <div class="col-lg-4">
                                            <strong>Total intereses.</strong>
                                            <span id="detalle-total-intereses"></span>
                                        </div>
                                        <div class="col-lg-4">
                                            <strong>Total.</strong>
                                            <span id="detalle-total"></span>
                                        </div>
                                        <div class="col-lg-4">
                                            <strong>Total saldo pagado.</strong>
                                            <span id="total-saldo-pagado"></span>
                                        </div>

                                        <div class="col-lg-4">
                                            <strong>Total a pagar.</strong>
                                            <span id="total-a-pagar"></span>
                                        </div>

                                        <div class="col-lg-12">
                                            <br>
                                            <p>
                                                Para realizar pagos con un valor superior al saldo de la fecha de pago presione
                                                <a id="" onClick="Api.LoanDetail.showPaymentWithHigherValue()">
                                                    <span class="enlace">Aquí</span>.
                                                </a>
                                                &nbsp;Si quieres hacer una refinanciación de este prestamo presione
                                                <a id="btn-refinanciar" onClick="">
                                                    <span class="enlace">Aquí</span>.
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <input type="hidden" id="id-prestamo-detalle">
                                            <div id="mensaje-tabla-detalle"></div>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div id='tabla-prestamo-detalle'></div>
                                        <div id='paginacion-detalle'></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-3" id="bloque-pago" style="display: none;">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Pago de cuota</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content inspinia-timeline">
                                <div class="timeline-item">
                                    <div class="row">
                                        <form id="formulario-pago">
                                            <div class="col-lg-12">
                                                <div id="mensaje-pago"></div>
                                                <div class="form-group">
                                                    <label>Valor a pagar</label>
                                                    <div>
                                                        <input type="text" id="monto-pagado" name="monto_pagado" class="form-control m-b numerico" required>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Observación</label>
                                                    <div>
                                                        <textarea class="form-control m-b" name="observacion" id="" rows="5"></textarea>
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary btn-guardar" type="button" onClick="Api.Loan.savePaymentLoan()" style="display:none;">
                                                    <i class="fa fa-floppy-o"></i>&nbsp;
                                                    Pagar cuota
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-3" id="bloque-pago-valor-superior" style="display: none;">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Pago de valor superior</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content inspinia-timeline">
                                <div class="timeline-item">
                                    <div class="row">
                                        <form id="formulario-pago-superior">
                                            <div class="col-lg-12">
                                                <div id="mensaje-pago-superior"></div>
                                                <div class="form-group">
                                                    <label>Saldo a pagar</label>
                                                    <div>
                                                        <input type="text" name="saldo" class="form-control m-b" required>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Observación</label>
                                                    <div>
                                                        <textarea class="form-control m-b" name="observacion" id="" rows="5"></textarea>
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary btn-guardar" type="button" onClick="Api.LoanDetail.savePaymentWithHigherValue()" style="display:none;">
                                                    <i class="fa fa-floppy-o"></i>&nbsp;
                                                    Pagar
                                                </button>
                                            </div>
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
    <!-- Fin contenido de la pagina -->

    <!-- Modals -->
    <!-- Simular credito -->
    <div id="modal-simular-credito" class="modal fade" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title">&nbsp;Simulador de prestamo</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <strong>Cliente. </strong>
                            <span id="simulacion-nombre-cliente"></span>
                            &nbsp;&nbsp;&nbsp;
                            <strong>Forma de pago. </strong>
                            <span id="simulacion-forma-pago"></span>
                            &nbsp;&nbsp;&nbsp;
                            <strong>Tipo de prestamo. </strong>
                            <span id="simulacion-tipo-prestamo"></span>
                            <br>
                            <strong>Monto. </strong>
                            <span id="simulacion-monto"></span>
                            &nbsp;&nbsp;&nbsp;
                            <strong>Interes. </strong>
                            <span id="simulacion-intereses"></span>
                            &nbsp;&nbsp;&nbsp;
                            <strong>No. Cuotas. </strong>
                            <span id="simulacion-cuotas"></span>
                            &nbsp;&nbsp;&nbsp;
                            <strong>Total interes. </strong>
                            <span id="simulacion-total-interes"></span>
                            &nbsp;&nbsp;&nbsp;
                            <strong>Total general. </strong>
                            <span id="simulacion-total-general"></span>

                            <br>
                            <button class="btn btn-info float-right" onclick="Api.Prestamo.descargarSimulacionPrestamo()">
                                <i class="fa fa-cloud-download"></i>
                                &nbsp;
                                Descargar
                            </button>
                            <br>
                            <br>
                            <div class="table-responsive" id="tabla-simulacion-prestamo">
                                <table class="table table-bordered table-hover table-striped tablesorter">
                                    <thead>
                                        <tr>
                                            <th>No. Cuota</th>
                                            <th>Fecha pago</th>
                                            <th>Valor</th>
                                            <th>Intereses</th>
                                            <th>Total a pagar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <form id="form-descargar-simulacion" method=POST action="pdf" target="_blank">
                                {{ csrf_field() }}
                                <input type="hidden" name="crud" value="true">
                                <input type="hidden" name="controlador" value="Prestamo">
                                <input type="hidden" name="carpetaControlador" value="Prestamo">
                                <input type="hidden" name="funcionesVariables" value="DescargarSimulacion">
                                <input type="hidden" id="encabezado" name="encabezado" value="">
                                <input type="hidden" id="tabla" name="tabla" value="">
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin simular credito -->
    <!-- Refinanciación -->
    <div id="modal-refinanciacion" class="modal fade" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title">&nbsp;Refinanciar prestamo</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <strong>Cliente. </strong>
                            <span id="refinanciacion-nombre-cliente"></span>
                            &nbsp;&nbsp;&nbsp;
                            <strong>Forma de pago. </strong>
                            <span id="refinanciacion-forma-pago"></span>
                            &nbsp;&nbsp;&nbsp;
                            <strong>Tipo de prestamo. </strong>
                            <span id="refinanciacion-tipo-prestamo"></span>
                            &nbsp;&nbsp;&nbsp;
                            <strong>Monto. </strong>
                            <span id="refinanciacion-monto"></span>
                            <br>
                            <input type="hidden" id="refinanciar-monto">
                            <input type="hidden" id="refinanciar-intereses">
                            <input type="hidden" id="refinanciar-id-forma-pago">
                            <input type="hidden" id="refinanciar-id-tipo-prestamo">
                            <input type="hidden" id="refinanciar-siguiente-cuota">
                            <input type="hidden" id="refinanciar-nueva-cuota">
                            <br>
                            <br>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Fecha pago inicial.</label>
                                <div>
                                    <input type="date" id="fecha-inicial" class="form-control m-b" value="{{date('Y-m-d')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>Cuotas.</label>
                                <div>
                                    <input type="text" id="cuotas" data-numero-minimo="" class="form-control m-b numerico" value="1">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <div>
                                    <button class="btn btn-success " type="button" onClick="Api.Prestamo.simularRefinanciacion()">
                                        <i class="fa fa-list-alt"></i>&nbsp;
                                        Generar Refinanciación
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div id="mensaje"></div>
                            <br>
                            <div class="table-responsive" id="tabla-refinanciacion">
                                <table class="table table-bordered table-hover table-striped tablesorter">
                                    <thead>
                                    <tr>
                                        <th class="centrado">No. Cuota</th>
                                        <th class="centrado">Fecha pago</th>
                                        <th class="centrado">Capital</th>
                                        <th class="centrado">Amortizacion</th>
                                        <th class="centrado">Intereses</th>
                                        <th class="centrado">Total a pagar</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                            <br>
                            <div class="form-group">
                                <label>Observación.</label>
                                <div>
                                    <textarea id="observacion" class="form-control" rows="5"></textarea>
                                </div>
                            </div>
                            <button id="btn-guardar-refinanciacion" class="btn btn-primary btn-guardar" type="button" onclick="">
                                <i class="fa fa-refresh"></i>&nbsp;
                                Guardar Refinanciación
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Refinanciación -->
    <!-- Ver mas detalle del prestamo -->
    <div id="modal-detalle-prestamo" class="modal fade" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title">&nbsp;Detalle del prestamo No.<span id="no-prestamo"></span></h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12" id="mdp-mensaje">
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Fecha de pago</label>
                                <div>
                                    <input type="date" id="fecha-pago" class="form-control m-b">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Capital.</label>
                                <div>
                                    <input type="text" id="capital" class="form-control m-b" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Amortización.</label>
                                <div>
                                    <input type="text" id="amortizacion" class="form-control m-b" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Intereses.</label>
                                <div>
                                    <input type="text" id="intereses" class="form-control m-b" disabled>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Total.</label>
                                <div>
                                    <input type="text" id="total" class="form-control m-b" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Valor pagado.</label>
                                <div>
                                    <input type="text" id="valor-pagado" class="form-control m-b" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Persona que actualizó</label>
                                <div>
                                    <input type="text" id="persona" class="form-control m-b" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Fecha y hora que actualizó.</label>
                                <div>
                                    <input type="text" id="fecha-alteracion" class="form-control m-b" disabled>
                                </div>
                            </div>
                        </div>

                        <div id="magnification" style="display:none;">
                            <div class="col-lg-12">
                                <br>
                                <label>Ampliación para los días retrasados (saldo / 30 * días).</label>
                                <br>
                                <br>
                            </div>

                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Saldo.</label>
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon1">$</span>
                                        <input type="text" id="valor-intereses" class="form-control m-b" min="1">
                                    </div>
                                </div>
                                <br>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Días.</label>
                                    <div>
                                        <input type="text" id="dias" class="form-control m-b numerico" min="1" max="999" value="0" onkeyup="Api.LoanDetail.calculateMagnification()">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Resultado.</label>
                                    <div>
                                        <input type="text" id="result-magnification" class="form-control m-b numerico">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Observación.</label>
                                <div>
                                    <textarea id="observacion" class="form-control m-b" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button id="botonActualizar" class="btn btn-primary " type="button" onclick="" style="">
                                <i class="fa fa-floppy-o"></i>&nbsp;
                                Actualizar
                            </button>
                            <button id="botonSimular" class="btn btn-success " type="button" onClick="Api.LoanDetail.showMagnification()">
                                <i class="fa fa-usd"></i>&nbsp;
                                Ampliación
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin ver mas detalle del prestamo -->
    <!-- Fin Modals -->

@endsection

@section('script')
    <script type="text/javascript" src="{{asset('js/si/prestamo/calculos.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/si/prestamo/prestamo.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/si/prestamo/prestamo-detalle-pago.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/si/prestamo/prestamo-detalle.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/si/prestamo/prestamosPagos.js')}}"></script>
    <script>
        llenarInputsGuardar();
        listado();
        _verificarPermisos();
    </script>
@endsection