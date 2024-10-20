<x-master>
    @section('styles')
    <!-- Flatpickr -->
    <link type="text/css" href="{{ url('assets/css/flatpickr.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ url('assets/css/flatpickr.rtl.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ url('assets/css/flatpickr-airbnb.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ url('assets/css/flatpickr-airbnb.rtl.css') }}" rel="stylesheet">
    @endsection
    <x-slot name="jumbotron">
        <div class="bg-gradient-primary">
            <div class="py-32pt">
                <div class="container">
                    <h1 class="text-white mb-8pt">{{ __('academic::labels.students') }}</h1>
                    <span class="text-white">{{ __('academic::labels.edit') }}</span>
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
    @livewire('academic::students.students-edit',['student_id' => $id])
    <x-slot name="navigation">
        <x-navigation></x-navigation>
    </x-slot>
    @section('script')
    <!-- Flatpickr -->
    <script src="{{ url('assets/vendor/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ url('assets/js/flatpickr.js') }}"></script>
    @endsection
</x-master>