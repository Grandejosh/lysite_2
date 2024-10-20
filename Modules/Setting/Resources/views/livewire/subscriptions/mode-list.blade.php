<div class="">
    <div class="container page__container">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME', 'Laravel') }}</a></li>
            <li class="breadcrumb-item active">Modos de Suscripción</li>
        </ol>
    </div>
    <div class="container page__container">
        <div class="col-lg-12 p-0 mx-auto">
            <div class="card card-body mb-32pt">
                <div class="row">
                    <div class="col-lg-4">
                        <h4 class="card-title">Listado</h4>
                        <p class="text-70">Modos</p>
                        <a href="{{ route('setting_subscriptions_create') }}" type="button"
                            class="btn btn-primary">Nuevo</a>
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
                                        <th>Nombre</th>
                                        <th>precio</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @foreach ($modos as $key => $modo)
                                        <tr>
                                            <td class="text-center align-middle">{{ $key + 1 }}</td>
                                            <td class="text-center align-middle">
                                                <div class="btn-group">

                                                    <a href="{{ route('setting_subscriptions_editar', $modo->id) }}"
                                                        type="button" class="btn btn-info btn-sm"><i
                                                            class="fa fa-pencil-alt"></i></a>

                                                    <button onclick="deletes({{ $modo->id }})" type="button"
                                                        class="btn btn-danger btn-sm"><i
                                                            class="fa fa-trash-alt"></i></button>

                                                </div>
                                            </td>
                                            <td class="name align-middle">{{ $modo->name }}</td>
                                            <td class="name align-middle">{{ $modo->price }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
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
