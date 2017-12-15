@extends('temas.stids_usuario')

@section('meta-seo')
    <meta name="keywords" content="portfolio, web, logos, publicidades" />
    <meta name="description" content="Visualiza algunos de nuestros trabajos.">
@endsection

@section('content') 
    
    <section id="title" class="cbe">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <h1 style="color: white;">Portafolio</h1>
                    <p style="color: white;">Visualiza algunos de nuestros trabajos</p>
                </div>
                <div class="col-sm-6">
                    <ul class="breadcrumb pull-right">
                        <li><a href="inicio">Inicio</a></li>
                        <li class="active">Portafolio</li>
                    </ul>
                </div>
            </div>
        </div>
    </section><!--/#title--> 





    <section id="portfolio" class="container">
        <ul class="portfolio-filter">
            <li><a class="btn btn-default active" href="#" data-filter="*">Todo</a></li>
            <li><a class="btn btn-default" href="#" data-filter=".bootstrap">Webs</a></li>
            <li><a class="btn btn-default" href="#" data-filter=".html">Logos</a></li>
            <li><a class="btn btn-default" href="#" data-filter=".wordpress">Publicidades</a></li>
        </ul><!--/#portfolio-filter-->


        <ul class="portfolio-items col-3">
            <li class="portfolio-item bootstrap">
                <div class="item-inner">
                    <img src="{{asset('temas/stids/img/portfolio/thumb/item1.jpg')}}" alt="">
                    <center><h5>By stids</h5> </center>
                    <div class="overlay">
                        <a class="preview btn btn-danger" href="{{asset('temas/stids/img/portfolio/full/item1.jpg')}}" rel="prettyPhoto"><i class="icon-eye-open"></i></a>             
                    </div>           
                </div>           
            </li><!--/.portfolio-item-->
            <li class="portfolio-item bootstrap">
                <div class="item-inner">
                    <img src="{{asset('temas/stids/img/portfolio/thumb/item2.jpg')}}" alt="">
                    <center><h5>By stids</h5> </center>
                    <div class="overlay">
                        <a class="preview btn btn-danger" href="{{asset('temas/stids/img/portfolio/full/item2.jpg')}}" rel="prettyPhoto"><i class="icon-eye-open"></i></a>              
                    </div>           
                </div>           
            </li><!--/.portfolio-item-->
            <li class="portfolio-item bootstrap ">
                <div class="item-inner">
                    <img src="{{asset('temas/stids/img/portfolio/thumb/item3.jpg')}}" alt="">
                    <center><h5>By stids</h5> </center>
                    <div class="overlay">
                        <a class="preview btn btn-danger" href="{{asset('temas/stids/img/portfolio/full/item3.jpg')}}" rel="prettyPhoto"><i class="icon-eye-open"></i></a>        
                    </div>           
                </div>           
            </li><!--/.portfolio-item-->
            <li class="portfolio-item bootstrap">
                <div class="item-inner">
                    <img src="{{asset('temas/stids/img/portfolio/thumb/item4.jpg')}}" alt="">
                    <center><h5>By stids</h5> </center>
                    <div class="overlay">
                        <a class="preview btn btn-danger" href="{{asset('temas/stids/img/portfolio/full/item4.jpg')}}" rel="prettyPhoto"><i class="icon-eye-open"></i></a>          
                    </div>           
                </div>           
            </li><!--/.portfolio-item-->
            <li class="portfolio-item bootstrap">
                <div class="item-inner">
                    <img src="{{asset('temas/stids/img/portfolio/thumb/item5.jpg')}}" alt="">
                    <center><h5>By stids</h5> </center>
                    <div class="overlay">
                        <a class="preview btn btn-danger" href="{{asset('temas/stids/img/portfolio/full/item5.jpg')}}" rel="prettyPhoto"><i class="icon-eye-open"></i></a>          
                    </div>    
                </div>       
            </li><!--/.portfolio-item-->
            <li class="portfolio-item bootstrap">
                <div class="item-inner">
                    <img src="{{asset('temas/stids/img/portfolio/thumb/item6.jpg')}}" alt="">
                    <center><h5>By stids</h5> </center>
                    <div class="overlay">
                        <a class="preview btn btn-danger" href="{{asset('temas/stids/img/portfolio/full/item6.jpg')}}" rel="prettyPhoto"><i class="icon-eye-open"></i></a>           
                    </div>           
                </div>           
            </li><!--/.portfolio-item-->
               <li class="portfolio-item bootstrap">
                <div class="item-inner">
                    <img src="{{asset('temas/stids/img/portfolio/thumb/item7.jpg')}}" alt="">
                    <center><h5>By stids</h5> </center>
                    <div class="overlay">
                        <a class="preview btn btn-danger" href="{{asset('temas/stids/img/portfolio/full/item7.jpg')}}" rel="prettyPhoto"><i class="icon-eye-open"></i></a>           
                    </div>           
                </div>           
            </li><!--/.portfolio-item-->
               <li class="portfolio-item bootstrap">
                <div class="item-inner">
                    <img src="{{asset('temas/stids/img/portfolio/thumb/item8.jpg')}}" alt="">
                    <center><h5>By stids</h5> </center>
                    <div class="overlay">
                        <a class="preview btn btn-danger" href="{{asset('temas/stids/img/portfolio/full/item8.jpg')}}" rel="prettyPhoto"><i class="icon-eye-open"></i></a>           
                    </div>           
                </div>           
            </li><!--/.portfolio-item-->
               <li class="portfolio-item html">
                <div class="item-inner">
                    <img src="{{asset('temas/stids/img/portfolio/thumb/item9.jpg')}}" alt="">
                    <center><h5>By stids</h5> </center>
                    <div class="overlay">
                        <a class="preview btn btn-danger" href="{{asset('temas/stids/img/portfolio/full/item9.jpg')}}" rel="prettyPhoto"><i class="icon-eye-open"></i></a>           
                    </div>           
                </div>           
            </li><!--/.portfolio-item-->
               <li class="portfolio-item html">
                <div class="item-inner">
                    <img src="{{asset('temas/stids/img/portfolio/thumb/item10.jpg')}}" alt="">
                    <center><h5>By stids</h5> </center>
                    <div class="overlay">
                        <a class="preview btn btn-danger" href="{{asset('temas/stids/img/portfolio/full/item10.jpg')}}" rel="prettyPhoto"><i class="icon-eye-open"></i></a>           
                    </div>           
                </div>           
            </li><!--/.portfolio-item-->
               <li class="portfolio-item wordpress">
                <div class="item-inner">
                    <img src="{{asset('temas/stids/img/portfolio/thumb/item11.jpg')}}" alt="">
                    <center><h5>By stids</h5> </center>
                    <div class="overlay">
                        <a class="preview btn btn-danger" href="{{asset('temas/stids/img/portfolio/full/item11.jpg')}}" rel="prettyPhoto"><i class="icon-eye-open"></i></a>           
                    </div>           
                </div>           
            </li><!--/.portfolio-item-->
               <li class="portfolio-item wordpress">
                <div class="item-inner">
                    <img src="{{asset('temas/stids/img/portfolio/thumb/item12.jpg')}}" alt="">
                    <center><h5>By stids</h5> </center>
                    <div class="overlay">
                        <a class="preview btn btn-danger" href="{{asset('temas/stids/img/portfolio/full/item12.jpg')}}" rel="prettyPhoto"><i class="icon-eye-open"></i></a>           
                    </div>           
                </div>           
            </li><!--/.portfolio-item-->
            <li class="portfolio-item wordpress">
                <div class="item-inner">
                    <img src="{{asset('temas/stids/img/portfolio/thumb/item13.jpg')}}" alt="">
                    <center><h5>By stids</h5> </center>
                    <div class="overlay">
                        <a class="preview btn btn-danger" href="{{asset('temas/stids/img/portfolio/full/item13.jpg')}}" rel="prettyPhoto"><i class="icon-eye-open"></i></a>           
                    </div>           
                </div>           
            </li><!--/.portfolio-item-->
             <li class="portfolio-item html">
                <div class="item-inner">
                    <img src="{{asset('temas/stids/img/portfolio/thumb/item14.jpg')}}" alt="">
                    <center><h5>By stids</h5> </center>
                    <div class="overlay">
                        <a class="preview btn btn-danger" href="{{asset('temas/stids/img/portfolio/full/item14.jpg')}}" rel="prettyPhoto"><i class="icon-eye-open"></i></a>           
                    </div>           
                </div>           
            </li><!--/.portfolio-item-->
             <li class="portfolio-item html">
                <div class="item-inner">
                    <img src="{{asset('temas/stids/img/portfolio/thumb/item15.jpg')}}" alt="">
                    <center><h5>By stids</h5> </center>
                    <div class="overlay">
                        <a class="preview btn btn-danger" href="{{asset('temas/stids/img/portfolio/full/item15.jpg')}}" rel="prettyPhoto"><i class="icon-eye-open"></i></a>           
                    </div>           
                </div>           
            </li><!--/.portfolio-item-->
        </ul>
    </section><!--/#portfolio-->

@endsection

@section('script-inferior')
<script src="{{asset('temas/stids/js/jquery.isotope.min.js')}}"></script>
<script src="{{asset('temas/stids/js/main.js')}}"></script>
@endsection