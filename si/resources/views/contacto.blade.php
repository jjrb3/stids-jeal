@extends('temas.stids_usuario')

@section('meta-seo')
    <meta name="keywords" content="contacto, donde estamos situados" />
    <meta name="description" content="Contactanos para mas información.">
@endsection

@section('content') 
    
    <section id="title" class="cbe">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <h1 style="color: white;">Contacto</h1>
                    <p style="color: white;">Contactanos para mas información</p>
                </div>
                <div class="col-sm-6">
                    <ul class="breadcrumb pull-right">
                        <li><a href="inicio">Inicio</a></li>
                        <li class="active">Contacto</li>
                    </ul>
                </div>
            </div>
        </div>
    </section><!--/#title-->  


    <CENTER> <h3 style="color: #1f9b83;">SITUADOS EN:</h3></center></CENTER>

    <iframe  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d62667.64742985303!2d-74.85303713128741!3d10.983894208185644!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8ef42d44d12ae605%3A0x2633844581b917b2!2sBarranquilla%2C+Atl%C3%A1ntico%2C+Colombia!5e0!3m2!1ses!2sit!4v1464102222056" width="600" height="450" frameborder="0" style="border:0; width: 100%;" allowfullscreen></iframe>

    <section id="contact-page" class="container">
    <div class="row">
        <div class="col-md-12">
        
        </div>
    </div>
        <div class="row">
            <div class="col-sm-12">
               <center> <h4 style="color: #1f9b83;">Favor rellenar el formulario de contácto</h4></center>
                <div class="status alert alert-success" style="display: none"></div>
                <form id="main-contact-form" class="contact-form" name="contact-form" method="post" action="sendemail.php" role="form">
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" required="required" placeholder="Nombre">
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" required="required" placeholder="E-mail">
                            </div>
                            <div class="form-group">
                                <input type="phone" class="form-control" name="phone" required="required" placeholder="Telefono">
                            </div>
                           
                            <div class="form-group">
                                <button type="submit"  class="btn btn-primary btn-lg">Enviar mensaje</button>
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <textarea name="message" id="message" required="required" class="form-control" rows="8" placeholder="Favor escribir su mensaje "></textarea>
                        </div>
                    </div>
                </form>
            </div><!--/.col-sm-8-->

        </div>
    </section><!--/#contact-page-->

@endsection