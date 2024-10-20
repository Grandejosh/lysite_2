<div class="">
    <style>
        .radio-group {
            display: flex;
        }

        .radio-group input[type="radio"] {
            margin-right: 10px;
        }
    </style>

    <div class="container page__container">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME', 'Laravel') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('setting_suscripcion_usuarios') }}">Suscribir Usuarios</a></li>
            <li class="breadcrumb-item active">Nuevo</li>
        </ol>
    </div>
    <div class="container page__container" wire.ignore>
        <div class="col-lg-12 p-0 mx-auto">
            <div class="card card-body mb-32pt">
                <div class="row">
                    <!-- Search -->
                    <div class="search-form search-form--light mb-3">
                        <input wire:keydown.enter="getSearch" wire:model.defer="search" type="text"
                            class="form-control search" placeholder="Search">
                        <button class="btn" type="button" role="button"><i
                                class="material-icons">search</i></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <h4 class="card-title">Formulario de registro</h4>
                        <p class="text-70">todos los campos que tienen * son obligatorios para el registro</p>
                    </div>
                    <div class="col-lg-8 d-flex align-items-center">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Usuario</th>
                                    <th>Tipo de Suscripción</th>
                                    <th class="text-center">Suscribir</th>
                                </tr>
                            </thead>
                            <tbody class="list" wire:ignore.self>
                                @foreach ($users as $key => $user)
                                    <tr>
                                        <td class="text-center align-middle">{{ $key + 1 }}</td>
                                        <td class="name align-middle" title="{{ $user->names }}">{{ $user->full_name }}
                                        </td>
                                        <td class="name align-middle">
                                            <div class="name align-middle">
                                                <select class="form-control" name="type_subs"
                                                    id="type_subs{{ $user->id }}">
                                                    <option onclick="actualizarBoton(this, {{ $key }})"
                                                        value="0">Seleccionar</option>
                                                    @foreach ($type_subscriptions as $keya => $type_sub)
                                                        <option id="{{ $key }}type_subs{{ $keya }}"
                                                            onclick="actualizarBoton(this, {{ $key }})"
                                                            value="{{ $type_sub->id }}">{{ $type_sub->name }}</option>
                                                        {{-- <input onclick="actualizarBoton(this, {{ $key }})" type="radio" id="{{ $key }}type_subs{{ $keya }}" name="type_subs" value="{{ $type_sub->id }}">
                                                    <label for="{{ $key }}type_subs{{ $keya }}">{{ $type_sub->name }}</label> --}}
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td class="name align-middle">
                                            {{-- envío el userID junto al valor del typeSubscrID --}}
                                            <button class="btn btn-primary" id="btn-{{ $key }}" type="button"
                                                value=""
                                                onclick="confirmaSuscripcion({{ $user->user_id }},{{ $key }})">
                                                Suscribir
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-end" colspan="3">
                                        <div class="d-flex flex-row-reverse">
                                            {{ $users->links() }}
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function actualizarBoton(radio, key) {
            var boton = document.getElementById("btn-" + key);
            boton.value = radio.value;
        }
    </script>
    <script>
        function confirmaSuscripcion(id, ke) {
            cuteAlert({
                type: "question",
                title: "¿Confirmar suscripcion?",
                message: "Suscribir al Usuario la membresía seleccionada",
                confirmText: "Okay",
                cancelText: "Cancel"
            }).then((e) => {
                if (e == ("confirm")) {
                    let but = document.getElementById("btn-" + ke);
                    var valor = but.getAttribute('value');
                    @this.subscribingUser(id, valor);
                }
            });
        }
        window.addEventListener('set-subscription-modes-user', event => {
            cuteAlert({
                type: event.detail.res,
                title: event.detail.tit,
                message: event.detail.msg,
                buttonText: "Okay"
            });
        })
    </script>
</div>
