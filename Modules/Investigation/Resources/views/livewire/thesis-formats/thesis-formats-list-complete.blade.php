<div class="">
    <div class="container page__container">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME','Laravel') }}</a></li>
            <li class="breadcrumb-item active">{{ __('labels.Thesis Formats') }}</li>
        </ol>
    </div>
    <div class="container page__container">
        <div class="col-lg-12 p-0 mx-auto">
            <div class="card card-body mb-32pt">
                <div class="row">
                    <div class="col-lg-4">
                        <h4 class="card-title">Listado</h4>
                        <p class="text-70">{{ __('labels.All Format Thesis') }}</p>
                        @can('investigacion_partes_nuevo')
                        <a href="{{ route('Investigation_thesis_formats_create_complete') }}" type="button" class="btn btn-primary">Crear Nuevo Formato</a>
                        @endcan
                    </div>
                    <div class="col-lg-8 d-flex align-items-center">
                        <!-- Wrapper -->
                        <div class="table-responsive" data-toggle="lists" data-lists-values='["name"]'>
                            <!-- Search -->
                            <div class="search-form search-form--light mb-3">
                                <input wire:keydown.enter="getSearch" wire:model.defer="search" type="text" class="form-control search" placeholder="Search" value="">
                                <button class="btn" type="button" role="button"><i class="material-icons">search</i></button>
                            </div>
                            <!-- Table -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Acciones</th>
                                        <th class="text-center">{{ __('labels.Thesis') }}</th>
                                        <th class="text-center">{{ __('labels.Type') }}</th>
                                        <th class="text-center">{{ __('labels.Style') }}</th>
                                        <th class="text-center">{{ __('labels.University') }}/{{ __('labels.Country') }}</th>
                                        <th class="text-center">{{ __('labels.School') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @foreach($formats as $key => $format)
                                    <tr>
                                        <td class="text-center align-middle">{{ $key + 1 }}</td>
                                        <td class="text-center align-middle">
                                            <div class="btn-group">
                                                @can('investigacion_partes_editar')
                                                <a href="{{ route('Investigation_thesis_formats_edit_complete',$format->id) }}" type="button" class="btn btn-info btn-sm" title="Editar"><i class="fa fa-pencil-alt"></i></a>
                                                @endcan
                                                @can('investigacion_partes')
                                                <a href="{{ route('investigation_parts',$format->id) }}" type="button" class="btn btn-success btn-sm" title="Partes"><i class="fa fa-newspaper"></i></a>
                                                @endcan
                                                <button wire:loading wire:target="formatClone" wire:loading.attr="disabled" wire:click="formatClone({{ $format->id }})" type="button" class="btn btn-warning btn-sm" title="Clonar"><i class="fa fa-clone"></i></button>
                                                @can('investigacion_partes_eliminar')
                                                <button onclick="deletes({{ $format->id }})" type="button" class="btn btn-danger btn-sm" title="Eliminar"><i class="fa fa-trash-alt"></i></button>
                                                @endcan
                                            </div>
                                        </td>
                                        <td>{{ $format->name }}</td>
                                        <td class="text-center align-middle">{{ $format->type_thesis }}</td>
                                        <td class="text-center align-middle">{{ $format->normative_thesis }}</td>
                                        <td>{{ $this->getNameUniversity($format->school_id) }}</td>
                                        <td>{{ $this->getNameSchool($format->school_id) }}</td>

                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-end" colspan="3">
                                            <div class="d-flex flex-row-reverse">
                                                {{ $formats->links() }}
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
        function deletes(id){
            cuteAlert({
                type: "question",
                title: "¿Desea eliminar estos datos?",
                message: "Advertencia:¡Esta acción no se puede deshacer!",
                confirmText: "Okay",
                cancelText: "Cancel"
            }).then((e)=>{
                if ( e == ("confirm")){
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
        });

    </script>
</div>
