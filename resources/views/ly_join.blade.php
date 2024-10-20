@extends('layouts.tutorio')
@section('lycss')
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('theme-lyontech/css/13-unirme.css') }}">
@stop
@section('content')
    <div class="img js-fullheight" style="background-image: url({{ asset('theme-lyontech/images/fondo-naranja.jpg') }});">
        <div class="container-fluid  page__container">
            <div class="row" style="padding: 20px;">
                <div class="col-md-1"></div>
                <div class="col-md-6">
                    <div class="" style="position: relative; top: 30%;">
                        <h1 class="mb-1" style="font-size: 55px; color: #fff;">MEJORA</h1>
                        <p class="mt-0" style="font-size: 30px; color:#fff;">
                            Adquiere tu cuenta con mejores <br>
                            oportunidades.
                        </p>
                        <br>
                    </div>
                </div>
                <div class="col-md-5" style="background: #fff; padding: 40px; border-radius: 40px;">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="mb-1" style="font-size: 55px; color: #000">Unirme</h1>
                            <p class="mt-0" style="font-size: 20px; color:#000;">
                                Estas a pundo de adquirir el plan: <b style="color: #ff9152;">{{ $typeSubscription }}</b>. ¿Cómo quieres pagar?
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 box-unirse-list">
                            <a href="{{ route('tarjeta_page', $mod) }}" class="btn btn-white">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="mt-1">
                                            <img style="width: 100%;" src="{{ asset('theme-lyontech/images/tc.png') }}"
                                                alt="Icono">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="mt-1">
                                            <h4 class="mb-0" style="text-transform: uppercase; text-align:left;">Con
                                                tarjeta</h4>
                                            <p class="mt-0" style="text-align:left;">Débito o crédito en soles.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <!--<img style="width: 100%;" src="{{ asset('theme-lyontech/images/felcha.png') }}" alt="Icono">-->
                                        <div class="mt-3">
                                            <i class="fa fa-play" aria-hidden="true" style="font-size: 30px;"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 box-unirse-list">
                            <a href="" class="btn btn-white">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="mt-1">
                                            <img style="width: 100%;" src="{{ asset('theme-lyontech/images/bb.png') }}"
                                                alt="Icono">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="mt-1">
                                            <h4 class="mb-0" style="text-transform: uppercase; text-align:left;">Efectivo
                                                en agentes</h4>
                                            <p class="mt-0" style="text-align:left;">Paga en efectivo.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <!--<img style="width: 100%;" src="{{ asset('theme-lyontech/images/felcha.png') }}" alt="Icono">-->
                                        <div class="mt-3">
                                            <i class="fa fa-play" aria-hidden="true" style="font-size: 30px;"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 box-unirse-list">
                            <a href="" class="btn btn-white">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="mt-1">
                                            <img style="width: 100%;" src="{{ asset('theme-lyontech/images/museo.png') }}"
                                                alt="Icono">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="mt-1">
                                            <h4 class="mb-0" style="text-transform: uppercase; text-align:left;">Banca por
                                                internet</h4>
                                            <p class="mt-0" style="text-align:left;">Paga en efectivo.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <!--<img style="width: 100%;" src="{{ asset('theme-lyontech/images/felcha.png') }}" alt="Icono">-->
                                        <div class="mt-3">
                                            <i class="fa fa-play" aria-hidden="true" style="font-size: 30px;"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 box-unirse-list">
                            <form action="{{ route('paypal_payment') }}" method="POST" style="display: inline;">
                                @csrf
                                <input type="hidden" name="id_subscription" value="{{ $mod }}">
                                <input type="hidden" name="full_name" value="paypal_payer">
                                <input type="hidden" name="currecy" value="currency">
                                <button class="btn btn-white">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="mt-1">
                                                <img style="width: 100%;"
                                                    src="{{ asset('theme-lyontech/images/paypal.png') }}" alt="Icono">
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="mt-1">
                                                <h4 class="mb-0" style="text-transform: uppercase; text-align:left;">
                                                    Paypal</h4>
                                                <p class="mt-0" style="text-align:left;">Paga por paypal en dólares.</p>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <!--<img style="width: 100%;" src="{{ asset('theme-lyontech/images/felcha.png') }}" alt="Icono">-->
                                            <div class="mt-3">
                                                <i class="fa fa-play" aria-hidden="true" style="font-size: 30px;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
@if (!Auth::check())
    @section('global-modal')
        <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><i class="fa fa-lock mr-4"></i>Iniciar Sesión
                            Requerido
                        </h5>
                        <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                        <span aria-hidden="true">&times;</span>
                                                                                      </button>-->
                    </div>
                    <div class="modal-body">
                        <p>Es necesario iniciar sesión para poder hacer un pago. Por favor, inicie sesión para continuar</p>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('home') }}" type="button" class="btn btn-danger">Ir al Inicio</a>
                        <a href="{{ route('login') }}" type="button" class="btn btn-orange">Iniciar sesión</a>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $('#staticBackdrop').modal('show');
            });
        </script>
    @stop
@endif
