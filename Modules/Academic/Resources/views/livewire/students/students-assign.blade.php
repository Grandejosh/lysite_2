<div class="">
    <div class="container page__container">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME', 'Laravel') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('academic_courses') }}">{{ __('academic::labels.courses') }}</a>
            </li>
            <li class="breadcrumb-item">{{ $course->name }}</li>

        </ol>
    </div>
    <div class="container page__container">
        <div class="col-lg-12 p-0 mx-auto">
            <div class="card card-body mb-32pt">
                <div class="row">
                    <div class="col-lg-4">
                        <h4 class="card-title">{{ __('labels.Assign Students') }}</h4>
                        <p class="text-70">{{ __('labels.Course') . ': ' . $course->name }}</p>

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
                                        <th>{{ __('labels.Register until') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @foreach ($students as $key => $student)
                                        <tr>
                                            <td class="text-center align-middle">{{ $key + 1 }}</td>
                                            <td class="text-center align-middle">

                                                <div class="btn-group">

                                                    @can('academico_estudiantes_asignar')
                                                        <div class="btn-group">
                                                            <button wire:click="assign({{ $student->person_id }})"
                                                                title="{{ __('labels.Assign') }}"
                                                                class="btn btn-info btn-sm">
                                                                <i class="fas fa-angle-up"></i></button>
                                                        </div>
                                                    @endcan
                                                </div>

                                            </td>



                                            <td class="name align-middle">{{ $student->full_name }}</td>

                                            <!-- STATUS -->


                                            <!-- Registered Until -->
                                            <td class="name align-middle">
                                                <input type="date" id="registered_until" name="registered_until"
                                                    value="{{ $hoy_add_185 }}" disabled>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-end" colspan="4">
                                            {{ $students->links() }}
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
        window.addEventListener('aca-assign-assign', event => {
            cuteAlert({
                type: event.detail.res,
                title: event.detail.tit,
                message: event.detail.msg,
                buttonText: "Okay"
            });
        })
    </script>
</div>
