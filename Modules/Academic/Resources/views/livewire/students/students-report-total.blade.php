<div class="">
    <div class="container page__container">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME','Laravel') }}</a></li>
            <li class="breadcrumb-item active">{{ __('academic::labels.students') }}</li>
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

                            <!-- Table -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Tipo documento</th>
                                        <th>Número</th>
                                        <th>Nombre Completo</th>
                                        <th>Teléfono</th>
                                        <th>Email</th>
                                        <th>Funciones</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @php
                                        $total = 0;
                                    @endphp
                                    @foreach($students as $key => $student)
                                        <tr>
                                            <td class="name align-middle">{{ $student->document_type_name }}</td>
                                            <td class="name align-middle">{{ $student->number }}</td>
                                            <td class="name align-middle">{{ $student->full_name }}</td>
                                            <td class="name align-middle">{{ $student->mobile_phone }}</td>
                                            <td class="name align-middle">{{ $student->email }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    @if($student->gpt > 0)
                                                    <i class="fa fa-robot mr-2"></i>
                                                    @endif
                                                    @if($student->cur > 0)
                                                    <i class="fa fa-book mr-2"></i>
                                                    @endif
                                                    @if($student->tes > 0)
                                                    <i class="fa fa-scroll"></i>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @php
                                            $total = $total + 1;
                                        @endphp
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-right align-middle">TOTAL</td>
                                        <td class="text-center align-middle">{{ $total }}</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<!-- Divide -->

        <div class="col-lg-12 p-0 mx-auto"><b>Usuarios no inscritos a ningún curso</b>
            <div class="card card-body mb-32pt">
                <div class="row">
                    <div class="col-lg-12 d-flex align-items-center">
                        <!-- Wrapper -->
                        <div class="table-responsive" data-toggle="lists" data-lists-values='["name"]'>
                            <!-- Search -->

                            <!-- Table -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tipo documento</th>
                                        <th>Número</th>
                                        <th>Nombre Completo</th>
                                        <th>Teléfono</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @php
                                        $total = 0;
                                    @endphp
                                    @foreach($not_students as $key => $student)
                                        <tr><td> @can('configuraciones_usuarios_eliminar')
                                            <button onclick="deletes({{ $student->id }})" type="button" class="btn btn-danger btn-sm" title="Eliminar"><i class="fa fa-trash-alt"></i></button>
                                            @endcan</td>
                                            <td class="name align-middle">{{ $student->document_type_name }}</td>
                                            <td class="name align-middle">{{ $student->number }}</td>
                                            <td class="name align-middle">{{ $student->full_name }}</td>
                                            <td class="name align-middle">{{ $student->mobile_phone }}</td>
                                            <td class="name align-middle">{{ $student->email }}</td>
                                        </tr>
                                        @php
                                            $total = $total + 1;
                                        @endphp
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-right align-middle">TOTAL</td>
                                        <td class="text-center align-middle">{{ $total }}</td>
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
                title: "¿Desea eliminar a este Usuario?",
                message: "Advertencia:¡Esta acción no se puede deshacer! y se perderían todos los datos de investigación de esta persona",
                confirmText: "Okay",
                cancelText: "Cancel"
            }).then((e)=>{
                if ( e == ("confirm")){
                    @this.destroy(id)
                }
            });
        }
        window.addEventListener('aca-person-delete', event => {
            cuteAlert({
                type: event.detail.res,
                title: event.detail.tit,
                message: event.detail.msg,
                buttonText: "Okay"
            });
        })
    </script>
</div>
