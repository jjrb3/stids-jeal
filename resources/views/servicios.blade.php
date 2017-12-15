@extends('temas.stids_usuario')

@section('meta-seo')
    <meta name="keywords" content="servicios, desarrollo web, gestion base de datos, diseño web, posicionamient" />
    <meta name="description" content="Enterate de cada uno de los servicios que ofrecemos.">
@endsection

@section('content') 
    
    <section id="title" class="cbe">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <h1 style="color: white;">Servicios</h1>
                    <p style="color: white;">Enterate de cada uno de los servicios que ofrecemos</p>
                </div>
                <div class="col-sm-6">
                    <ul class="breadcrumb pull-right">
                        <li><a href="inicio">Inicio</a></li>
                        <li class="active">Servicios</li>
                    </ul>
                </div>
            </div>
        </div>
    </section><!--/#title-->  

    <section id="services">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="center gap">
                        <h2 style="color: #1f9b83;">NUESTROS SERVICIOS</h2>
                        <p>Contamos con una cantidad de servicios que nos caracterizan por sobresalir eficientemente<br> en el mercado y que nosotros nos encargamos de brindarles a nuestros clientes.</p>
                    </div>                
                </div>
            </div>
            <div class="row">
                    <div class="col-md-4 ">
                    <div class="service_block pv-30 ph-20 service-block bordered shadow text-center object-non-visible animated object-visible fadeInDownSmall" data-animation-effect="fadeInDownSmall" data-effect-delay="100">
                    <img src="{{asset('temas/stids/img/servicios/desarrolloweb.png')}}" width="200px">
                    <h3 style="color: #1f9b83;">DESARROLLO WEB PHP</h3>
                    <div class="divider clearfix"></div>
                    <p style="color: #000;">Aplicaciones Web con un lenguaje flexible, potente, seguro y de alto rendimiento.</p>
                  
                    </div>
                    </div>
                    <div class="col-md-4 ">
                    <div class="service_block pv-30 ph-20 service-block bordered shadow text-center object-non-visible animated object-visible fadeInDownSmall" data-animation-effect="fadeInDownSmall" data-effect-delay="150">
                    <img src="{{asset('temas/stids/img/servicios/base.png')}}" width="200px">
                    <h3 style="color: #1f9b83;">SISTEMA DE GESTIÓN DE BASE DE DATOS</h3>
                    <div class="divider clearfix"></div>
                    <p style="color: #000;">Sistema de base de datos relacionales rápida y segura para el almacenamiento de su información.</p>
                   
                    </div>
                    </div>
                    <div class="col-md-4 ">
                    <div class="service_block pv-30 ph-20 service-block bordered shadow text-center object-non-visible animated object-visible fadeInDownSmall" data-animation-effect="fadeInDownSmall" data-effect-delay="200">
                    <img src="{{asset('temas/stids/img/servicios/responsivo.png')}}" width="200px">
                    <h3 style="color: #1f9b83;">DISEÑO WEB RESPONSIVE</h3>
                    <div class="divider clearfix"></div>
                    <p style="color: #000;">Aplicaciones web optimizadas para dispositivos móviles, tabletas y resoluciones de monitores grandes, medianos y pequeños.</p>
                   
                    </div>
                    </div>
            </div><!--/.row-->
            <div class="row ">
                    <div class="col-md-4 ">
                    <div class="service_block pv-30 ph-20 service-block bordered shadow text-center object-non-visible animated object-visible fadeInDownSmall" data-animation-effect="fadeInDownSmall" data-effect-delay="100">
                    <img src="{{asset('temas/stids/img/servicios/posisionamiento.png')}}" width="200px">
                    <h3 style="color: #1f9b83;">POSICIONAMIENTO</h3>
                    <div class="divider clearfix"></div>
                    <p style="color: #000;">Optimización de los proyectos webs a los principales buscadores, trabajamos en SEO orgánico analizando el nicho de mercado y las competencias de su negocio.</p>
                    
                    </div>
                    </div>
                    <div class="col-md-4 ">
                    <div class="service_block pv-30 ph-20 service-block bordered shadow text-center object-non-visible animated object-visible fadeInDownSmall" data-animation-effect="fadeInDownSmall" data-effect-delay="150">
                    <img src="{{asset('temas/stids/img/servicios/redes.png')}}" width="200px">
                    <h3 style="color: #1f9b83;">REDES Y MANTENIMIENTO</h3>
                    <div class="divider clearfix"></div>
                    <p style="color: #000;">Instalación de camaras de seguridad, servidores, servicio de telefonia, Diseñar, implementar y administrar los sistemas de monitoreo y
seguridad de los equipos de comunicación y los servicios de red.</p>
                    
                    </div>
                    </div>
                    <div class="col-md-4 ">
                    <div class="service_block pv-30 ph-20 service-block bordered shadow text-center object-non-visible animated object-visible fadeInDownSmall" data-animation-effect="fadeInDownSmall" data-effect-delay="200">
                    <img src="{{asset('temas/stids/img/servicios/seguridad.png')}}" width="200px">
                    <h3 style="color: #1f9b83;">SEGURIDAD</h3>
                    <div class="divider clearfix"></div>
                    <p style="color: #000;">Mantenemos seguros los datos almacenados en las plataformas con excelentes niveles de seguridad para la consulta, edición, modificación y eliminación de datos.</p>
                    
                    </div>
                    </div>
            </div><!--/.row-->

            <hr>
            <div class="row">
                <div class="col-lg-12">
                    <div class="center">
                        <h2 style="color: #1f9b83;">POR QUÉ ESCOGERNOS?</h2>
                        <p>Basicamente contamos con personal calificado en los distintos lenguajes y en dintintas áreas para realizar los proyectos asignados.</p>
                    </div>
                    <div class="gap"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <blockquote>
                                    
                 <div>
                    <div class="progress">
                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: 95%;">
                            <span>HTML/CSS -- 95%</span>
                        </div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 98%;">
                            <span>LARAVEL/BOOSTRAP -- 98%</span>
                        </div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                            <span>WORDPRESS/JOOMLA/MODDLE -- 50%</span>
                        </div>
                    </div>
                         <div class="progress">
                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 90%;">
                            <span>APLICACIONES MOVILES -- 90%</span>
                        </div>
                    </div>

                </div>
         
                            </blockquote>
                        </div>
                        <div class="col-md-6">
                            <blockquote>
                            
                             <div class="progress">
                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 93%;">
                            <span>MYSQL/SQL SERVER -- 93%</span>
                        </div>
                    </div>
                     <div class="progress">
                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100" style="width: 93%;">
                            <span>JAVASCRIPT/JQUERY -- 93%</span>
                        </div>
                    </div>
                     <div class="progress">
                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                            <span>PHP -- 100%</span>
                        </div>
                    </div>
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section><!--/#services-->

@endsection