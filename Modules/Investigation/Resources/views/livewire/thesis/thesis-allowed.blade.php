<div class="">
    <div class="container page__container">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME', 'Laravel') }}</a></li>
            <li class="breadcrumb-item active">{{ __('labels.Thesis Formats') }}</li>
        </ol>
    </div>
    <div class="container page__container">
        <div class="col-lg-12 p-0 mx-auto">
            <div class="card card-body mb-32pt">
                <div class="row">
                    <div class="col-lg-12 d-flex align-items-center">
                        <!-- Wrapper -->
                        <div class="table-responsive" data-toggle="lists" data-lists-values='["name"]'>
                            <!-- Search -->
                            <div class="search-form search-form--light mb-3">
                                <input wire:keydown.enter="getPeople" wire:model.defer="search" type="text"
                                    class="form-control search" placeholder="Search" value="">
                                <button class="btn" type="button" role="button"><i
                                        class="material-icons">search</i></button>
                            </div>
                            <!-- Table -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Tesis Permitidas</th>
                                        <th class="text-center">Tesis Creadas</th>
                                        <th class="text-center">Parafraseos Permitidos</th>
                                        <th class="text-center">Parafraseos realizados</th>
                                        <th class="">Estudiante</th>
                                        <th class="">Documento de Identidad</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @foreach ($people as $key => $person)
                                        <tr>
                                            <td class="text-center align-middle">{{ $key + 1 }}</td>
                                            <td class="align-middle col-md-2">
                                                @can('investigacion_thesis_allowed')
                                                    <input class="form-control" type="number" name="" min="0"
                                                        max="100" step="1" maxlength="2"
                                                        onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"
                                                        onchange="changeAllowedThesis({{ $person->id }})"
                                                        id="{{ 'p' . $person->id }}" value="{{ $person->allowed_thesis }}">
                                                @endcan
                                            </td>
                                            <td class="align-middle" align="center">{{ $person->created_thesis }}</td>

                                            <td class="align-middle col-md-2">
                                                @can('investigacion_thesis_allowed')
                                                    <input class="form-control" type="number" name="" min="0"
                                                        max="1000" step="10" maxlength="4"
                                                        onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"
                                                        onchange="changeAllowedParaphrase({{ $person->id }})"
                                                        id="{{ 'para' . $person->id }}"
                                                        value="{{ $person->paraphrase_allowed }}">
                                                @endcan
                                            </td>
                                            <td class="align-middle" align="center">
                                                {{ $person->paraphrase_used > 0 ? $person->paraphrase_used : 0 }}</td>
                                            <td class="align-middle">{{ $person->full_name }}</td>
                                            <td class="align-middle">{{ $person->number }}</td>

                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-end" colspan="7">
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
                    @this.destroy(id)
                }
            });
        }
        window.addEventListener('inve-format-thesis-delete', event => {
            cuteAlert({
                type: event.detail.res,
                title: event.detail.tit,
                message: event.detail.msg,
                buttonText: "Okay"
            });
        })

        function changeAllowedThesis(id) {
            valor = document.getElementById("p" + id).value;
            @this.changeAllowedThesis(id, valor);
        }

        function changeAllowedParaphrase(id) {
            valor = document.getElementById("para" + id).value;
            @this.changeAllowedParaphrase(id, valor);
        }
    </script>
</div>
