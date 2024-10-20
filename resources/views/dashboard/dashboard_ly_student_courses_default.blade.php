@extends('layouts.tutorio')
@section('lycss')
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <!--<link rel="stylesheet" href="{{ asset('theme-lyontech/css/7.css') }}">
                        <link rel="stylesheet" href="{{ asset('theme-lyontech/css/8.css') }}">
                        <link rel="stylesheet" href="{{ asset('theme-lyontech/css/9.css') }}">-->
@stop
@section('content')

    <body>
        <x-lyontech.header></x-lyontech.header>
        @livewire('course.courses-default')
    </body>Esta herramienta está disponible en el plan basic, standar y premium
@stop
@section('global-modal')
    <div class="modal fade" id="ventanaModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
        aria-labelledby="tituloVentana" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="padding: 0px 15px 0px 30px;">
            <div class="modal-content bg-orange" style="border-radius: 10px;">
                <div class="modal-header" style="border: 0px">
                </div>
                <div class="modal-body pb-0" style="border: 0px; text-align:center;">
                    <img style="width: 50%;" src="{{ asset('assets/images/logoBlanco.png') }}" alt="">
                    <h3 style="font-weight: 700;">
                        ESTA HERRAMIENTA ESTÁ DISPONIBLE EN EL PLAN BASIC,
                        STANDAR Y PREMIUM
                    </h3>
                </div>
                <div class="modal-footer justify-content-center" style="border: 0px">
                    <a href="{{ route('modo_page') }}" type="button" class="btn btn-secondary btn-lg"
                        style="background-color: black;">
                        <strong>Mejorar</strong>
                    </a>
                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    <script>
        $(document).ready(function() {
            $('#ventanaModal').modal('show');
            activeCkeditor5Default();
        });
    </script>
@endsection
