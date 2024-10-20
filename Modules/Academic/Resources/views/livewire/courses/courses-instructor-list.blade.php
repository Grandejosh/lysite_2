<div class="container page__container page-section">
    <div class="mb-heading d-flex align-items-center">
        <h4 class="flex m-0">Gestionar cursos</h4>
        <a href="{{ route('academic_courses_create') }}" class="btn btn-accent">{{ __('labels.Add Course') }}</a>
    </div>
    <div class="row">

        @if(count($courses) > 0)
            @php
                $course_id = '';
            @endphp
            @foreach($courses as $course)
                @if($course_id != $course->course_id)
                <div class="col-sm-6 col-md-4 col-xl-3">
                    <div class="card card--elevated card-course overlay js-overlay mdk-reveal js-mdk-reveal " data-partial-height="40" data-toggle="popover" data-trigger="click">
                        <a href="instructor-edit-course.html" class="js-image" data-position="">
                            <img src="{{ url($course->course_image) }}" alt="course" height="168px" width="430 px">
                            <span class="overlay__content">
                                <span class="overlay__action d-flex flex-column text-center">
                                    {{ __('academic::labels.edit_course') }}
                                </span>
                            </span>
                        </a>
                        <div class="mdk-reveal__content">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex">
                                        <a class="card-title mb-4pt" href="{{ route('academic_instructor_courses_Edit',$course->course_id) }}">{{ $course->course_name }}</a>
                                    </div>
                                    <a href="{{ route('academic_instructor_courses_Edit',$course->course_id) }}" class="ml-4pt material-icons text-black-20 card-course__icon-favorite">edit</a>
                                </div>
                                <div class="d-flex">
                                    <div class="rating flex">
                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                        <span class="rating__item"><span class="material-icons">star_border</span></span>
                                    </div>
                                    <small class="text-black-50">6 hours</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="popoverContainer d-none">
                        <div class="media">
                            <div class="media-left">
                                <img src="{{ url($course->course_image) }}" width="40" height="40" alt="Angular" class="rounded">
                            </div>
                            <div class="media-body">
                                <div class="card-title mb-0">{{ $course->course_name }}</div>
                                <p class="lh-1">
                                    <span class="text-black-50 small">with</span>
                                    <span class="text-black-50 small font-weight-bold">Elijah Murray</span>
                                </p>
                            </div>
                        </div>
                        <p class="my-16pt text-black-70">{{ $course->course_description }}</p>
                        <div class="mb-16pt">
                            @php
                                $content_quantity = 0;
                            @endphp
                            @foreach($courses as $seccion)
                                @if($course->course_id == $seccion->course_id)
                                    @php
                                        $content_quantity = $content_quantity + $course->content_quantity;
                                    @endphp
                                    <div class="d-flex align-items-center">
                                        <span class="material-icons icon-16pt text-black-50 mr-8pt">check</span>
                                        <p class="flex text-black-50 lh-1 mb-0"><small>{{ $seccion->section_title }}</small></p>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <div class="row align-items-center">

                            <div class="col-auto">

                                <div class="d-flex align-items-center mb-4pt">
                                    <span class="material-icons icon-16pt text-black-50 mr-4pt">play_circle_outline</span>
                                    <p class="flex text-black-50 lh-1 mb-0"><small>{{ $course->sections_quantity }} {{ __('academic::labels.lessons') }}</small></p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="fa fa-user-graduate text-black-50 mr-4pt"></span>
                                    <p class="flex text-black-50 lh-1 mb-0"><small>{{ $course->students_quantity }} {{ __('academic::labels.students') }}</small></p>
                                </div>
                            </div>
                            <div class="col text-right">

                                <a href="{{ route('academic_dash_instructor_courses_edit',$course->course_id) }}" class="btn btn-primary">{{ __('academic::labels.edit_course') }}</a>

                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @php
                    $course_id = $course->course_id;
                @endphp
            @endforeach
        @endif
    </div>
</div>
