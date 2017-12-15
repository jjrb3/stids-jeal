@extends('temas.stids_usuario')

@section('meta-seo')
    <meta name="keywords" content="stids, desarrollo de proyectos web, desarrollo de diseño web, desarrollo de pagina web, calidad de desarrollo web, desarrollo web en Laravel, posicionamiento efectivo con seo" />
    <meta name="description" content="En Stids diseñamos y desarrollamos plataformas digitales, acorde a los objetivos y metas de cada cliente.">
@endsection

@section('content') 

    <section id="main-slider" class="no-margin">
        <div class="carousel slide wet-asphalt">
            <ol class="carousel-indicators">
                <li data-target="#main-slider" data-slide-to="0" class="active"></li>
                <li data-target="#main-slider" data-slide-to="1"></li>
                <li data-target="#main-slider" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="item active" style="background-image: url({{asset('temas/stids/img/slider/bg1.jpg')}}">
                    <div class="container">
                        <div class="row">
                             <div class="col-sm-6">
                                <div class="carousel-content center centered">
                                    <h2 class="boxed animation animated-item-1">NECESITAS DESARROllAR UN SISTEMA EN TU EMPRESA?</h2>
                                    <p class="boxed animation animated-item-2">En Stids contamos con ingenieros desarrolladores especializados que le brindaran calidad y seguridad a sus proyectos</p>
                                    <br> <a style="color: #fff;" class="btn btn-md animation animated-item-3" href="servicios">Ver mas</a>
                                    <br>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--/.item-->
                <div class="item" style="background-image: url({{asset('temas/stids/img/slider/bg2.jpg')}}">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="carousel-content center centered">
                                     <h2 class="boxed animation animated-item-1">BUSCAS CREATIVIDAD PARA TU EMPRESA?</h2>
                                    <p class="boxed animation animated-item-2">Contamos con diseñadores especializados que brindan diseños impactantes para la publicidad de tu empresa</p>

                                    <br>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--/.item-->
                <div class="item" style="background-image: url({{asset('temas/stids/img/slider/bg3.jpg')}}">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="carousel-content center centered">
                                    <h2 class="boxed animation animated-item-1">DESARROLLAMOS TU APLICATIVO WEB</h2>
                                    <p class="boxed animation animated-item-2">Nuestras manos están hechas para desarrollar grandes cosas.<br> Nosotros nos encargamos de realizar tú aplicativo web con los lenguajes de programación correspondientes a las necesidades que tengas tú  o tu empresa<br> <a class="btn btn-md animation animated-item-3" href="servicios">Mas servicios</a></p>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--/.item-->
            </div><!--/.carousel-inner-->
        </div><!--/.carousel-->
        <a class="prev hidden-xs" href="#main-slider" data-slide="prev">
            <i class="icon-angle-left"></i>
        </a>
        <a class="next hidden-xs" href="#main-slider" data-slide="next">
            <i class="icon-angle-right"></i>
        </a>
    </section><!--/#main-slider-->

    <section id="services" class="emerald">
        <div class="container">
            <div class="row">
            <center> <h3 style="color: #1f9b83;" class="media-heading">DISEÑAMOS Y DESARROLLAMOS<br>
                                               PLATAFORMAS DIGITALES</h3></center>
                <center><img class="img-responsive" src="{{asset('temas/stids/img/que_hacemos.png')}}" width="250" alt=""></center> 
                <div class="col-md-6 col-md-offset-3 "> 
                 <div class="media-body">
                     <p style="color:#000; ">En Stids S.A.S diseñamos y desarrollamos plataformas digitales, acorde a los objetivos y metas de cada cliente. Nos destacamos por ser innovadores y prolijos en términos de códigos, administración y gestión de proyectos digitales. Desarrollamos aplicaciones, sistemas informáticos y software a medida para gestión interna de empresas y procesos de negocio (Intranet/Extranet) que cubran sus necesidades<p>
                 </div>                
                </div><!--/.col-md-4-->
                 
            </div>
        </div>
    </section><!--/#services-->

    <section id="recent-works">
        <div class="container">
        <div class="row">
                   <center> <div class="col-md-12">
                    <h3 style="color: white;">NUESTRAS HERRAMIENTAS</h3>
                    <p style="color: white;">Contamos con variedades de herramientas para desarrollar su sitio de una forma eficaz y segura.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div id="scroller" class="carousel slide">
                        <div class="carousel-inner">
                            <div class="item active">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <div class="portfolio-item">
                                            <div class="item-inner">
                                                <img class="img-responsive" src="{{asset('temas/stids/img/herramientas/html5.png')}}" alt="">
                                                <h5>
                                                   <center> HTML5 </center>
                                                </h5>
                                                <div class="overlay">
                                                    <a class="preview btn btn-danger" title="" href="{{asset('temas/stids/img/herramientas/html5.png')}}" rel="prettyPhoto"><i class="icon-eye-open"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                            
                                    <div class="col-xs-4">
                                        <div class="portfolio-item">
                                            <div class="item-inner">
                                                <img class="img-responsive" src="{{asset('temas/stids/img/herramientas/php7.png')}}" alt="">
                                                <h5>
                                                    <center> PHP7 </center>
                                                </h5>
                                                <div class="overlay">
                                                    <a class="preview btn btn-danger" title="" href="{{asset('temas/stids/img/herramientas/php7.png')}}" rel="prettyPhoto"><i class="icon-eye-open"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                            
                                    <div class="col-xs-4">
                                        <div class="portfolio-item">
                                            <div class="item-inner">
                                                <img class="img-responsive" src="{{asset('temas/stids/img/herramientas/javascript.png')}}" alt="">
                                                <h5>
                                                    <center> JAVASCRIPT </center>
                                                </h5>
                                                <div class="overlay">
                                                    <a class="preview btn btn-danger" title="" href="{{asset('temas/stids/img/herramientas/javascript.png')}}" rel="prettyPhoto"><i class="icon-eye-open"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                     
                                </div><!--/.row-->
                            </div><!--/.item-->
                            <div class="item">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <div class="portfolio-item">
                                            <div class="item-inner">
                                                <img class="img-responsive" src="{{asset('temas/stids/img/herramientas/jquery.png')}}" alt="">
                                                <h5>
                                                    <center> JQUERY </center>
                                                </h5>
                                                <div class="overlay">
                                                    <a class="preview btn btn-danger" title="" href="{{asset('temas/stids/img/herramientas/jquery.png')}}" rel="prettyPhoto"><i class="icon-eye-open"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 

                                      <div class="col-xs-4">
                                        <div class="portfolio-item">
                                            <div class="item-inner">
                                                <img class="img-responsive" src="{{asset('temas/stids/img/herramientas/css3.png')}}" alt="">
                                                <h5>
                                                   <center> CSS3 </center>
                                                </h5>
                                                <div class="overlay">
                                                    <a class="preview btn btn-danger" title="" href="{{asset('temas/stids/img/herramientas/css3.png')}}" rel="prettyPhoto"><i class="icon-eye-open"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                           
                                   

                                      <div class="col-xs-4">
                                        <div class="portfolio-item">
                                            <div class="item-inner">
                                                <img class="img-responsive" src="{{asset('temas/stids/img/herramientas/photoshop.png')}}" alt="">
                                                <h5>
                                                    <center> PHOTOSHOP </center>
                                                </h5>
                                                <div class="overlay">
                                                    <a class="preview btn btn-danger" title="" href="{{asset('temas/stids/img/herramientas/photoshop.png')}}" rel="prettyPhoto"><i class="icon-eye-open"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>  
                                </div>
                            </div><!--/.item-->
                            <div class="item">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <div class="portfolio-item">
                                            <div class="item-inner">
                                                <img class="img-responsive" src="{{asset('temas/stids/img/herramientas/mysql.png')}}" alt="">
                                                <h5>
                                                    <center> MYSQL </center>
                                                </h5>
                                                <div class="overlay">
                                                    <a class="preview btn btn-danger" title="" href="{{asset('temas/stids/img/herramientas/mysql.png')}}" rel="prettyPhoto"><i class="icon-eye-open"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 

                                        <div class="col-xs-4">
                                        <div class="portfolio-item">
                                            <div class="item-inner">
                                                <img class="img-responsive" src="{{asset('temas/stids/img/herramientas/laravel.png')}}" alt="">
                                                <h5>
                                                    <center> LARAVEL </center>
                                                </h5>
                                                <div class="overlay">
                                                    <a class="preview btn btn-danger" title="" href="{{asset('temas/stids/img/herramientas/laravel.png')}}" rel="prettyPhoto"><i class="icon-eye-open"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

 
                                     
                                </div>
                            </div><!--/.item-->
                        </div>
                    </div>
                </div>    

            </div><!--/.row-->

               <div class="row">
                   <center> <div class="col-md-12">
                    <div class="btn-group">
                        <a class="btn btn-danger" href="#scroller" data-slide="prev"><i class="icon-angle-left"></i></a>
                        <a class="btn btn-danger" href="#scroller" data-slide="next"><i class="icon-angle-right"></i></a>
                    </div>
                    <p class="gap"></p>
                </div>
            </div>

        </div>
    </section><!--/#recent-works-->

    <section id="testimonial" class="alizarin">
      <div class="container">
