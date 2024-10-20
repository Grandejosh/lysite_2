@extends('layouts.tutorio')
@section('content')

    <body>
        <x-lyontech.header></x-lyontech.header>
        <x-lyontech.student-data></x-lyontech.student-data>
        <livewire:investigation::thesis.thesis-edit :thesis_id="$id" />
    </body>
@stop
