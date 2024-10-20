<div class="">
    <div class="container page__container">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME','Laravel') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('academic_courses') }}">{{ __('academic::labels.courses')
                    }}</a></li>
            <li class="breadcrumb-item">{{ $course->name }}</li>

        </ol>
    </div>
    <div class="container page__container">
        <div class="col-lg-12 p-0 mx-auto">
            <div class="card card-body mb-32pt">
                <div class="row">
                    <div class="col-lg-4">
                        <h4 class="card-title">{{ __('labels.Assigned Students') }}</h4>
                        <p class="text-70">{{ __('labels.Course').': '.$course->name }}</p>

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
                                        <th>{{ __('labels.Assigned Students') }}</th>
                                        <th>{{ __('labels.Status') }}</th>
                                        <th>{{ __('labels.Registered until') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @foreach($students as $key => $student)
                                    <tr>
                                        <td class="text-center align-middle">{{ $key + 1 }}</td>
                                        <td class="text-center align-middle">

                                            <div class="btn-group">

                                                @can('academico_estudiantes_asignar')

                                                <a href="{{ route('academic_student_assign_edit',[$course_id, $student->person_id]) }}"
                                                    type="button" class="btn btn-info btn-sm"><i
                                                        class="fa fa-pencil-alt" title="Ver/Editar Contenido"></i></a>

                                                <button onclick="deletes({{ $student->id }})" type="button"
                                                    class="btn btn-danger btn-sm"
                                                    title="{{ __('labels.Remove assignment') }}"><i
                                                        class="fa fa-trash-alt"></i></button>
                                                @endcan
                                            </div>

                                        </td>



                                        <td class="name align-middle">{{ $student->full_name }}</td>

                                        <!-- STATUS -->
                                        <td class="name align-middle">
                                            @if($student->status == 1)
                                            <span class="badge badge-success">{{ __('labels.Active') }}</span>
                                            @else
                                            <span class="badge badge-danger">{{ __('labels.Inactive') }}</span>
                                            @endif
                                        </td>

                                        <!-- Registered Until -->
                                        <td class="name align-middle">
                                            <input type="date" id="registered_until" name="registered_until"
                                                value="{{ $student->registered_until }}" disabled>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                    <tr>
                                        <td class="text-end" colspan="2">
                                            {{ $students->links() }}
                                        </td>
                                    </tr>
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
                title: "¿Desea quitar a este Estudiante del curso?",
                message: "¿está seguro?",
                confirmText: "Okay",
                cancelText: "Cancel"
            }).then((e)=>{
                if ( e == ("confirm")){
                   @this.destroy(id)
                }
            });
        }
        window.addEventListener('aca-assign-delete', event => {
            cuteAlert({
                type: event.detail.res,
                title: event.detail.tit,
                message: event.detail.msg,
                buttonText: "Okay"
            });
        })
    </script>
</div>
