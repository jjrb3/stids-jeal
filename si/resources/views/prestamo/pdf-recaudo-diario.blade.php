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
            font-size: 12px;
            background-color: #F5F5F6;
        }

        .table-bordered > tbody > tr > td {
            font-size: 11px;
            color: #2f4050;
        }

        .pie-tabla {
            text-align: center;
            font-size: 12px!important;
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
    <img src="{{asset("recursos/imagenes/empresa_logo/$logo_empresa")}}" height="100" width="280" class="float-right">
    <div class="titulo">Recaudo Diario</div>
    <div class="subtitulo">Reporte de Recaudo por día seleccinado. </div>
    <br>
    <div class="texto">
        <strong>Fecha:</strong> {{$fecha}}.
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
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Teléfono</th>
            <th>No. Prestamo</th>
            <th>Fecha ultimo pago</th>
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
                    <td>{{$r->nombres}}</td>
                    <td>{{$r->apellidos}}</td>
                    <td align="center">{{$r->telefono}}</td>
                    <td align="center">{{$r->no_prestamo}}</td>
                    <td align="center">{{$r->fecha_abonado}}</td>
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
            <td colspan="7" class="pie-tabla">Total</td>
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