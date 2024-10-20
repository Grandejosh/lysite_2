@extends('layouts.tutorio')
@section('lycss')
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <!--<link rel="stylesheet" href="{{ asset('theme-lyontech/css/7.css') }}">
    <link rel="stylesheet" href="{{ asset('theme-lyontech/css/8.css') }}">
    <link rel="stylesheet" href="{{ asset('theme-lyontech/css/n3.css') }}">-->
@stop
@section('content')

    <body>
        <x-lyontech.header></x-lyontech.header>
        <x-lyontech.student-data></x-lyontech.student-data>
        <livewire:help-gpt.ly-box-gpt />
    </body>
@stop
