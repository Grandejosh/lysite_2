@extends('layouts.tutorio')
@section('content')

    <body>
        <x-lyontech.header></x-lyontech.header>
        <x-lyontech.student-data></x-lyontech.student-data>

        @livewire('academic::students.students-discussions-ask', [$course_id, $section_id, $content_id])
    </body>
@stop
