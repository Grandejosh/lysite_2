<div class="">
    <div class="container page__container">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME','Laravel') }}</a></li>
            <li class="breadcrumb-item active">{{ __('academic::labels.instructors') }}</li>
        </ol>
    </div>
    <div class="container page__container">
        <div class="col-lg-12 p-0 mx-auto">
            <div class="card card-body mb-32pt">
                <div class="row">
                    <div class="col-lg-4">
                        <h4 class="card-title">Listado</h4>
                        <p class="text-70">Módulos del sistema</p>
                        @can('configuraciones_modulos_nuevo')
                        <a href="{{ route('academic_instructors_create') }}" type="button" class="btn btn-primary">Nuevo</a>
                        @endcan
                    </div>
                    <div class="col-lg-8 d-flex align-items-center">
                        <!-- Wrapper -->
                        <div class="table-responsive" data-toggle="lists" data-lists-values='["name"]'>
                            <!-- Search -->
                            <div class="search-form search-form--light mb-3">
                                <input wire:keydown.enter="getSearch" wire:model.defer="search" type="text" class="form-control search" placeholder="Search">
                                <button class="btn" type="button" role="button"><i class="material-icons">search</i></button>
                            </div>
                            <!-- Table -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Acciones</th>
                                        <th>Curso</th>
                                        <th>Tipo documento</th>
                                        <th>Número</th>
                                        <th>Nombre</th>
                                        <th>Teléfono</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @foreach($instructors as $key => $instructor)
                                    <tr>
                                        <td class="text-center align-middle">{{ $key + 1 }}</td>
                                        <td class="text-center align-middle">
                                            <div class="btn-group">
                                                @can('academico_alumnos_editar')
                                                <a href="{{ route('academic_instructors_edit',$instructor->id) }}" type="button" class="btn btn-info btn-sm" title="Editar"><i class="fa fa-pencil-alt"></i></a>
                                                @endcan
                                                {{-- @can('academico_alumnos_eliminar')
                                                <button onclick="deletes({{ $instructor->id }})" type="button" class="btn btn-danger btn-sm" title="Eliminar"><i class="fa fa-trash-alt"></i></button>
                                                @endcan --}}
                                            </div>
                                        </td>
                                        <td class="name align-middle">{{ $instructor->name }}</td>
                                        <td class="name align-middle">{{ $instructor->document_type_name }}</td>
                                        <td class="name align-middle">{{ $instructor->number }}</td>
                                        <td class="name align-middle">{{ $instructor->full_name }}</td>
                                        <td class="name align-middle">{{ $instructor->mobile_phone }}</td>
                                        <td class="name align-middle">{{ $instructor->email }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-end" colspan="3">
                                            <div class="d-flex flex-row-reverse">
                                                {{ $instructors->links() }}
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
        window.addEventListener('aca-instructor-delete', event => {
            cuteAlert({
                type: event.detail.res,
                title: event.detail.tit,
                message: event.detail.msg,
                buttonText: "Okay"
            });
        })
    </script>
</div>
