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
                        {{-- <form>
                            <div class="form-group">
                                <label>&nbsp;Número de tarjeta</label>
                                <input class="form-control form-control-lg" type="text"
                                    placeholder="1234 1234 5647 5647">
                            </div>
                            <div class="form-group">
                                <label>&nbsp;Nombre del titular</label>
                                <input class="form-control form-control-lg" type="text"
                                    placeholder="Ej. : Mieguel Neciosup">
                            </div>
                            <div class="form-group">
                                <label>&nbsp;Vencimiento</label>
                                <input class="form-control form-control-lg" type="text" placeholder="MM/AA">
                            </div>
                            <div class="form-group">
                                <label>&nbsp;Código de seguridad</label>
                                <input class="form-control form-control-lg " type="text" placeholder="123">
                            </div>
                            <div class="form-group btn-cent ">
                                <button type="submit" class="btn btn-pagar">Pagar</button>
                                <button type="submit" class="btn btn-volver">Volver</button>
                            </div>
                        </form> --}}

                        <div id="cardPaymentBrick_container"></div>
                    </div>
                </div>
            </div>

        </div>

        @if ($preference_id)
            <script>
                const mp = new MercadoPago("{{ env('MERCADOPAGO_KEY') }}", {
                    locale: 'es-PE'
                });
                const bricksBuilder = mp.bricks();
                const renderCardPaymentBrick = async (bricksBuilder) => {
                    const settings = {
                        initialization: {
                            preferenceId: "{{ $preference_id }}",
                            amount: {{ $price }},
                        },
                        customization: {
                            visual: {
                                style: {
                                    customVariables: {
                                        theme: 'bootstrap',
                                    }
                                }
                            },
                            paymentMethods: {
                                maxInstallments: 1,
                            }
                        },
                        callbacks: {
                            onReady: () => {
                                // callback llamado cuando Brick esté listo
                            },
                            onSubmit: (cardFormData) => {
                                //  callback llamado cuando el usuario haga clic en el botón enviar los datos
                                //  ejemplo de envío de los datos recolectados por el Brick a su servidor
                                return new Promise((resolve, reject) => {
                                    fetch("{{ route('web_process_payment', $us_id) }}", {
                                            method: "PUT",
                                            headers: {
                                                "Content-Type": "application/json",
                                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                            },
                                            body: JSON.stringify(cardFormData)
                                        })
                                        .then((response) => {
                                            if (!response.ok) {
                                                return response.json().then(error => {
                                                    throw new Error(error.error);
                                                });
                                            }
                                            return response.json();

                                        })
                                        .then((data) => {
                                            if (data.status == 'approved') {
                                                window.location.href = data.url;
                                            } else {
                                                alert('No se pudo continuar el proceso');
                                                window.location.href = data.url;
                                            }
                                        })
                                        .catch((error) => {
                                            if (error instanceof SyntaxError) {
                                                // Si hay un error de sintaxis al analizar la respuesta JSON
                                                alert('Error al procesar el pago.');
                                            } else {
                                                // Mostrar la alerta con el mensaje de error devuelto por el backend
                                                alert(error.message);
                                            }
                                        })
                                });
                            },
                            onError: (error) => {
                                console.log(error)
                            },
                        },
                    };
                    window.cardPaymentBrickController = await bricksBuilder.create('cardPayment',
                        'cardPaymentBrick_container', settings);
                };
                renderCardPaymentBrick(bricksBuilder);
            </script>
        @endif
    </body>
</div>
@stop
