<div class="">
    <div class="container page__container">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME', 'Laravel') }}</a></li>
            <li class="breadcrumb-item active">Suscripciones En Línea</li>
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
                                    class="form-control search" placeholder="Search">
                                <button class="btn" type="button" role="button"><i
                                        class="material-icons">search</i></button>
                            </div>
                            <!-- Table -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">Detalle</th>
                                        <th class="text-center">DNI</th>
                                        <th>Nombre Completo</th>
                                        <th>Teléfono</th>
                                        <th>Email</th>
                                        <th>Suscrito desde</th>
                                        <th>Suscrito hasta</th>
                                        <th>Modo suscripción</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @foreach ($subscriptions as $key => $subscription)
                                        <tr>
                                            <td class="text-center align-middle">
                                                <button
                                                    onclick="openModalDetailsPayments({{ json_encode($subscription->payment_response) }},'{{ $subscription->payment_server }}')"
                                                    type="button" class="btn btn-info btn-sm">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </td>
                                            <td class="align-middle">
                                                {{ $subscription->number }}
                                            </td>
                                            <td class="align-middle">{{ $subscription->full_name }}</td>
                                            <td class="align-middle">{{ $subscription->mobile_phone }}</td>
                                            <td class="align-middle">{{ $subscription->email }}</td>
                                            <td class="align-middle">{{ $subscription->date_start }}</td>
                                            <td class="align-middle">{{ $subscription->date_end }}</td>
                                            <td class="align-middle">{{ $subscription->type_subscription_name }}</td>
                                            <td class="align-middle">
                                                @if ($subscription->status_response == 'approved')
                                                    <span class="badge badge-success">
                                                        {{ $subscription->status_response }}
                                                    </span>
                                                @else
                                                    <span class="badge badge-danger">
                                                        {{ $subscription->status_response }}
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-end" colspan="3">
                                            <div class="d-flex flex-row-reverse">
                                                {{ $subscriptions->links() }}
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
        function openModalDetailsPayments(data, medio) {
            let pay = JSON.parse(data);
            let div = document.getElementById('modalDetailsPaymentsBody');
            document.getElementById('modalDetailsPaymentsLabel').innerHTML = 'MERCADOPAGO ID: ' + pay.id;

            let content_pay = ``;
            if (medio == 'mercadopago') {
                content_pay += `<dl class="row">
                    <dt class="col-sm-4">FECHA DE PAGO</dt>
                    <dd class="col-sm-8">${formatDate(pay.card.date_created)}</dd>
                    <dt class="col-sm-4">METODO</dt>
                    <dd class="col-sm-8">${pay.payment_method_id}</dd>
                    <dt class="col-sm-4">COMISION</dt>
                    <dd class="col-sm-8">${pay.fee_details[0].amount}</dd>
                    <dt class="col-sm-4">MONTO</dt>
                    <dd class="col-sm-8">${pay.transaction_details.net_received_amount}</dd>
                    <dt class="col-sm-4">TOTAL PAGADO</dt>
                    <dd class="col-sm-8">${pay.transaction_details.total_paid_amount}</dd>
                </dl>`
            }

            div.innerHTML = content_pay;

            $('#modalDetailsPayments').modal('show');
        }

        function formatDate(dateString) {
            // Crear un objeto Date a partir de la cadena de fecha
            const date = new Date(dateString);

            // Obtener los componentes de la fecha
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0'); // Los meses son 0-indexados, así que se suma 1
            const day = String(date.getDate()).padStart(2, '0');
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');
            const seconds = String(date.getSeconds()).padStart(2, '0');

            // Formatear la fecha al formato Y-m-d H:i:s
            return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
        }
    </script>
</div>
