<div class="">
    <div class="container page__container">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME','Laravel') }}</a></li>
            <li class="breadcrumb-item active">{{ __('labels.Courses') }}</li>
        </ol>
    </div>
    <div class="container page__container">
        <div class="col-lg-12 p-0 mx-auto">
            <div class="card card-body mb-32pt">
                <div class="row">
                    <div class="col-lg-4">
                        <h4 class="card-title">Listado</h4>
                        <p class="text-70">Cursos</p>
                        @can('academico_cursos_nuevo')
                        <a href="{{ route('academic_courses_create') }}" type="button" class="btn btn-primary">Nuevo</a>
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
                                        <th>{{ __('labels.Instructors') }}/{{ __('labels.Students') }}</th>
                                        <th>{{ __('labels.Name') }}</th>
                                        <th>{{ __('labels.Description') }}</th>
                                        <th>{{ __('labels.Status') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @foreach($courses as $key => $course)
                                    <tr>
                                        <td class="text-center align-middle">{{ $key + 1 }}</td>
                                        <td class="text-center align-middle">
                                            <div class="btn-group">
                                                @can('academico_cursos_editar')
                                                <a href="{{ route('academic_courses_editar',$course->id) }}" type="button" class="btn btn-info btn-sm" title="Editar"><i class="fa fa-pencil-alt"></i></a>
                                                @endcan
                                                @can('academico_secciones')
                                                <a href="{{ route('academic_sections',$course->id) }}" type="button" class="btn btn-success btn-sm" title="Secciones"><i class="fa fa-newspaper"></i></a>
                                                @endcan
                                                @can('academico_cursos_eliminar')
                                                <button onclick="deletes({{ $course->id }})" type="button" class="btn btn-danger btn-sm" title="Eliminar"><i class="fa fa-trash-alt"></i></button>
                                                @endcan
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">

                                        @can('academico_instructores_asignar')
                                        <a href="{{ route('academic_instructor_assign',$course->id) }}" type="button" class="btn btn-success btn-sm" title="Asignar/Ver {{ __('labels.Instructors') }}"><i class="fa fa-user-plus" aria-hidden="true"></i></a>
                                        @endcan

                                        @can('academico_estudiantes_asignar')
                                        <a href="{{ route('academic_student_assign',$course->id) }}" type="button" class="btn btn-success btn-sm" title="Asignar/Ver {{ __('labels.Students') }}"><i class="fa fa-graduation-cap" aria-hidden="true"></i></a>
                                        @endcan

                                        </td>
                                        <td class="text-center align-middle">{{ $course->name }}</td>
                                        <td class="text-center align-middle">{{ $course->description }}</td>
                                        <td class="text-center align-middle">
                                            @if($course->status)
                                            <span class="badge badge-success">{{ __('labels.Active') }}</span>
                                            @else
                                            <span class="badge badge-danger">{{ __('labels.Inactive') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-end" colspan="3">
                                            <div class="d-flex flex-row-reverse">
                                                {{ $courses->links() }}
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
                title: "¿Desea eliminar este Curso?",
                message: "Advertencia:¡Esta acción no se puede deshacer! e incluye el rating y votos que obtuvo",
                confirmText: "Okay",
                cancelText: "Cancel"
            }).then((e)=>{
                if ( e == ("confirm")){
                    @this.destroy(id)
                }
            });
        }
        window.addEventListener('aca-course-delete', event => {
            cuteAlert({
                type: event.detail.res,
                title: event.detail.tit,
                message: event.detail.msg,
                buttonText: "Okay"
            });
        })
    </script>
</div>
