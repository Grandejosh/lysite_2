@extends('layouts.tutorio')
@section('content')

        <x-lyontech.header></x-lyontech.header>
        <x-lyontech.student-data></x-lyontech.student-data>

        <div class="navbar navbar-expand-sm navbar-submenu navbar-light navbar-list p-0 m-0 align-items-center"> 
            <div class="container page__container">
                <ul class="nav navbar-nav flex align-items-sm-center">
                    @if ($instruct)
                        <li class="nav-item navbar-list__item">
                            <div class="media align-items-center">
                                <span class="media-left mr-16pt">
                                    <img src="{{ asset($course->course_image) }}" width="40" alt="avatar"
                                        class="rounded-circle">
                                </span>
                                <div class="media-body">
                                    <a class="card-title m-0"
                                        href="{{ route('academic_students_my_course', $course_id) }}">{{ $instruct->names }}</a>
                                    <p class="text-50 lh-1 mb-0">{{ $instruct->email }}</p>
                                </div>
                            </div>
                        </li>
                    @endif
                    {{-- <li class="nav-item navbar-list__item">
                        <i class="material-icons text-muted icon--left">schedule</i>
                        2h 46m
                    </li>
                    <li class="nav-item navbar-list__item">
                        <i class="material-icons text-muted icon--left">assessment</i>
                        Beginner
                    </li> --}}
                    <li class="nav-item ml-sm-auto text-sm-center flex-column navbar-list__item">
                        @livewire('academic::courses.course-rating', ['course_id' => $course_id])
                    </li>
                </ul>
            </div>
        </div>

        @livewire('academic::students.student-take-lesson', ['course_id' => $course_id, 'section_id' => $section_id, 'content_id' => $content_id])
    
@stop
