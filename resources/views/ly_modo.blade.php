@extends('layouts.tutorio')
@section('lycss')
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <!--<link rel="stylesheet" href="{{ asset('theme-lyontech/css/12-modo.css') }}">-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
@stop
@section('content')

    {{-- <div class="img js-fullheight" style="background-image: url({{ asset('theme-lyontech/images/fondo-naranja.jpg') }});">

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
                                                        <p class="mt-0 mb-0  text-center"
                                                            style="color: #000; font-size: 25px;">
                                                            <strong>-</strong>
                                                        </p>
                                                        <p class="mt-0 mb-0  text-center"
                                                            style="color: #000; font-size: 20px;">
                                                            <strong>-</strong>
                                                        </p>
                                                    @else
                                                        <p class="mt-0 mb-0  text-center"
                                                            style="color: #000; font-size: 25px;">
                                                            <strong>S/ {{ $modo->price }}</strong>
                                                            <strong>ó</strong>
                                                        </p>
                                                        <p class="mt-0 mb-0  text-center"
                                                            style="color: #000; font-size: 20px;">
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
                                                        <p class="mt-0 mb-0  text-center"
                                                            style="color: #000; font-size: 25px;">
                                                            <strong>-</strong>
                                                        </p>
                                                        <p class="mt-0 mb-0  text-center"
                                                            style="color: #000; font-size: 20px;">
                                                            <strong>-</strong>
                                                        </p>
                                                    @else
                                                        <p class="mt-0 mb-0  text-center"
                                                            style="color: #000; font-size: 25px;">
                                                            <strong>S/ {{ $modo->price }}</strong>
                                                            <strong>ó</strong>
                                                        </p>
                                                        <p class="mt-0 mb-0  text-center"
                                                            style="color: #000; font-size: 20px;">
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

                                                            @if (in_array($modo->id, $userModes))
                                                                <a href="#" class="form-control btn btn-gris submit">
                                                                    Registrado
                                                                </a>
                                                            @else
                                                                <a href="{{ route('unirme_page', $modo->id) }}"
                                                                    class="form-control btn btn-orange submit">Unirse</a>
                                                            @endif


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
    </div> --}}

    <div class="background-full" style="background-image: url({{ asset('theme-lyontech/images/fondo-naranja.jpg') }}); 
            background-size: cover; background-position: center; 
            background-repeat: no-repeat;">
            <div class="container-xxl section-modo">
                <div class="row">
                    @if (count($modos) > 0)
                            @foreach ($modos as $modo)
                                @if ($modo->price == 0)
                                    <div class="col-md-3">
                                        <div style="padding: 20px 0px;">
                                            <div class="box-plane">
                                                <h1 class="mb-0" style="text-align: center;">
                                                    {{ $modo->name }}
                                                </h1>
                                                @if ($modo->price == 0)
                                                <p class="mt-0 mb-0  text-center"
                                                    style="color: #000; font-size: 25px;">
                                                    <strong>-</strong>
                                                </p>
                                                <p class="mt-0 mb-0  text-center"
                                                    style="color: #000; font-size: 20px;">
                                                    <strong>-</strong>
                                                </p>
                                                @else
                                                    <p class="mt-0 mb-0  text-center"
                                                        style="color: #000; font-size: 25px;">
                                                        <strong>S/ {{ $modo->price }}</strong>
                                                        <strong>ó</strong>
                                                    </p>
                                                    <p class="mt-0 mb-0  text-center"
                                                        style="color: #000; font-size: 20px;">
                                                        <strong>$USD {{ $modo->dollar_price }}</strong>
                                                    </p>
                                                @endif
                                                <p class="text-center"
                                                    style="color: #ff9152; font-size: 20px;">
                                                    <strong>/{{ $modo->detail_one }}</strong>
                                                </p>
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

                                                        @if (!Auth::check())
                                                            <a href="{{ route('register') }}"
                                                                class="form-control btn btn-gris submit" style="color: #fff;">
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
                                        {{-- <div class="box-plane">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h1 class="mb-0" style="text-align: center;">
                                                        {{ $modo->name }}
                                                    </h1>

                                                    @if ($modo->price == 0)
                                                        <p class="mt-0 mb-0  text-center"
                                                            style="color: #000; font-size: 25px;">
                                                            <strong>-</strong>
                                                        </p>
                                                        <p class="mt-0 mb-0  text-center"
                                                            style="color: #000; font-size: 20px;">
                                                            <strong>-</strong>
                                                        </p>
                                                    @else
                                                        <p class="mt-0 mb-0  text-center"
                                                            style="color: #000; font-size: 25px;">
                                                            <strong>S/ {{ $modo->price }}</strong>
                                                            <strong>ó</strong>
                                                        </p>
                                                        <p class="mt-0 mb-0  text-center"
                                                            style="color: #000; font-size: 20px;">
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
                                        </div> --}}
                                    </div>
                                @endif

                                @if ($modo->price > 0)
                                    <div class="col-md-3">
                                        <div style="padding: 20px 0px;">
                                            <div class="box-plane">
                                                <h1 class="mb-0" style="text-align: center;">{{ $modo->name }}</h1>

                                                @if ($modo->price == 0)
                                                    <p class="mt-0 mb-0  text-center"
                                                        style="color: #000; font-size: 25px;">
                                                        <strong>-</strong>
                                                    </p>
                                                    <p class="mt-0 mb-0  text-center"
                                                        style="color: #000; font-size: 20px;">
                                                        <strong>-</strong>
                                                    </p>
                                                @else
                                                    <p class="mt-0 mb-0  text-center"
                                                        style="color: #000; font-size: 25px;">
                                                        <strong>S/ {{ $modo->price }}</strong>
                                                        <strong>ó</strong>
                                                    </p>
                                                    <p class="mt-0 mb-0  text-center"
                                                        style="color: #000; font-size: 20px;">
                                                        <strong>$USD {{ $modo->dollar_price }}</strong>
                                                    </p>
                                                @endif

                                                <p class="text-center"
                                                    style="color: #ff9152; font-size: 20px;">
                                                    <strong>/{{ $modo->detail_one }}</strong>
                                                </p>
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

                                                        @if (in_array($modo->id, $userModes))
                                                            <a href="#" class="form-control btn btn-gris submit">
                                                                Registrado
                                                            </a>
                                                        @else
                                                            <a href="{{ route('unirme_page', $modo->id) }}"
                                                                class="form-control btn btn-orange submit">Unirse</a>
                                                        @endif


                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                </div>
            </div> 
        <style>
            .background-full {
                background-size: cover; 
                background-position: center; 
                background-repeat: no-repeat; 
                height: auto;
                margin: 0; 
                display: -webkit-box;
                display: -ms-flexbox;
                display: flex;
                -webkit-box-pack: center;
                -ms-flex-pack: center;
                justify-content: center;
                -webkit-box-align: center;
                -ms-flex-align: center;
                align-items: center;
                filter: brightness(110%) saturate(120%);
            }

            .section-modo{
                background: none;
                margin: 0;
                padding: 25px;
                border-radius: 20px;
            }

            .box-plane {
                padding: 20px; 
                align-items: center;
                background: #fff;
                box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1);
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                border-radius: 20px;
            }

            .box-plane:hover {
                transform: translateY(-10px);
                box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
            }
            .box-plane ul{
                height: 360px; 
                font-size: 15px;
            }

            .btn-gris {
                color: #fff;
                background-color: #a1a1a1;
                border-color: #a1a1a1;
            }
            .btn-gris:hover {
                color: #fff;
                background-color: #000;
                border-color: #000;
            }

            @media (min-width: 600px) {
                .background-full {
                    height: 100vh;
                }

                .section-modo{
                    background: #ffffff;
                    padding: 20px 25px;
                    border-radius: 20px; 
                }

                .box-plane {
                    background: #e0e0e0;
                    border-radius: 0;
                }


            }


        </style>
    </div>


@stop
