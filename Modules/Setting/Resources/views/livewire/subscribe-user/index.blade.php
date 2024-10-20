<div class="">
    <div class="container page__container">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME', 'Laravel') }}</a></li>
            <li class="breadcrumb-item active">Subscribir Usuario</li>
        </ol>
    </div>
    <div class="container page__container">
        <div class="col-lg-12 p-0 mx-auto">
            <div class="card card-body mb-32pt">
                <div class="row">
                    <div class="col-lg-4">
                        <h4 class="card-title">Listado</h4>
                        <p class="text-70">Modos</p>
                        <a href="{{ route('setting_suscripcion_usuarios_create') }}" type="button"
                            title="Para suscribir a un nuevo usuario este debe registrarse primero" class="btn btn-primary">Nuevo</a>
                    </div>
                    <div class="col-lg-8 d-flex align-items-center">
                        <!-- Wrapper -->
                        <div class="table-responsive" data-toggle="lists" data-lists-values='["name"]'>
                            <!-- Search -->
                            <div class="search-form search-form--light mb-3">
                                <input wire:keydown.enter="getSearch" wire:model.defer="search" type="text"
                                    class="form-control search" placeholder="Search">
                                <button class="btn" type="button" role="button"><i
                                        class="material-icons">search</i></button>
                            </div>
                            <!-- Table -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Acciones</th>
                                        <th>Usuario</th>
                                        <th>Tipo de Suscripción</th>
                                        <th>F. Inicio</th>
                                        <th>F. Finaliza</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @foreach ($people as $key => $person)
                                        <tr>
                                            <td class="text-center align-middle">{{ $key + 1 }}</td>
                                            <td class="text-center align-middle">
                                                <div class="btn-group">

                                                    <a href="{{ route('setting_suscripcion_usuarios_editar', $person->type_subscription_id) }}"
                                                        type="button" class="btn btn-info btn-sm"><i
                                                            class="fa fa-pencil-alt"></i></a>

                                                    <button onclick="deletes({{ $person->type_subscription_id }})"
                                                        type="button" class="btn btn-danger btn-sm"><i
                                                            class="fa fa-trash-alt"></i></button>

                                                </div>
                                            </td>
                                            <td class="name align-middle">{{ $person->full_name }}</td>
                                            <td class="name align-middle">{{ $person->type_subscription }}</td>
                                            <td class="name align-middle col-3">{{ $person->date_start }}</td>
                                            <td class="name align-middle col-3">{{ $person->date_end }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-end" colspan="3">
                                            <div class="d-flex flex-row-reverse">
                                                {{ $people->links() }}
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
    </div>
    <script>
        function deletes(id) {
            cuteAlert({
                type: "question",
                title: "¿Desea eliminar estos datos?",
                message: "Advertencia:¡Esta acción no se puede deshacer!",
                confirmText: "Okay",
                cancelText: "Cancel"
            }).then((e) => {
                if (e == ("confirm")) {
                    @this.destroy(id);
                }
            });
        }
        window.addEventListener('set-subscription-modes-destroy', event => {
            @this.getModes();
            cuteAlert({
                type: event.detail.res,
                title: event.detail.tit,
                message: event.detail.msg,
                buttonText: "Okay"
            });
        })
    </script>
</div>
