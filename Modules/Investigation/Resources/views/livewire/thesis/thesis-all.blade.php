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
                                <input wire:keydown.enter="getSearch" wire:model.defer="search" type="text"
                                    class="form-control search" placeholder="Search" value="">
                                <button class="btn" type="button" role="button"><i
                                        class="material-icons">search</i></button>
                            </div>
                            <!-- Table -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Acciones</th>
                                        <th class="">Estudiante</th>
                                        <th class="">Titulo Tesis</th>
                                        <th class="">
                                            {{ __('labels.University') }}/{{ __('labels.Country') }}</th>
                                        <th class="">{{ __('labels.School') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @foreach ($thesis as $key => $thesi)
                                        <tr>
                                            <td class="text-center align-middle">{{ $key + 1 }}</td>
                                            <td class="text-center align-middle">
                                                <div class="btn-group">
                                                    @can('investigacion_partes_editar')
                                                        <a href="{{ route('investigation_thesis_check', $thesi->external_id) }}"
                                                            type="button" class="btn btn-info btn-sm" title="check"><i
                                                                class="fa fa-search-plus"></i>
                                                        </a>
                                                    @endcan
                                                    @can('investigacion_tesis_admin_eliminar')
                                                        <button onclick="deletes('{{ $thesi->external_id }}')"
                                                            type="button" class="btn btn-danger btn-sm" title="Eliminar"><i
                                                                class="fa fa-trash-alt"></i></button>
                                                    @endcan
                                                </div>
                                            </td>
                                            <td class="align-middle">{{ $thesi->full_name }}</td>
                                            <td class="align-middle">{{ $thesi->title }}</td>
                                            <td class="align-middle">
                                                {{ $this->getNameUniversity($thesi->university_id) }}
                                            </td>
                                            <td class="align-middle">
                                                {{ $this->getNameSchool($thesi->school_id) }}
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-end" colspan="6">
                                            <div class="d-flex flex-row-reverse">
                                                {{ $thesis->links() }}
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
    </script>
</div>
