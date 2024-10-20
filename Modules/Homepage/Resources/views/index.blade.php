<x-master>
    <x-slot name="jumbotron">
        <div class="bg-gradient-primary">
            <div class="py-32pt">
                <div class="container">
                    <h1 class="text-white mb-8pt">{{ __('labels.Homepage') }}</h1>
                    <span class="text-white">{{ __('labels.Settings') }}</span>
                </div>
            </div>
        </div>
    </x-slot>
    <div class="navbar navbar-expand-sm navbar-dark-white bg-gradient-primary p-sm-0 ">
        <div class="container page__container">
            <!-- Navbar toggler -->
            <button class="navbar-toggler ml-n16pt" type="button" data-toggle="collapse" data-target="#navbar-submenu2">
                <i class="fa fa-bars"></i>
            </button>
            @livewire('nav.nav-global')
        </div>
    </div>

    <div class="container page__container">
        <div class="card">
            <h5 class="card-header">Historias de Éxito</h5>
            <div class="card-body">
              <h5 class="card-title"></h5>
              <p class="card-text">Agregar, editar o eliminar Historias de Éxito que se ven en la página de Inicio.</p>
              <a href="{{ route('homepage_histories') }}" class="btn btn-primary">Configurar</a>
            </div>
          </div>

          <div class="card">
            <h5 class="card-header">Instructores</h5>
            <div class="card-body">
              <h5 class="card-title"></h5>
              <p class="card-text">Aquí se agrega, edita o elimina los instructores que se ven en la página de inicio.</p>
              <a href="{{ route('homepage_instructors') }}" class="btn btn-primary">Configurar</a>
            </div>
          </div>
    </div>

    <x-slot name="navigation">
        <x-navigation></x-navigation>
    </x-slot>
</x-master>
