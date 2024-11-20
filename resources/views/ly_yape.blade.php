@extends('layouts.tutorio')
@section('lycss')
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <!--<link rel="stylesheet" href="{{ asset('theme-lyontech/css/14-datos.css') }}">-->
    <script src="https://sdk.mercadopago.com/js/v2"></script>

@stop
@section('content')
    <div class="img js-fullheight" style="background-image: url({{ asset('theme-lyontech/images/fondo-naranja.jpg') }});">

        <body>
            <div class="container-section-pagar">
                <br>
                <div class="row align-content-center">
                    <div class="col-lg-7 col-md-7 col-sm-6">
                        <div class="container-fluid ">
                            <div class="col-lg-12 col-md-12 col-sm-10">
                                <div class="card card-transparent text-login">
                                    <h5>MEJORA</h5>
                                    <p style="font-size: 52px; letter-spacing: -1px; word-spacing: -1px; line-height: 1;">
                                        Adquiere tu <br>
                                        cuenta con mejores <br>
                                        oportunidades
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5 col-md-5 col-sm-6 text-left">
                        <div class="card" style="padding: 20px;">
                            <h5>Completa tus datos</h5>
                            <p>Monto a pagar: S/. {{ number_format($price, 2, '.', '') }}</p>
                            <div class="signin-form" id="form-checkout">
                                <div class="form-login">
                                    <label for="payerPhone">&nbsp;Número de teléfono</label>
                                    <input id="form-checkout__payerPhone" name="payerPhone" type="text" />
                                </div>
                                <div class="form-login">
                                    <label for="payerOTP">&nbsp;Código de aprobación</label>
                                    <input id="form-checkout__payerOTP" name="payerOTP" type="text" />
                                </div>
                                <div class="form-group btn-cent ">
                                    <button onclick="handleYape()" type="button" class="btn btn-pagar">Pagar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


        </body>
    </div>
@stop
@section('script')
    <script>
        const mp = new MercadoPago("{{ env('MERCADOPAGO_KEY') }}", {
            locale: 'es-PE'
        });

        async function handleYape() {
            try {
                // Obtener valores de los inputs
                const otp = document.getElementById("form-checkout__payerOTP").value;
                const phoneNumber = document.getElementById("form-checkout__payerPhone").value;

                // Configurar las opciones de Yape
                const yapeOptions = {
                    otp,
                    phoneNumber
                };

                // Crear el token de Yape
                const yape = mp.yape(yapeOptions);
                const yapeToken = await yape.create(); // Esperamos el token usando await

                // Enviar el token al servidor
                const response = await fetch("{{ route('web_process_payment', $us_id) }}", {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json', // Enviamos datos como JSON
                        'X-CSRF-TOKEN': "{{ csrf_token() }}" // CSRF Token para Laravel
                    },
                    body: JSON.stringify({
                        token: yapeToken.id, // Pasamos el ID del token
                        payment_method_id: 'yape'
                    })
                });

                // Manejo de la respuesta del servidor
                if (!response.ok) {
                    const error = await response.json();
                    throw new Error(error.error);
                }

                const data = await response.json();

                // Procesar la respuesta según el estado
                if (data.status === 'approved') {
                    window.location.href = data.url; // Redirigir si el pago fue aprobado
                } else {
                    alert('No se pudo continuar el proceso');
                    window.location.href = data.url; // Redirigir a la URL proporcionada
                }
            } catch (error) {
                // Manejo de errores
                console.error('Error al manejar el proceso de Yape:', error);
            }
        }
    </script>
@stop
