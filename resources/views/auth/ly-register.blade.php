@extends('layouts.lyontech')
@section('bootstrap')
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('theme-lyontech/css/5.css') }}">
@stop
@section('content')

    <body class="img js-fullheight" style="background-image: url({{ asset('theme-lyontech/images/login.png') }});">
        <div class="container-fluid ">
            <div class="row align-content-center justify-content-center">
                <div class="col-lg-7 col-md-7 col-sm-6">
                    <div class="container-fluid ">
                        <div class="col-lg-12 col-md-12 col-sm-10">
                            <div class="card card-transparent text-login">
                                <h5>BIENVENIDO</h5>
                                <p style="font-size: 52px; letter-spacing: -1px; word-spacing: -1px; line-height: 1;">
                                    a la prueba gratuita
                                </p>
                                <p style="font-size: 52px; letter-spacing: -1px; word-spacing: -1px; line-height: 1;">
                                    de Lyonteach.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-6 text-left">
                    @livewire('auth.ly-register-form')
                </div>
            </div>

        </div>
    </body>
@stop
