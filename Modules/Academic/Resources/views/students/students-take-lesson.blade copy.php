<x-master>

    <x-slot name="jumbotron">
        <div class="navbar navbar-list navbar-submenu navbar-light border-0 navbar-expand-sm" style="white-space: nowrap;">
            <div class="container flex-column flex-sm-row">
                <nav class="nav navbar-nav navbar-list__item">
                    <div class="nav-item">
                        <div class="media flex-nowrap">
                            <div class="media-left mr-16pt">
                                <a href="{{ route('academic_students_my_course',$course_id) }}">

                                    <div class="avatar avatar-4by3">
                                        <img src="{{ asset($course->course_image) }}" alt="Avatar"
                                            class="avatar-img rounded">
                                    </div>


                                </a>
                            </div>
                            @if($instruct)
                            <div class="media-body">
                                <a href="{{ route('academic_students_my_course',$course_id) }}" class="card-title text-body mb-0">{{ $course->name }}</a>
                                <p class="lh-1 d-flex align-items-center mb-0">
                                    <span class="text-50 small font-weight-bold mr-8pt">{{ $instruct->names }}</span>
                                    <span class="text-50 small">{{ $instruct->email }}</span>
                                </p>
                            </div>
                            @endif
                        </div>
                        <ul>
                            <li class="nav-item ml-sm-auto text-sm-center flex-column navbar-list__item">
                                @livewire('academic::courses.course-rating',['course_id' => $course_id])
                            </li>
                        </ul>

                    </div>
                </nav>
                <ul class="navbar-list__item nav navbar-nav ml-sm-auto align-items-center align-items-sm-end">
                    <li class="nav-item active ml-sm-16pt">
                        <a href="" class="nav-link">Contenido</a>
                    </li>
                    <li class="nav-item">
                        <a href="#preguntas" class="nav-link">Preguntas</a>
                    </li>
                </ul>
            </div>
        </div>
    </x-slot>

    @livewire('academic::students.student-take-lesson',['course_id' => $course_id, 'section_id' => $section_id, 'content_id' => $content_id])

    <x-slot name="navigation">
        <x-navigation></x-navigation>
    </x-slot>
</x-master>
