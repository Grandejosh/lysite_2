<x-master>
    @section('styles')
    <!-- Flatpickr -->
    <link type="text/css" href="{{ url('assets/css/flatpickr.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ url('assets/css/flatpickr.rtl.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ url('assets/css/flatpickr-airbnb.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ url('assets/css/flatpickr-airbnb.rtl.css') }}" rel="stylesheet">
    <!-- Theme Lyonteach CSS -->
    <link rel="stylesheet" href="{{ url('assets/css/themeLyonteach.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/themeLyonteach-responsive.css') }}">
    @endsection
    <x-slot name="jumbotron">
        <div class="bg-orange border-bottom-white py-32pt">
            <div class="container d-flex flex-column flex-md-row align-items-center text-center text-md-left">
                <img src="{{ url('assets/images/illustration/student/128/white.svg') }}" width="104" class="mr-md-32pt mb-32pt mb-md-0" alt="student">
                <div class="flex mb-32pt mb-md-0">
                    <h2 class="text-white mb-0">{{ Auth()->user()->name }}</h2>
                    <p class="lead text-white-50 d-flex align-items-center">{{ auth()->user()->email }}</p>
                </div>
            </div>
        </div>
    </x-slot>
    <div class="navbar navbar-expand-sm navbar-dark-white bg-orange p-sm-0 ">
        <div class="container page__container">
            <!-- Navbar toggler -->
            <button class="navbar-toggler ml-n16pt" type="button" data-toggle="collapse" data-target="#navbar-submenu2">
                <i class="fa fa-bars"></i>
            </button>
            @livewire('nav.nav-global')
        </div>
    </div>

    @livewire('user.edit-password')
    
    <x-slot name="navigation">
        <x-navigation></x-navigation>
    </x-slot> 
    @section('script')
    <!-- Flatpickr -->
    <script src="{{ url('assets/vendor/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ url('assets/js/flatpickr.js') }}"></script>
    @endsection
</x-master>