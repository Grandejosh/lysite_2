@extends('layouts.tutorio')
@section('lycss')
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <!--<link rel="stylesheet" href="{{ asset('theme-lyontech/css/12-modo.css') }}">-->
@stop
@section('content')

    <div class="img js-fullheight" style="background-image: url({{ asset('theme-lyontech/images/fondo-naranja.jpg') }});">

        <div class="container-section-modo">
            <div class="row">
                <div class="col-md-12 box-plane-modo">
                    <div class="row box-plane-content-modo">
                        @if (count($modos) > 0)
                            @foreach ($modos as $modo)
                                @if ($modo->price == 0)
                                    <div class="col-md-3">
                                        <div class="box-plane-card-modo">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h1 class="mb-0" style="text-align: center;">{{ $modo->name }}
                                                    </h1>

                                                    @if ($modo->price == 0)
                                                            <p class="mt-0 mb-0  text-center" style="color: #000; font-size: 25px;">
                                                                <strong>-</strong>
                                                            </p>
                                                            <p class="mt-0 mb-0  text-center" style="color: #000; font-size: 20px;">
                                                                <strong>-</strong>
                                                            </p>
                                                    @else
                                                            <p class="mt-0 mb-0  text-center" style="color: #000; font-size: 25px;">
                                                                <strong>S/ {{ $modo->price }}</strong>
                                                                <strong>ó</strong>
                                                            </p>
                                                            <p class="mt-0 mb-0  text-center" style="color: #000; font-size: 20px;">
                                                                <strong>$USD {{ $modo->dollar_price }}</strong>
                                                            </p>
                                                    @endif

                                                    <p class="mt-0 mb-0 text-center"
                                                        style="color: #ff9152; font-size: 20px;">
                                                        <strong>/{{ $modo->detail_one }}</strong>
                                                    </p>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <ul>
                                                        <li>{{ $modo->detail_two }}</li>
                                                        <li>{{ $modo->detail_three }}</li>
                                                        <li>{{ $modo->detail_four }}</li>
                                                        @if ($modo->detail_five && $modo->detail_five !== 'null')
                                                        <li>{{ $modo->detail_five }}</li>
                                                        @endif

                                                        @if ($modo->detail_six && $modo->detail_six !== 'null')
                                                            <li>{{ $modo->detail_six }}</li>
                                                        @endif

                                                        @if ($modo->detail_seven && $modo->detail_seven !== 'null')
                                                            <li>{{ $modo->detail_seven }}</li>
                                                        @endif

                                                        @if ($modo->detail_eight && $modo->detail_eight !== 'null')
                                                            <li>{{ $modo->detail_eight }}</li>
                                                        @endif
                                                    </ul>
                                                    <form action="#" class="signin-form mt-2">
                                                        <div class="form-group mt-4 btn-cent mb-4">
                                                            @if (!Auth::check())
                                                                <a href="{{ route('register') }}"
                                                                    class="form-control btn btn-gris submit">
                                                                    Registrar
                                                                </a>
                                                            @else
                                                                <a href="#" class="form-control btn btn-gris submit">
                                                                    Registrado
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($modo->price > 0)
                                    <div class="col-md-3">
                                        <div class="box-plane-card-modo">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h1 class="mb-0" style="text-align: center;">{{ $modo->name }}</h1>

                                                    @if ($modo->price == 0)
                                                            <p class="mt-0 mb-0  text-center" style="color: #000; font-size: 25px;">
                                                                <strong>-</strong>
                                                            </p>
                                                            <p class="mt-0 mb-0  text-center" style="color: #000; font-size: 20px;">
                                                                <strong>-</strong>
                                                            </p>
                                                    @else
                                                            <p class="mt-0 mb-0  text-center" style="color: #000; font-size: 25px;">
                                                                <strong>S/ {{ $modo->price }}</strong>
                                                                <strong>ó</strong>
                                                            </p>
                                                            <p class="mt-0 mb-0  text-center" style="color: #000; font-size: 20px;">
                                                                <strong>$USD {{ $modo->dollar_price }}</strong>
                                                            </p>
                                                    @endif

                                                    <p class="mt-0 mb-0 text-center"
                                                        style="color: #ff9152; font-size: 20px;">
                                                        <strong>/{{ $modo->detail_one }}</strong>
                                                    </p>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <ul>
                                                        <li>{{ $modo->detail_two }}</li>
                                                        <li>{{ $modo->detail_three }}</li>
                                                        <li>{{ $modo->detail_four }}</li>
                                                        @if ($modo->detail_five && $modo->detail_five !== 'null')
                                                        <li>{{ $modo->detail_five }}</li>
                                                        @endif

                                                        @if ($modo->detail_six && $modo->detail_six !== 'null')
                                                            <li>{{ $modo->detail_six }}</li>
                                                        @endif

                                                        @if ($modo->detail_seven && $modo->detail_seven !== 'null')
                                                            <li>{{ $modo->detail_seven }}</li>
                                                        @endif

                                                        @if ($modo->detail_eight && $modo->detail_eight !== 'null')
                                                            <li>{{ $modo->detail_eight }}</li>
                                                        @endif
                                                    </ul>
                                                    <form action="#" class="signin-form mt-2">
                                                        <div class="form-group mt-4 mb-4">
                                                            <a href="{{ route('unirme_page', $modo->id) }}"
                                                                class="form-control btn btn-orange submit">Unirse</a>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
