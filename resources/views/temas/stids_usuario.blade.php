<!DOCTYPE html>
<html lang="es-ES">
<head>
    <!-- SEO -->
    <meta name="encoding" charset="utf-8">
    <meta name="application-name" content="Stids 2.0" />
    <meta name="author" content="Grupo Stids">
    <meta name="generator" content="Laravel 5.4" />
    <meta name="robots" content="index, follow" />
    @yield('meta-seo')  
    <!-- Fin SEO -->
    <title>Stids</title>
    <link href="{{asset('temas/stids/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('temas/stids/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('temas/stids/css/prettyPhoto.css')}}" rel="stylesheet">
    <link href="{{asset('temas/stids/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('temas/stids/css/main.css')}}" rel="stylesheet">
    <link rel="shortcut icon" href="{{asset('temas/stids/img/ico/favicon.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{asset('temas/stids/img/ico/apple-touch-icon-144-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{asset('temas/stids/img/ico/apple-touch-icon-114-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{asset('temas/stids/img/ico/apple-touch-icon-72-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" href="{{asset('temas/stids/img/ico/apple-touch-icon-57-precomposed.png')}}">
    @yield('style-superior')
    @yield('script-superior')
<!-- analitic google -->
    <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-62288505-2', 'auto');
  ga('send', 'pageview');
    </script>   
<!-- end google analityc -->


</head><!--/head-->
<body>
    <header class="navbar navbar-inverse navbar-fixed-top wet-asphalt" role="banner">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html"><img src="{{asset('temas/stids/img/logo.png')}}" width="150" alt="logo"></a>
            </div>
            <div class="collapse navbar-collapse">
            	@php($ruta = explode('/', $_SERVER['REQUEST_URI']))
			   	@php($nombre = $ruta[count($ruta)-1])
			    
			    <ul class="nav navbar-nav navbar-right">
                    <li @if($nombre == 'inicio') class="active" @endif><a href="inicio">Inicio</a></li>
                    <li @if($nombre == 'nosotros') class="active" @endif><a href="nosotros">Nosotros</a></li>
                    <li @if($nombre == 'servicios') class="active" @endif><a href="servicios">Servicios</a></li>
                    <li @if($nombre == 'portafolio') class="active" @endif><a href="portafolio">Portafolio</a></li>
                    <li @if($nombre == 'noticias' || $nombre == 'ingresar') class="active" @endif class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Stids Jeal<i class="icon-angle-down" style="padding-left: 5px;"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="ingresar">Ingresar a Stids Jeal</a>&nbsp;&nbsp;</li>
                        </ul>
                    </li>
                    <li @if($nombre == 'contacto') class="active" @endif><a href="contacto">Contacto</a></li>
                </ul>
            </div>
        </div>
    </header><!--/header-->
   
   	@yield('content')

   <section id="bottom" class="wet-asphalt2">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <h4 style="color: white;">Nosotros</h4>
                    <p>Somos una empresa que desarrollamos plataformas digitales, acorde a los objetivos y metas de cada cliente brindandole soluciones tecnologícas e innovadoras.</p>
                </div><!--/.col-md-3-->

                <div class="col-md-3 col-sm-6">
                    <h4 style="color: white;">Compañia</h4>
                    <div>
                        <ul class="arrow">
                            <li><a style="color: white;" href="inicio">Inicio</a></li>
                            <li><a style="color: white;" href="nosotros">Nosotros</a></li>
                            <li><a style="color: white;" href="servicios">Servicios</a></li>
                            <li><a style="color: white;" href="portafolio">Portafolio</a></li>
                            <li><a style="color: white;" href="ingresar">Ingresar a Stids Jeal</a></li>
                            <li><a style="color: white;" href="contacto">Contacto</a></li>
                            <!--
                            <li><a style="color: white;" href="#">Politicas de Privacidad</a></li>
                            <li><a style="color: white;" href="#">Redes</a></li>
                            -->
                        </ul>
                    </div>
                </div><!--/.col-md-3-->

               
                <div class="col-md-3 col-sm-6">
                    <h4 style="color: white;">Noticias</h4>
                    <div>
                        <div class="media">
                            <!-- Insert this tInserta esta etiquera donde te gustaría renderizar el wid -->
                            <p>Si quieres enterarte de las ultimas noticias de nuestra empresa en este modulo, encontraras todas las noticias referentes a nosotros manteniendote informado<br><iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2FStids.SAS%2F&tabs=timeline&width=340&height=500&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" width="340" height="" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
                            <a style="color: white;" href="#">Click aquí para ver mas</a>
                            </p>
                        </div>
                   

                    </div>  
                </div><!--/.col-md-3-->

                <div class="col-md-3 col-sm-6">
                    <h4 style="color: white;">Situados</h4>
                    <address>
                        <strong> Barranquilla/Colombia</strong><br>
                     Instagram:  <a style="color: white;" href="https://www.instagram.com/stids.sas/">@Stids.sas</a> <br>
                     Facebook:  <a style="color: white;" href="https://www.facebook.com/Stids.SAS/">Stids SAS</a> <br>
                        <abbr title="Phone">Tel:</abbr> (+57) 3014954136<br>
                        <abbr title="Phone">Tel:</abbr> (+57) 3017597689<br>
                       <a style="color: white;" href="http://www.stids.net">www.stids.net</a> 
                    </address>
                  

                </div> <!--/.col-md-3-->
            </div>
        </div>
    </section><!--/#bottom-->

    <footer id="footer" class="midnight-blue">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                   <p style="color: white;"> &copy; Stids <a target="_blank" href="#" title=""></a> Siempre contigo</p>
                </div>
                <div class="col-sm-6">
                    <ul class="pull-right">
                        <li><a id="gototop" class="gototop" href="#"><i class="icon-chevron-up"></i></a></li><!--#gototop-->
                    </ul>
                </div>
            </div>
        </div>
    </footer><!--/#footer-->

    <!-- Mainly scripts -->
    <script src="{{asset('temas/stids/js/jquery.js')}}"></script>
    <script src="{{asset('temas/stids/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('temas/stids/js/jquery.prettyPhoto.js')}}"></script>

    @yield('script-inferior')
</body>
</html>