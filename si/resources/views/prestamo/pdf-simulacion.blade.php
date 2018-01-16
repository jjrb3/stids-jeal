<html>
<head>
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
            text-align: justify;
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

        .generado {
            text-align: justify;
            font-size: 14px;
        }
    </style>
<body>
<header>
    <img src="{{asset("recursos/imagenes/empresa_logo/$logo_empresa")}}" height="100" width="280" class="float-right">
    <div class="titulo">Simulación de Prestamo</div>
    <div class="subtitulo">
        Prestamo solicitado por el cliente <strong>{{$encabezado[0]}}</strong>
        con fecha de inicio de pago el <strong>{{substr($encabezado[8],8,2)}}</strong> de <strong>{{$meses[substr($encabezado[8],5,2)]}}</strong> de <strong>{{substr($encabezado[8],0,4)}}</strong>.</div>
    <br>
    <div class="texto">
        <strong>Tipo de Prestamo:</strong> {{$encabezado[1]}}.
        &nbsp;&nbsp;&nbsp;
        <strong>Pago:</strong> {{$encabezado[2]}}.
        &nbsp;&nbsp;&nbsp;
        <strong>Monto:</strong> ${{number_format($encabezado[3])}}.
        &nbsp;&nbsp;&nbsp;
        <strong>Interes:</strong> {{$encabezado[5]}}%.
        &nbsp;
        <strong>No. Cuotas:</strong> {{$encabezado[4]}}.
    </div>
</header>
<footer>
    <table>
        <tr>
            <td>
                <p class="izq">
                    {{$nombre_empresa}} -
                <span class="generado">Generador por {{$usuario_generador}} {{date('Y-m-d H:i:s')}}</span>.
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

    <table class="table table-bordered table-hover table-striped tablesorter" cellpadding="0" cellspacing="0">
        <thead>
        <tr>
            <th>No. Cuota</th>
            <th>Fecha de Pago</th>
            <th>Capital</th>
            <th>Amortizacion a Capital</th>
            <th>Intereses</th>
            <th>Total a Pagar</th>
        </tr>
        </thead>
        <tbody>
            @foreach($tabla as $r)
                @php($columna = explode(';',$r))
                <tr>
                    <td align="center">{{$columna[0]}}</td>
                    <td align="center">{{$columna[1]}}</td>
                    <td align="center">${{number_format($columna[2])}}</td>
                    <td align="center">${{number_format($columna[3])}}</td>
                    <td align="center">${{number_format($columna[4])}}</td>
                    <td align="center">${{number_format($columna[5])}}</td>
                </tr>
            @endforeach
        <tr>
            <td colspan="3" class="pie-tabla">Total</td>
            <td align="center">${{number_format($encabezado[3])}}</td>
            <td align="center">${{number_format($encabezado[6])}}</td>
            <td align="center">${{number_format($encabezado[7])}}</td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>