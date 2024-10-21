@extends('layouts.tutorio')
@section('styles')
    <style>
        body {
            font-family: "Roboto", sans-serif !important;
            color: #000000 !important;
            /*background-color: #ffffff;*/
            background-color: #151618 !important;
        }
    </style>
@stop
@section('content')

<!-- COOKIES -->

<div id="cookie-consent" class="cookiesMessage_cookiesDisclaimer__pF8_x"><h5 class="cookiesMessage_cookiesDisclaimerHeader__y_YCo">USO DE COOKIES</h5>
    <p class="cookiesMessage_cookiesDisclaimerBody__nxps1">Usamos cookies propias y de terceros para funciones esenciales de este sitio y mejorar tu experiencia al navegar por <a href="{{ env('APP_URL') }}">{{ env('APP_NAME') }}</a>. Revisa nuestro<!-- --> <a target="_blank" href="{{ route('cookies_policy') }}">Aviso de Cookies</a> para obtener más información al respecto.</p><div class="cookiesMessage_cookiesDisclaimerButton__NwcdV">
        <button id="accept-cookies" class="cookiesMessage_cookiesDisclaimerButtonAccept__u3I5b" type="button">Aceptar</button></div></div>
<style>
    .cookiesMessage_cookiesDisclaimer__pF8_x {
  display: flex;
  flex-direction: column;
  gap: 18px;
  font-family: Barlow,sans-serif;
  background-color: hsla(0,0%,100%,.9);
  position: fixed;
  color: #464646;
  bottom: 0;
  width: 100%;
  padding: 1rem 6rem;
  z-index: 999999;
  box-sizing: border-box;
}
</style>

<script>
    document.getElementById('cookie-consent').style.display = "none";
