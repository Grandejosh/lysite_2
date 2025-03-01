@extends('layouts.tutorio')
@section('lycss')
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <!--<link rel="stylesheet" href="{{ asset('theme-lyontech/css/11.css') }}">-->
@stop
@section('content')
    {{-- <div class="img js-fullheight" style="background-image: url({{ asset('theme-lyontech/images/fondo-naranja.jpg') }});">
        @livewire('auth.ly-login-form')
    </div> --}}

    <div class="background-full" style="background-image: url({{ asset('theme-lyontech/images/fondo-naranja.jpg') }}); 
            background-size: cover; background-position: center; 
            background-repeat: no-repeat;">
            <div class="container-xl section-modo">
                @livewire('auth.ly-login-form')
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
