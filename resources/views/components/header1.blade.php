<x-master>

    <x-slot name="jumbotron">

    </x-slot>


    <div class="container page__container">
        <div class="page-section">
            @yield('content')
        </div>
    </div>

    <x-slot name="navigation">
        <x-navigation></x-navigation>
    </x-slot>

</x-master>