document.addEventListener('DOMContentLoaded', function() {
    const cookieConsent = document.getElementById('cookie-consent');
    const acceptButton = document.getElementById('accept-cookies');
    var consent = localStorage.getItem('cookieConsent');
    if(!(consent === 'true')){
        cookieConsent.style.display = "block";
    }
    function showCookieConsent() {
        if (localStorage.getItem('cookieConsent') !== 'true') {
            cookieConsent.classList.remove('hidden');
            setTimeout(() => {
                cookieConsent.style.transform = 'translateY(0)';
                cookieConsent.style.opacity = '1';
            }, 100);
        }
    }

    function hideCookieConsent() {
        cookieConsent.style.transform = 'translateY(100%)';
        cookieConsent.style.display = 'none';
        setTimeout(() => {
            cookieConsent.classList.add('hidden');
        }, 300);
    }

    function acceptCookies() {
        localStorage.setItem('cookieConsent', 'true');
        hideCookieConsent();
    }

    acceptButton.addEventListener('click', acceptCookies);

    showCookieConsent();
});
</script>


    <div class="hero_area" style="background: #000;">
        <!-- header section strats -->
        <x-lyontech.header></x-lyontech.header>
        <!-- end header section -->



        <!-- Header Layout Content -->
        <div class="mdk-header-layout__content page-content">

            <div class="bg-gradient" style="padding: 60px 0px 0px 0px;">
                <!--<img class="img"  style="margin-top: -50px; z-index: -1;" src="theme-lyontech/images/hero-bg.jpeg" alt="">-->
                <div class="container" style=" position: relative;">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-12">
                                    <h1 class="title-home mt-5">
                                        DESCUBRE <br>
                                        HERRAMIENTAS DE INVESTIGACIÓN <br>
                                        IMPULSADAS POR IA.
                                    </h1>
                                    <p class="lead subTitle-home">
                                        Desarrolla tu investigación de manera más fácil, inteligente y rápida con Lyonteach.
                                    </p>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <a href="{{ route('register') }}" class="btn-border-white">Empezar Gratis</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <img class="img-home" src="{{ asset('theme-lyontech/images/alumnoHome.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>

            <div class="container page__container" style="margin-top: -120px;">
                <div class="row">
                    <div class="col-md-4" style="padding: 0px;">
                        <div class="box-white-home-1">
                            <img style="width: 50%;" src="{{ asset('theme-lyontech/images/ia-m.png') }}" alt="">
                            <h4 class="mb-0">
                                CONSULTAS IA
                            </h4>
                            <p>
                                Mejora tu investigación con la IA.
                            </p>
                            @if (Auth::check())
                                <a href="{{ route('help_gpt') }} " class="btn btn-black">Iniciar consultas</a>
                            @else
                                <a href="{{ route('help_gpt_default') }}" class="btn btn-black">Iniciar consultas</a>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4" style="padding: 0px;">
                        <div class="box-white-home-2">
                            <img style="width: 50%;" src="{{ asset('theme-lyontech/images/libro-m.png') }}" alt="">
                            <h4 class="mb-0">
                                CURSOS
                            </h4>
                            <p>
                                Aprende investigación de forma didáctica.
                            </p>
                            @if (Auth::check())
                                <a href="{{ route('dashboard_courses') }}" class="btn btn-black">Iniciar cursos</a>
                            @else
                                <a href="{{ route('dashboard_courses_default') }}" class="btn btn-black">Iniciar
                                    cursos</a>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4" style="padding: 0px;">
                        <div class="box-white-home-3">
                            <img style="width: 50%;" src="{{ asset('theme-lyontech/images/hoja-m.png') }}" alt="">
                            <h4 class="mb-0">
                                HOJA DE TRABAJO
                            </h4>
                            <p>
                                Realiza avances online.
                            </p>
                            @if (Auth::check())
                                <a href="#" class="btn btn-black" data-toggle="modal"
                                    data-target="#modalThesisHeader">Empezar</a>
                            @else
                                <a href="{{ route('worksheet_default') }}" class="btn btn-black">Empezar</a>
                            @endif
                        </div>
                    </div>
                </div>

            </div>

            <!-- Ver. Escritorio   -->
            <div class="container box-section-home pc-screen">
                <div class="row" style="padding: 40px 0px;">
                    <div class="col-md-4">
                        <div class="box-presentation-home">
                            <h1><strong>PRESENTACIÓN</strong></h1>
                            <h4>Lyonteach</h4>
                        </div>
                    </div>
                    <div class="col-md-8 d-flex justify-content-center align-items-center" style="padding: 40px;">
                        <div class="card-new bg-gradient">
                            <div style="padding:61.88% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/1019497297?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479" frameborder="0" allow="autoplay; fullscreen; picture-in-picture; clipboard-write" style="position:absolute;top:0;left:0;width:100%;height:100%;" title="LYONTEACH VIDEO PRESENTACION FINAL"></iframe></div><script src="https://player.vimeo.com/api/player.js"></script>
                        </div>
                    </div>
                </div>

                <div class="row box-presentation-left-home">
                    <div class="col-md-6">
                        <div class="box-presentation-content-home">
                            <h4>Redacta tu investigación con soporte de la IA</h4>
                            <p>
                                Realiza tus avances de redacción en el editor online donde
                                encontrarás una guía estructurada y herramientas que facilitarán
                                tu proceso.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <a href="#">
                            <img src="{{ asset('theme-lyontech/images/card1.jpg') }}">
                        </a>
                    </div>
                </div>

                <div class="row box-presentation-right-home">
                    <div class="col-md-6">
                        <a href="#">
                            <img src="{{ asset('theme-lyontech/images/card2.jpg') }}">
                        </a>
                    </div>
                    <div class="col-md-6">
                        <div class="box-presentation-content-home">
                            <h4>
                                Deja que el chatbot te ayude en el desarrollo de tu investigación.
                            </h4>
                            <p>
                                Haz preguntas al chatbot ante cualquier duda, además, utiliza el parafraseador,
                                referenciador
                                y recomendador para avanzar tu investigación.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row box-presentation-left-home">
                    <div class="col-md-6">
                        <div class="box-presentation-content-home">
                            <h4> Accede al chat con un asesor las 24 horas del día.</h4>
                            <p>
                                Emite tus consultas con un experto,
                                él encargado absolvera toda duda, además,
                                de corregir cualquier deficiencia que tengas.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <a href="#" class="">
                            <img src="{{ asset('theme-lyontech/images/card3.jpg') }}">
                        </a>
                    </div>
                </div>

                <div class="row box-presentation-right-home">
                    <div class="col-md-6">
                        <a href="#">
                            <img src="{{ asset('theme-lyontech/images/card4.jpg') }}">
                        </a>
                    </div>
                    <div class="col-md-6" style="position: relative;">
                        <div class="box-presentation-content-home">
                            <h4>
                                Aprende sobre investigación de manera didáctica y entendible.
                            </h4>
                            <p>
                                Accede a los videos y guías de investigación preparados con estrategias prácticas
                                para el planteamiento de cada apartado de la investigación.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ver. Celular   -->
            <div class="container box-section-home movil-screen">
                <div class="row" style="padding: 40px 0px;">
                    <div class="col-md-4">
                        <div class="box-presentation-home">
                            <h1><strong>PRESENTACIÓN</strong></h1>
                            <h4>Lyonteach </h4>
                        </div>
                    </div>
                    <div class="col-md-8 d-flex justify-content-center align-items-center" style="padding: 40px;">
                        <div class="card bg-gradient">
                            <video style="100%" controls muted playsinline>
                                <source src="video.mp4" type="video/mp4">
                                Tu navegador no soporta el elemento de vídeo.
                            </video>
                        </div>
                    </div>
                </div>

                <div class="row box-presentation-left-home">
                    <div class="col-md-6">
                        <div class="box-presentation-content-home">
                            <h4>Redacta tu investigación con soporte de la IA</h4>
                            <p>
                                Realiza tus avances de redacción en el editor online donde
                                encontrarás una guía estructurada y herramientas que facilitarán
                                tu proceso.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <a href="#">
                            <img src="{{ asset('theme-lyontech/images/card1.jpg') }}">
                        </a>
                    </div>
                </div>

                <div class="row box-presentation-right-home">
                    <div class="col-md-6">
                        <div class="box-presentation-content-home">
                            <h4>
                                Deja que el chatbot te ayude en el desarrollo de tu investigación.
                            </h4>
                            <p>
                                Haz preguntas al chatbot ante cualquier duda, además, utiliza el parafraseador,
                                referenciador
                                y recomendador para avanzar tu investigación.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <a href="#">
                            <img src="{{ asset('theme-lyontech/images/card2.jpg') }}">
                        </a>
                    </div>
                </div>

                <div class="row box-presentation-left-home">
                    <div class="col-md-6">
                        <div class="box-presentation-content-home">
                            <h4> Accede al chat con un asesor las 24 horas del día.</h4>
                            <p>
                                Emite tus consultas en tiempo real con un experto, él encargado absolvera toda duda,
                                además, de corregir cualquier deficiencia que tengas.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <a href="#" class="">
                            <img src="{{ asset('theme-lyontech/images/card3.jpg') }}">
                        </a>
                    </div>
                </div>

                <div class="row box-presentation-right-home">
                    <div class="col-md-6">
                        <div class="box-presentation-content-home">
                            <h4>
                                Aprende sobre investigación de manera didáctica y entendible.
                            </h4>
                            <p>
                                Accede a los videos y guías de investigación preparados con estrategias prácticas
                                para el planteamiento de cada apartado de la investigación.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <a href="#" class="">
                            <img src="{{ asset('theme-lyontech/images/card4.jpg') }}">
                        </a>
                    </div>
                </div>
            </div>

        </div>
        <!-- // END Header Layout Content -->

    </div>

@stop