<div class="row ">
<div class="col-md-8 col-md-offset-2 text-center">
<h2 style="color: #1f9b83;" class="tituloskimber">NUESTROS SERVICIOS</h2>
<div class="divider"></div>
<p style="color: #000;">Contamos con una cantidad de servicios que nos caracterizan por sobresalir eficientemente en el mercado y que nosotros nos encargamos de brindarles a nuestros clientes.</p>
</div>
<div class="col-md-4 ">
<div class="service_block pv-30 ph-20 service-block bordered shadow text-center object-non-visible animated object-visible fadeInDownSmall" data-animation-effect="fadeInDownSmall" data-effect-delay="100">
<img src="{{asset('temas/stids/img/servicios/desarrolloweb.png')}}" width="200px">
<h3 style="color: #1f9b83;">DESARROLLO WEB PHP</h3>
<div class="divider clearfix"></div>
<p style="color: #000;">Aplicaciones Web con un lenguaje flexible, potente, seguro y de alto rendimiento.</p>
<a style="color: #1f9b83;" href="services.html">Ver mas <i class="pl-5 fa fa-angle-double-right"></i></a>
</div>
</div>
<div class="col-md-4 ">
<div class="service_block pv-30 ph-20 service-block bordered shadow text-center object-non-visible animated object-visible fadeInDownSmall" data-animation-effect="fadeInDownSmall" data-effect-delay="150">
<img src="{{asset('temas/stids/img/servicios/base.png')}}" width="200px">
<h3 style="color: #1f9b83;">SISTEMA DE GESTIÓN DE BASE DE DATOS</h3>
<div class="divider clearfix"></div>
<p style="color: #000;">Sistema de base de datos relacionales rápida y segura para el almacenamiento de su información.</p>
<a style="color: #1f9b83;" href="services.html">Ver mas<i class="pl-5 fa fa-angle-double-right"></i></a>
</div>
</div>
<div class="col-md-4 ">
<div class="service_block pv-30 ph-20 service-block bordered shadow text-center object-non-visible animated object-visible fadeInDownSmall" data-animation-effect="fadeInDownSmall" data-effect-delay="200">
<img src="{{asset('temas/stids/img/servicios/responsivo.png')}}" width="200px">
<h3 style="color: #1f9b83;">DISEÑO WEB RESPONSIVE</h3>
<div class="divider clearfix"></div>
<p style="color: #000;">Aplicaciones web optimizadas para dispositivos móviles, tabletas y resoluciones de monitores grandes, medianos y pequeños.</p>
<a style="color: #1f9b83;" href="services.html">Ver mas <i class="pl-5 fa fa-angle-double-right"></i></a>
</div>
</div>
</div>

