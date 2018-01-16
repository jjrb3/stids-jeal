<!DOCTYPE html>
<html lang="es-ES">
<head>
    <!-- SEO -->
    <meta name="encoding" charset="utf-8">
    <meta name="application-name" content="Stids Jeal 2.0" />
    <meta name="author" content="Grupo Stids">
    <meta name="generator" content="Laravel 5.4" />
    <meta name="robots" content="index, follow" />

    @yield('meta-seo')
    <!-- Fin SEO -->

	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{$empresa['nombre_cabecera']}}</title>
	<link rel="icon" href="{{asset('temas')}}/{{$empresa['tema_nombre']}}/img/favicon.png" type="image/png">
	<link href="{{asset('temas/stids/css/bootstrap.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('temas/stids/css/style.css')}}" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link href="{{asset('temas/stids/bootstrap/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{asset('css/stids-jeal.css')}}" rel="stylesheet">

	<script type="text/javascript" src="{{asset('temas/stids/js/jquery.1.8.3.min.js')}}"></script>
	
</head>
<body style="background:url('{{asset("temas/stids/img/login.jpg")}}') no-repeat center center fixed;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;">
		
	@yield('content')
	
</body>
</html>