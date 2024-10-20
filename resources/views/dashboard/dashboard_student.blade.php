@extends('layouts.tutorio')
@section('lycss')
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
@stop
@section('content')

    <body class="layout-navbar-mini-fixed-bottom">
        <div class="mdk-header-layout js-mdk-header-layout">
            <!-- header section strats -->
            <x-lyontech.header></x-lyontech.header>
            <div class="mdk-header-layout__content page-content ">
                <x-lyontech.student-data></x-lyontech.student-data>

                <div class="bg-white box-section">
                    <div class="container page__container">
                        <div class="row" style="padding: 40px 0px 30px 0px;">
                            <div class="col-md-12" style="text-align: center;">
                                <h4 class="mb-0">
                                    <strong style="font-size: 1.8rem;letter-spacing: 0.0em;">HERRAMIENTAS DE
                                        TRABAJO</strong>
                                </h4>
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-8">
                                        <p class="mt-1 text-gris">
                                            Te presentamos las herramientas de trabajo, con ellas podrás potenciar el
                                            desarrollo de
                                            tu investigación, empieza ahora tu experiencia de la mano de lyonteach
                                        </p>
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4" style="text-align: center; padding: 15px;">
                                <div class="box-plane-card-dashboard">
                                    <img style="width: 50%;" src="{{ asset('theme-lyontech/images/ia-m.png') }}"
                                        alt="">
                                    <h4 class="mb-0">
                                        CONSULTAS IA
                                    </h4>
                                    <p>
                                        Mejora tu investigación con la IA.
                                    </p>
                                    {{-- @can('academico_directo_gpt') --}}
                                    <a href="{{ route('help_gpt') }}" class="btn btn-black">Empezar</a>
                                    {{-- @else
                                    <a href="{{ route('modo_page') }}" class="btn btn-black">Empezar</a>
                                    @endcan --}}

                                </div>
                            </div>
                            <div class="col-md-4" style="text-align: center; padding: 15px;">
                                <div class="box-plane-card-dashboard">
                                    <div>
                                        <img style="width: 50%;" src="{{ asset('theme-lyontech/images/libro-m.png') }}"
                                            alt="">
                                        <h4 class="mb-0">
                                            CURSOS
                                        </h4>
                                        <p>
                                            Aprende investigación de forma didáctica.
                                        </p>
                                        @can('academico_directo_cursos')
                                            <a href="{{ route('dashboard_courses') }}" class="btn btn-black">Empezar</a>
                                        @else
                                            <a href="{{ route('dashboard_courses_default') }}" class="btn btn-black">Empezar</a>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4" style="text-align: center; padding: 15px;">
                                <div class="box-plane-card-dashboard">
                                    <img style="width: 50%;" src="{{ asset('theme-lyontech/images/hoja-m.png') }}"
                                        alt="">
                                    <h4 class="mb-0">
                                        HOJA DE TRABAJO
                                    </h4>
                                    <p>
                                        Realiza avances online.
                                    </p>


                                    <!-- ORIGINAL PARA QUE PASEN AL MODAL SI EN CASO APRUEBA MIGUEL -->
                                    @can('academico_directo_tesis')
                                        <a href="" class="btn btn-black" data-toggle="modal"
                                            data-target="#modalThesisHeader">
                                            Empezar
                                        </a>
                                    @else
                                        <a href="{{ route('worksheet_default') }}" class="btn btn-black">Empezar</a>
                                    @endcan


                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>


    </body>
@stop