<div class="row ">
<div class="col-md-4 ">
<div class="service_block pv-30 ph-20 service-block bordered shadow text-center object-non-visible animated object-visible fadeInDownSmall" data-animation-effect="fadeInDownSmall" data-effect-delay="100">
<img src="{{asset('temas/stids/img/servicios/posisionamiento.png')}}" width="200px">
<h3 style="color: #1f9b83;">POSICIONAMIENTO</h3>
<div class="divider clearfix"></div>
<p style="color: #000;">Hacemos que tu sitio web ocupe los primeros lugares utilizando distintas estrategias para ello.</p>
<a style="color: #1f9b83;" href="services.html">Ver mas <i class="pl-5 fa fa-angle-double-right"></i></a>
</div>
</div>
<div class="col-md-4 ">
<div class="service_block pv-30 ph-20 service-block bordered shadow text-center object-non-visible animated object-visible fadeInDownSmall" data-animation-effect="fadeInDownSmall" data-effect-delay="150">
<img src="{{asset('temas/stids/img/servicios/redes.png')}}" width="200px">
<h3 style="color: #1f9b83;">REDES Y MANTENIMIENTO</h3>
<div class="divider clearfix"></div>
<p style="color: #000;">Brindamos soporte y mantenimiento de redes y computadores.</p>
<a style="color: #1f9b83;" href="services.html">Ver mas<i class="pl-5 fa fa-angle-double-right"></i></a>
</div>
</div>
<div class="col-md-4 ">
<div class="service_block pv-30 ph-20 service-block bordered shadow text-center object-non-visible animated object-visible fadeInDownSmall" data-animation-effect="fadeInDownSmall" data-effect-delay="200">
<img src="{{asset('temas/stids/img/servicios/seguridad.png')}}" width="200px">
<h3 style="color: #1f9b83;">SEGURIDAD</h3>
<div class="divider clearfix"></div>
<p style="color: #000;">Desarrollamos con estándares de seguridad y ofrecemos servicio de instalación de camaras de seguridad.</p>
<a style="color: #1f9b83;" href="services.html">Ver mas <i class="pl-5 fa fa-angle-double-right"></i></a>
</div>
</div>
</div>



