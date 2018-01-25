<html>
    <style>
        @page {
            margin: 160px 50px;
        }
        header {
            position: fixed;
            left: 0px;
            top: -160px;
            right: 0px;
            font-family: "open sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
        }

        footer {
            position: fixed;
            left: 0px;
            bottom: -100px;
            right: 0px;
            height: 0px;
            border-bottom: 2px solid #ddd;
        }
        footer .page:after {
            content: counter(page);
        }
        footer table {
            width: 100%;
        }
        footer p {
            text-align: right;
        }
        footer .izq {
            text-align: left;
        }

        .float-right {
            float: right;
        }
        .titulo {
            text-align: center;
            margin: 20px 0;
            font-size: 24px;
            font-weight: 600;
        }
        .subtitulo{
            text-align: center;
            font-size: 14px;
            margin-top: -10px;
            color: #2f4050;
            font-family: "open sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
        }
        .texto{
            text-align: justify;
            font-size: 14px;
            color: #2f4050;
        }
        .table-bordered > thead > tr > th,
        .table-bordered > tbody > tr > td{
            border: 1px solid #EBEBEB;
            padding: 3px;
        }

        .table-bordered > thead > tr > th {
            text-align: center;
            font-size: 11px;
            background-color: #F5F5F6;
        }

        .table-bordered > tbody > tr > td {
            font-size: 10px;
            color: #2f4050;
        }

        .pie-tabla {
            text-align: center;
            font-size: 11px!important;
            background-color: #F5F5F6;
            font-weight: 700!important;
        }

        .table{
            width: 100%;
            max-width: 100%;
            margin-bottom: 20px;
            font-family: "open sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
        }
        strong {
            color: #000;
        }
    </style>
<body>
<header>
    @if($logo_empresa)
        <img src="{{asset("recursos/imagenes/empresa_logo/$logo_empresa")}}" height="100" width="280" class="float-right">
    @endif
    <div class="titulo">Prestamos sin Completar</div>
    <div class="subtitulo">Reporte de prestamos que no han sido completados por rango de fecha.</div>
    <br>
    <div class="texto">
        <strong>Fecha inicial:</strong> {{$fecha_inicial}}.
        &nbsp;&nbsp;&nbsp;
        <strong>Fecha final:</strong> {{$fecha_final}}.
        &nbsp;&nbsp;&nbsp;
        <strong>Reporte generado por:</strong> {{$usuario_generador}}.
    </div>
</header>
<footer>
    <table>
        <tr>
            <td>
                <p class="izq">
                    {{$nombre_empresa}} -
                    <span class="generado">{{date('Y-m-d H:i:s')}}</span>.
                </p>
            </td>
            <td>
                <p class="page">
                    Página
                </p>
            </td>
        </tr>
    </table>
</footer>
<div id="content">
    @if($tabla)
    <table class="table table-bordered table-hover table-striped tablesorter" cellpadding="0" cellspacing="0">
        <thead>
        <tr>
            <th>#</th>
            <th>Identificación</th>
            <th>Clientes</th>
            <th>Telefono</th>
            <th>Fecha prestamo</th>
            <th>Cuotas</th>
            <th>Fecha de vencimiento</th>
            <th>Creado por</th>
            <th>Estado</th>
            <th>Valor</th>
            <th>Interes</th>
            <th>Valor total</th>
            <th>Deuda</th>
        </tr>
        </thead>
        <tbody>
            @php($totalValor = 0)
            @php($totalInteres = 0)
            @php($totalGeneral = 0)
            @php($totalDeuda = 0)
            @php($cnt = 1)
            @foreach($tabla as $r)
                <tr>
                    <td align="center">{{$cnt}}</td>
                    <td align="center">{{$r->identificacion}}</td>
                    <td>{{$r->cliente}}</td>
                    <td align="center">{{$r->telefono}}</td>
                    <td align="center">{{$r->fecha_prestamo}}</td>
                    <td align="center">{{$r->cuotas}}</td>
                    <td align="center">{{$r->fecha_vencimiento}}</td>
                    <td>{{$r->creado_por}}</td>
                    <td align="center">{{$r->estado}}</td>
                    <td align="center">${{number_format($r->valor)}}</td>
                    <td align="center">${{number_format($r->intereses)}}</td>
                    <td align="center">${{number_format($r->valor_total)}}</td>
                    <td align="center">${{number_format($r->deuda)}}</td>
                </tr>
                @php($totalValor += $r->valor)
                @php($totalInteres += $r->intereses)
                @php($totalGeneral += $r->valor_total)
                @php($totalDeuda += $r->deuda)
                @php($cnt++)
            @endforeach
        <tr>
            <td colspan="9" class="pie-tabla">Total</td>
            <td align="center">${{number_format($totalValor)}}</td>
            <td align="center">${{number_format($totalInteres)}}</td>
            <td align="center">${{number_format($totalGeneral)}}</td>
            <td align="center">${{number_format($totalDeuda)}}</td>
        </tr>
        </tbody>
    </table>
    @else

        <div class="subtitulo">No se encontraron resultados para esta busqueda.</div>
    @endif
</div>
</body>
</html>