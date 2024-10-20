<div class="">
    <div class="container page__container">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME','Laravel') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('academic_courses') }}">{{ __('academic::labels.courses') }}</a></li>
            <li class="breadcrumb-item">{{ $course->name }}</li>
            <li class="breadcrumb-item active">{{ __('academic::labels.sections') }}</li>

        </ol>
    </div>
    <div class="container page__container">
        <div class="col-lg-12 p-0 mx-auto">
            <div class="card card-body mb-32pt">
                <div class="row">
                    <div class="col-lg-4">
                        <h4 class="card-title">Listado</h4>
                        <p class="text-70">Secciones del Curso {{ $course->name }}</p>
                        @can('academico_secciones_nuevo')
                        <a href="{{ route('academic_sections_create',$this->course_id) }}" type="button" class="btn btn-primary">Nuevo</a>
                        @endcan
                    </div>
                    <div class="col-lg-8 d-flex align-items-center">
                        <!-- Wrapper -->
                        <div class="table-responsive" data-toggle="lists" data-lists-values='["name"]'>
                            <!-- Table -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Acciones</th>
                                        <th>{{ __('labels.Sort') }}</th>
                                        <th>Titulo</th>
                                        <th>Descripción</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @foreach($sections as $key => $section)
                                    <tr>
                                        <td class="text-center align-middle">{{ $key + 1 }}</td>
                                        <td class="text-center align-middle">
                                            <div class="btn-group">
                                                @can('academico_secciones_editar')
                                                <a href="{{ route('academic_sections_editar',[$course_id,$section->id]) }}" type="button" class="btn btn-info btn-sm" title="Editar"><i class="fa fa-pencil-alt"></i></a>
                                                @endcan
                                                @can('academico_contenido')
                                                <a href="{{ route('academico_contenido',[$course_id,$section->id]) }}" type="button" class="btn btn-info btn-sm" title="Ver/Editar {{ __('labels.Content') }}:{{ $section->title }}"><i class="fa fa-list-alt"></i></a>
                                                @endcan
                                                @can('academico_secciones_eliminar')
                                                <button onclick="deletes({{ $section->id }})" type="button" class="btn btn-danger btn-sm" title="Eliminar"><i class="fa fa-trash-alt"></i></button>
                                                @endcan
                                            </div>
                                        </td>

                                        <td class="text-center align-middle">
                                            @if ($section->count <= 1 && $count>1)
                                            <div  role="group" aria-label="Group A" >
                                                <button wire:click="changeordernumber('{{ $section->count }}','{{ $section->id }}', 'down')" type="button" class="btn btn-info btn-sm" title="{{ __('labels.Down') }}"><i class="fas fa-angle-down"></i></button>
                                            </div>
                                            @endif

                                            @if ($section->count > 1 && $section->count < $sections->count())
                                            <div  role="group" aria-label="Group A" >
                                                <button wire:click="changeordernumber('{{ $section->count }}','{{ $section->id }}', 'down')" type="button" class="btn btn-info btn-sm" title="{{ __('labels.Down') }}"><i class="fas fa-angle-down"></i></button>
                                                <button wire:click="changeordernumber('{{ $section->count }}','{{ $section->id }}', 'up')" type="button" class="btn btn-info btn-sm" title="{{ __('labels.Up') }}"><i class="fas fa-angle-up"></i></button>
                                            </div>
                                            @endif

                                            @if ($section->count == $sections->count() && $count>1)
                                            <div  role="group" aria-label="Group A" >
                                                <button wire:click="changeordernumber('{{ $section->count }}','{{ $section->id }}', 'up')" type="button" class="btn btn-info btn-sm" title="{{ __('labels.Up') }}"><i class="fas fa-angle-up"></i></button>
                                            </div>
                                            @endif
                                        </td>

                                        <td class="name align-middle">{{ $section->title }}</td>
                                        <td class="name align-middle">{{ $section->description }}</td>
                                        <td class="align-middle">
                                            @if($section->status)
                                            <span class="badge badge-success">Activo</span>
                                            @else
                                            <span class="badge badge-danger">Inactivo</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-end" colspan="3">
                                            <div class="d-flex flex-row-reverse">
                                                {{ $sections->links() }}
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
        window.addEventListener('aca-section-delete', event => {
            cuteAlert({
                type: event.detail.res,
                title: event.detail.tit,
                message: event.detail.msg,
                buttonText: "Okay"
            });
        })
    </script>
</div>
