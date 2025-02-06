@extends('layouts.lyontech')
@section('bootstrap')
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    {{-- <link rel="stylesheet" href="{{ asset('theme-lyontech/css/5.css') }}"> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
@stop
@section('content')

    {{-- <body class="img js-fullheight" style="background-image: url({{ asset('theme-lyontech/images/login.png') }});">
        <div class="container-fluid">
            <div class="row align-content-center justify-content-center">
                <div class="col-lg-7 col-md-7 col-sm-6">
                    <div class="container-fluid ">
                        <div class="col-lg-12 col-md-12 col-sm-10">
                            <div class="card card-transparent text-login">
                                <h5>BIENVENIDOS</h5>
                                <p style=" font-size: 52px; letter-spacing: -1px; word-spacing: -1px; line-height: 1;">
                                    a la prueba gratuita <br>
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
    </body> --}}
    <body class="background-full" style="background-image: url({{ asset('theme-lyontech/images/login.png') }}); 
            background-size: cover; background-position: center; 
            background-repeat: no-repeat;">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-7">
                        <div class="card card-transparent centrado-absoluto">
                            <div class="contenido">
                                <h1>BIENVENIDO</h1>
                                {{-- <p style=" font-size: 52px; letter-spacing: -1px; word-spacing: -1px; line-height: 1;"> --}}
                                <p>
                                    a la prueba gratuita 
                                    de Lyonteach.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="centrado-absoluto">
                            @livewire('auth.ly-register-form')
                        </div>
                    </div>
                </div>
            </div> 
        <style>
            .background-full {
                background-size: cover; /* Ajusta la imagen para cubrir toda la pantalla */
                background-position: center; /* Centra la imagen */
                background-repeat: no-repeat; /* Evita que la imagen se repita */
                height: 100vh; /* Altura del viewport */
                margin: 0; /* Elimina márgenes */

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

            .card {
                    border-radius: 10px;
                    padding: 20px;
                    width: 100%;
                
            }

            .card-transparent {
                background-color: transparent !important;
                border: none; /* Elimina el borde */
                color: white;
            }

            .centrado-absoluto {
                display: flex;
                justify-content: center;
                align-items: center;
                margin: 0;
                height: auto;
            }
            .centrado-absoluto .contenido {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                font-family: Arial, sans-serif;
                padding-bottom: 60px;
            }

            .card-transparent .contenido h1{
                font-family: "Rubik", Medium;
                font-size: 40px;
                font-weight: 600;
                text-align: center;
                margin-bottom:0;
            }

            
            .card-transparent .contenido p{
                font-family: "Rubik", Light;
                font-weight: 300;
                font-size: 18px;
                text-align: center;
            }

            @media (min-width: 600px) {
                
                .centrado-absoluto {
                    height: 100vh;
                    }
                .centrado-absoluto .contenido {
                    padding-bottom: 0px;
                }
                
                .card-transparent .contenido h1{
                    font-family: "Rubik", Medium;
                    font-size: 70px;
                    font-weight: 600;
                    text-align: left;
                    margin-bottom:0;
                }

                
                .card-transparent .contenido p{
                    font-family: "Rubik", Light;
                    font-weight: 300;
                    font-size: 45px;
                    letter-spacing: -1px; word-spacing: -1px; line-height: 1;
                    text-align: left;
                }
            }



            
            .text-login h5{
                font-size: 3.6rem  !important;
                color: #ffffff !important;
                font-family: "Rubik", Medium;
                font-weight: 500;
                text-align: left;
                margin-bottom:0;
            }
            .text-login p{
                color: #ffffff !important;
                margin-top: 0;
                margin-bottom:0;
                font-family: "Rubik", Light;
                font-weight: 300;
                line-height: 1.5; /* Increase line spacing for readability */
                text-align: justify; /* Justify text to fill the container */
            }
            .text-left h5{
                font-family: "Rubik", Bold;
                font-weight: 700;
                font-size: 40px;
            }
            .text-left p{
                font-family: "Rubik", Light;
                font-weight: 300;
                font-size: 25px;
            }

            .card h5{
                font-family: "Rubik", Bold;
                font-weight: 700;
                font-size: 40px;
            }
            .card p{
                font-family: "Rubik", Light;
                font-weight: 300;
                font-size: 25px;
            }
            .card a{
                font-family: "Rubik", Medium;
                font-weight: 500;
                font-size: 25px;
            }

            .form-login{
                font-family: "Rubik", Medium;
                font-weight: 500; 
            }

            /***formulario**/
            .form-login input{
                width: 100%;  
                height: auto;
                font-size: 16px;
                color: black;
                border: none;
                border-bottom: 1px solid black;
                outline: none;
                flex: 5px;
            }

            .form-row > div {
                flex: 1;
                margin-right: 10px; 
            }
            .form-select{
                font-family: "Rubik", Medium;
                font-weight: 500; 
            }

            .form-select select{

                width: 100%;  
                font-size: 16px;
                color: black;
                margin: 0;
                border: none;
                border-bottom: 1px solid black;
                outline: none;
                flex: 5px;
            }

            .form-group button.btn-primary.submit {
                margin-top: 30px;
                background-color: rgb(135, 32, 82) !important; /* Primary blue color */
                color: white !important; /* White text color */
                border-color: #007bff; /* Maintain border color consistency */
                text-align: center; /* Center the text within the button */
                border-radius: 0%;
                padding: 5px 10px !important ;
                font-family: "Rubik", Medium;
                font-weight: 500; 
            }  
            .btn-cent{
                width: 70%; /* Ancho personalizado */
                margin: 0 auto; /* Centrar horizontalmente */
                text-align: center; /* Alinear texto en el centro */
                padding-bottom: 40px;
            }  
        </style>
    </body>
@stop
