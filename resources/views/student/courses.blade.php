@extends('layouts.lyontech')
@section('bootstrap')
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
        integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('theme-lyontech/css/7.css') }}">
    <link rel="stylesheet" href="{{ asset('theme-lyontech/css/8.css') }}">
    <link rel="stylesheet" href="{{ asset('theme-lyontech/css/9.css') }}">
@stop
@section('content')

    <body>
        <x-lyontech.header></x-lyontech.header>
        <x-lyontech.student-data></x-lyontech.student-data>
        <div class="media rosado-bajo ">
            <div class="container-fluid">
                <div class="row justify-content-center align-items-center">
                    <div class="col-md-6 col-md-offset-3 text-center">
                        <small class="custom-padding">
                            <h5>Aumenta tus oportunidades: </h5>
                            <p>&nbsp;Únete a premium</p> <button class="rosadito">Mejora</button>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </body>
@stop
