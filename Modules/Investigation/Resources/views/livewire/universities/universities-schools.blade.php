<div class="">
    <div class="container page__container">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME','Laravel') }}</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('Investigation_universities_list') }}">{{ __('labels.universities') }}</a></li>
            <li class="breadcrumb-item active">{{ $university->siglas }}</li>
            <li class="breadcrumb-item active">{{ __('labels.schools') }}</li>
        </ol>
    </div>
    <div class="container page__container">
        <div class="col-lg-12 p-0 mx-auto">
            <div class="card card-body mb-32pt">
                <div class="row">
                    <div class="col-lg-4">
                        <h4 class="card-title">Listado</h4>
                        <p class="text-70">Módulos del sistema</p>
                        @can('universities_create')
                        <a href="{{ route('Investigation_universities_schools_create',$university->id) }}" type="button" class="btn btn-primary">Nuevo</a>
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
                                        <th class="text-center">{{ __('labels.School name') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @foreach($schools as $key => $school)
                                    <tr>
                                        <td class="text-center align-middle">{{ $key + 1 }}</td>
                                        <td class="text-center align-middle">
                                            <div class="btn-group">
                                                @can('universities_edit')
                                                <a href="{{ route('Investigation_universities_schools_edit',[$university->id,$school->id]) }}" type="button" class="btn btn-info btn-sm" title="Editar"><i class="fa fa-pencil-alt"></i></a>
                                                @endcan
                                                @can('investigacion_partes')
                                                <a href="{{ route('Investigation_thesis_formats_list',$school->id) }}" type="button" class="btn btn-success btn-sm" title="{{ __('labels.Thesis') }}"><i class="fa fa-book"></i></a>
                                                @endcan
                                                @can('universities_delete')
                                                <button onclick="deletes({{ $school->id }})" type="button" class="btn btn-danger btn-sm" title="Eliminar"><i class="fa fa-trash-alt"></i></button>
                                                @endcan
                                            </div>
                                        </td>
                                        <td>{{ $school->name }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-end" colspan="3">
                                            <div class="d-flex flex-row-reverse">
                                                {{ $schools->links() }}
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
        window.addEventListener('aca-universitie-delete', event => {
            cuteAlert({
                type: event.detail.res,
                title: event.detail.tit,
                message: event.detail.msg,
                buttonText: "Okay"
            });
        })
    </script>
</div>