</div>
    </section><!--/#testimonial-->




    <section id="recent-works">
        <div class="container">
        <div class="row">
                   <center> <div class="col-md-12">
                    <h3 style="color: white;">NUESTROS PLANES</h3>
                    <p style="color: white;">Contamos con distintos planes para brindarle a nuestros clientes alternativas<br> que se acomoden a sus necesidades y presupuesto.</p>
                </div>
            </div>
           <section id="pricing">
        <div class="container">
            <div class="gap"></div>
            <div id="pricing-table" class="row">
                <div class="col-md-3">
                    <ul class="plan plan1">
                        <li class="plan-name">
                            <h3>Básico</h3>
                        </li>
                        <li class="plan-price">
                            <div>
                                <span class="price"><sup>$</sup>0.75</span>
                                <small>Anual</small>
                            </div>
                        </li>
                        <li>
                            <strong> 4 </strong> Enlaces
                        </li>
                        <li>
                            <strong>N°.</strong> Imagenes estáticas
                        </li>
                        <li>
                            <strong>7</strong> Correos Corporativos
                        </li>
                        <li>
                            <strong>Diseño</strong> Responsive
                        </li>
                        <li>
                            <strong>Soporte</strong>  5 dias
                        </li>
                        <li class="plan-action">
                            <a href="#" class="btn btn-primary btn-md">Elegir Plan</a>
                        </li>
                    </ul>
                </div><!--/.col-md-3-->
                <div class="col-md-3">
                    <ul class="plan plan2 featured">
                        <li class="plan-name">
                            <h3>Estándar</h3>
                        </li>
                        <li class="plan-price">
                            <div>
                                <span class="price"><sup>$</sup>0.95</span>
                                <small>Anual</small>
                            </div>
                        </li>
                         <li>
                            <strong> 6</strong> Enlaces
                        </li>
                        <li>
                            <strong>N°.</strong> Imagenes rotativas
                        </li>
                        <li>
                            <strong>10</strong> Correos Corporativos
                        </li>
                        <li>
                            <strong>Diseño</strong> Responsive
                        </li>
                        <li>
                            <strong>Soporte</strong>  5 dias
                        </li>
                        <li class="plan-action">
                            <a href="#" class="btn btn-primary btn-md">Elegir Plan</a>
                        </li>
                    </ul>
                </div><!--/.col-md-3-->
                <div class="col-md-3">
                    <ul class="plan plan3">
                        <li class="plan-name">
                            <h3>Avanzado</h3>
                        </li>
                        <li class="plan-price">
                            <div>
                                <span class="price"><sup>$</sup>1.4</span>
                                <small>Anual</small>
                            </div>
                        </li>
                         <li>
                            <strong> 8 </strong> Enlaces + panel administrativo
                        </li>
                        <li>
                            <strong>N°.</strong> Cambio de imagenes + información 
                        </li>
                        <li>
                            <strong>15</strong> Correos Corporativos
                        </li>
                        <li>
                            <strong>Diseño</strong> Responsive + filtros
                        </li>
                        <li>
                            <strong>Soporte</strong>  10 dias
                        </li>
                        <li class="plan-action">
                            <a href="#" class="btn btn-primary btn-md">Elegir Plan</a>
                        </li>
                    </ul>
                </div><!--/.col-md-3-->
                <div class="col-md-3">
                    <ul class="plan plan4">
                        <li class="plan-name">
                            <h3>Pro</h3>
                        </li>
                        <li class="plan-price">
                            <div>
                                <span class="price"><sup>$</sup>1.8</span>
                                <small>Anual</small>
                            </div>
                        </li>
                         <li>
                            <strong>N°. </strong> Enlaces + panel administrativo
                        </li>
                        <li>
                            <strong>N</strong> Imagenes + cambio de información
                        </li>
                        <li>
                            <strong>20</strong> Correos Corporativos
                        </li>
                        <li>
                            <strong>Diseño</strong> Responsive + efectos ultimate
                        </li>
                        <li>
                            <strong>Soporte</strong>  15 dias
                        </li>
                        <li class="plan-action">
                            <a href="#" class="btn btn-primary btn-md">Elegir Plan</a>
                        </li>
                    </ul>
                </div><!--/.col-md-3-->
            </div> 
        </div>
    </section><!--/#pricing-->

        </div>
    </section><!--/#recent-works-->


    <!-- clientes -->
    <section id="testimonial" class="alizarin">
      <div class="container">
