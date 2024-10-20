<x-master>

    <x-slot name="jumbotron">
        <div class="navbar navbar-list navbar-submenu navbar-light border-0 navbar-expand-sm"
            style="white-space: nowrap;">
    </x-slot>
    <div class="row">
        <div class="col-lg-12">
            <div class="card text-center">
                <div class="card-header">
                    <span class="fa fa-user-lock"></span>
                </div>
                <div class="card-body">
                    <h5 class="card-title">No tienes Acceso a este Curso</h5>
                    <p class="card-text">No Tienes una suscripción activa a este Curso o Tu Suscripción ha vencido,</p>
                    <a href="{{ env('APP_URL') }}" class="btn btn-primary">por favor comunicate con los
                        administradores o instructores para ampliarla</a>
                </div>
                <div class="card-footer">
                    {{ env('APP_NAME') }} - Comunicate al: {{ env('PHONE_CONTACT') }}
                </div>
            </div>
        </div>
    </div>

    <x-slot name="navigation">
        <x-navigation></x-navigation>
    </x-slot>
</x-master>
