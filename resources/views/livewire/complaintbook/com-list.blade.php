<div class="">
    <div class="container page__container">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">{{ env('APP_NAME', 'Laravel') }}</a>
            </li>
            <li class="breadcrumb-item active">Libro de reclamos</li>
        </ol>
    </div>
    <div class="container page__container">
        <div class="col-lg-12 p-0 mx-auto">
            <div class="card card-body mb-32pt">
                <div class="row">
                    <div class="col-lg-2">
                        <h4 class="card-title">Listado</h4>
                    </div>
                    <div class="col-lg-10 d-flex align-items-center">
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
                                        <th>{{ __('labels.Name') }}</th>
                                        <th>DNI</th>
                                        <th>Teléfono</th>
                                        <th>Email</th>
                                        <th>Documento</th>
                                        <th>Monto</th>
                                        <th>{{ __('labels.Status') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @foreach ($complaintbooks as $key => $complaintbook)
                                        <tr>
                                            <td class="text-center align-middle">{{ $key + 1 }}</td>
                                            <td class="text-center align-middle">
                                                <div class="btn-group">

                                                    <button
                                                        onclick="openModalDetailsBook({{ json_encode($complaintbook) }})"
                                                        type="button" class="btn btn-info btn-sm" title="VER DETALLES">
                                                        <i class="fa fa-question"></i>
                                                    </button>

                                                    <button wire:click="opemModalReplyMessaje({{ $complaintbook }})"
                                                        type="button" class="btn btn-success btn-sm" title="Responder">
                                                        <i class="fa fa-envelope"></i>
                                                    </button>

                                                </div>
                                            </td>
                                            <td class="text-center align-middle">
                                                {{ $complaintbook->full_name }}
                                            </td>
                                            <td class="align-middle">{{ $complaintbook->dni_number }}</td>
                                            <td class="align-middle">{{ $complaintbook->telephone }}</td>
                                            <td class="align-middle">{{ $complaintbook->email }}</td>
                                            <td class="align-middle">
                                                {{ $complaintbook->serie }} - {{ $complaintbook->number }}
                                            </td>
                                            <td class="text-center align-middle">{{ $complaintbook->amount }}</td>
                                            <td class="text-center align-middle">
                                                @if ($complaintbook->status == 1)
                                                    <span class="badge badge-danger">Pendiente</span>
                                                @elseif ($complaintbook->status == 2)
                                                    <span class="badge badge-info">Revisando</span>
                                                @else
                                                    <span class="badge badge-success">Cerrado</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-end" colspan="3">
                                            <div class="d-flex flex-row-reverse">
                                                {{ $complaintbooks->links() }}
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
        function updateRevisandoS(id) {
            cuteAlert({
                type: "question",
                title: "¿Desea cambiar estado s revisando?",
                message: "Advertencia:¡Esta acción no se puede deshacer!",
                confirmText: "Okay",
                cancelText: "Cancel"
            }).then((e) => {
                if (e == ("confirm")) {
                    @this.updateRevisando(id)
                }
            });
        }

        function updateTerminadoS(id) {
            cuteAlert({
                type: "question",
                title: "¿Desea cambiar estado a cerrado?",
                message: "Advertencia:¡Esta acción no se puede deshacer!",
                confirmText: "Okay",
                cancelText: "Cancel"
            }).then((e) => {
                if (e == ("confirm")) {
                    @this.updateTerminado(id)
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

        function openModalDetailsBook(data) {
            var htmlDetails = `<dl class="row">
                <dt class="col-sm-3">Descripcion contrato</dt>
                <dd class="col-sm-9">${data.description}</dd>
                <dt class="col-sm-3">Tipo</dt>
                <dd class="col-sm-9">${data.type}</dd>
                <dt class="col-sm-3">Detalle</dt>
                <dd class="col-sm-9">${data.details}</dd>
                <dt class="col-sm-3">Pedido</dt>
                <dd class="col-sm-9">${data.improvement}</dd>
            </dl>`;

            let divContent = document.getElementById(
                'modalDetallesLibroReclamosBody'); // Reemplaza 'tuDivID' con el ID de tu div

            // Inserta el contenido HTML en el div
            if (divContent) {
                divContent.innerHTML = htmlDetails;
            }

            $('#modalDetallesLibroReclamos').modal('show');
        }
    </script>
    <script>
        window.addEventListener('open-modal-reply-mensaje', event => {
            $('#replyEmail').val(event.detail.email);
            $('#replyEstado').val(3);
            $('#modalReplyEmail').modal('show');
        })

        function saveReplyMessage() {

            @this.replyAsunto = $('#replyAsunto').val();
            @this.replyEmail = $('#replyEmail').val();
            @this.replyEstado = $('#replyEstado').val();
            @this.replyMensaje = $('#replyMensaje').val();
            @this.saveReplyMessageStatus();
        }

        window.addEventListener('open-modal-reply-mensaje-hide', event => {
            cuteAlert({
                type: "success",
                title: event.detail.tit,
                message: event.detail.msg,
                buttonText: "Okay"
            });
            $('#modalReplyEmail').modal('hide');
        })
    </script>
</div>
