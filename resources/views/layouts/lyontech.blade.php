<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Basic -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Site Metas -->
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />


    <title>{{ env('APP_NAME', 'Laravel') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- slider stylesheet -->
    <!-- slider stylesheet -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <!-- bootstrap 4.3 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- bootstrap core css -->
    @yield('bootstrap')

    <!-- fonts style -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="{{ asset('theme-lyontech/css/style.css') }}" rel="stylesheet" />
    <!-- responsive style -->
    <link href="{{ asset('theme-lyontech/css/responsive.css') }}" rel="stylesheet" />
    <link href="{{ asset('theme-lyontech/css/lyontech.css') }}" rel="stylesheet" />

    @yield('lycss')
</head>
@yield('content')

@livewireScripts
<script src="{{ url('assets/vendor/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ url('assets/vendor/popper.min.js') }}"></script>
<script src="{{ url('assets/vendor/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>


@yield('script')
@yield('modales')

</html>
