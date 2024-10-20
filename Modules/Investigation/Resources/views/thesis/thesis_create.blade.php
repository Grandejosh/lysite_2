@extends('layouts.tutorio')
@section('lycss')
    <!-- Theme Lyontech CSS -->
    <link href="{{ asset('x-editable/dist/bootstrap3-editable/css/bootstrap-editable.css') }}" rel="stylesheet" />
    <link type="text/css" href="{{ url('assets/css/flatpickr.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ url('assets/css/flatpickr.rtl.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ url('assets/css/flatpickr-airbnb.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ url('assets/css/flatpickr-airbnb.rtl.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ url('select2@4.1.0/select2.bundle.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/themeLyontech.css') }}">

@stop
@section('content')

    <body>
        <x-lyontech.header></x-lyontech.header>
        <x-lyontech.student-data></x-lyontech.student-data>

        <livewire:investigation::thesis.thesis-create />
    </body>
@stop
@section('modales')
    <livewire:investigation::thesis.thesis-help-create-titles />
    <livewire:investigation::thesis.thesis-format-modal />
    <livewire:investigation::thesis.thesis-format-modal-edit />
@endsection
@section('script')
    <script src="{{ asset('x-editable/dist/bootstrap3-editable/js/bootstrap-editable.js') }}"></script>
    <!-- Flatpickr -->
    <script src="{{ url('assets/vendor/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ url('assets/js/flatpickr.js') }}"></script>
    <script src="{{ url('select2@4.1.0/select2.js') }}"></script>

@stop