<div class="row ">
    <div class="col-md-8 col-md-offset-2 text-center">
    <h2 style="color: #1f9b83;" class="tituloskimber">NUESTROS CLIENTES</h2>
    <div class="divider"></div>
    <p style="color: #000;">Contamos con clientes que han depositado su confianza en nosotros.</p>
    </div>
    <marquee SCROLLAMOUNT="10">
    <div class="col-md-3 ">
    <div class="" data-animation-effect="fadeInDownSmall" data-effect-delay="100">
    <img src="{{asset('temas/stids/img/clientes/vytech.png')}}" width="200px">
    </div>
    </div>
    <div class="col-md-3 ">
    <div class="" data-animation-effect="fadeInDownSmall" data-effect-delay="150">
    <img src="{{asset('temas/stids/img/clientes/conipal.png')}}" width="200px">
    </div>
    </div>
    <div class="col-md-3 ">
    <div class="" data-animation-effect="fadeInDownSmall" data-effect-delay="200">
    <img src="{{asset('temas/stids/img/clientes/thermecs.png')}}" width="200px">
    </div>
    </div>
    <div class="col-md-3 ">
    <div class="" data-animation-effect="fadeInDownSmall" data-effect-delay="200">
    <img src="{{asset('temas/stids/img/clientes/plazabolivar.png')}}" width="200px">
    </div>
    </div>
    </marquee>

</div>

</div>
    </section><!--/#testimonial-->


@endsection