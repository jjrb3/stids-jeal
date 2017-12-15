@extends('temas.stids_usuario')

@section('meta-seo')
    <meta name="keywords" content="nosotros, mision, vision, valores" />
    <meta name="description" content="Enterate quienes somos y que hacemos.">
@endsection

@section('content') 
    
    <section id="title" class="cbe">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <h1 style="color: white;">Nosotros</h1>
                    <p style="color: white;">Enterate quienes somos y que hacemos</p>
                </div>
                <div class="col-sm-6">
                    <ul class="breadcrumb pull-right">
                        <li><a href="inicio">Inicio</a></li>
                        <li class="active">Nosotros</li>
                    </ul>
                </div>
            </div>
        </div>
    </section><!--/#title-->

    <section id="about-us" class="container">
        <div class="row">
            <div class="col-sm-6">
                <h2>Nosotros</h2>
                <p>En Stids S.A.S diseñamos y desarrollamos plataformas digitales, acorde a los objetivos y metas de cada cliente. Nos destacamos por ser innovadores y prolijos en términos de códigos, administración y gestión de proyectos digitales. Desarrollamos aplicaciones, sistemas informáticos y software a medida para gestión interna de empresas y procesos de negocio (Intranet/Extranet) que cubran sus necesidades.</p>
                <h2>Misión</h2>
                <p>Desarrollar a nuestros clientes sus sueños tecnológicos e innovadores para su empresa con una alta calidad de trabajo aplicando de manera óptima los más altos estándares tecnológicos y satisfaciendo siempre la necesidad de todos nuestros clientes.</p>
                <h2>Visión</h2>
                <p>En un futuro ser la empresa tecnológica numero 1 con reconocimiento por nuestra gran labor en los proyectos innovadores y los servicios que se le brinda a las empresas y a los clientes que acuden a nosotros.</p>
            </div><!--/.col-sm-6-->
            <div class="col-sm-6">
               <center> <h2>Desarrollamos tus sueños</h2></center>
                <div>
                   <img class="img-responsive" src="{{asset('temas/stids/img/nosotros.jpg')}}">
                </div>
            </div><!--/.col-sm-6-->
        </div><!--/.row-->


    </section><!--/#about-us-->

@endsection