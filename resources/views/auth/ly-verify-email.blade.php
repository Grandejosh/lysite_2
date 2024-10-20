@extends('layouts.lyontech')
@section('bootstrap')
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('theme-lyontech/css/6.css') }}">
@stop
@section('content')

    <body class="img js-fullheight" style="background-image: url({{ asset('theme-lyontech/images/login.png') }});">
        <div class="container-fluid ">
            <div class="row align-content-center justify-content-center">
                <div class="col-md-8 col-lg-10 ">
                    @livewire('auth.ly-verify-email')
                </div>
            </div>

        </div>
    </body>
@stop
