
<div class="container-section-1360p page__container pc-screen">
    <div class="row">
        <div class="col-md-12 d-flex justify-content-center align-items-center" style="padding: 40px 0px;">
            <div class="image-der mr-3">
                <img src="{{ asset('theme-lyontech/images/libro-m.png') }}" alt="Card image cap" style="width: 100px; margin: auto;">
            </div>
            <div class="texto">
                <h5 class="mb-0" style="margin-left: -10px;">
                  <strong style="font-size: 1.8rem;letter-spacing: 0.0em;">CURSOS</strong>
                </h5>
            </div>
        </div>
    </div>
    @if (count($courses) > 0)
    <div class="row">
        @foreach ($courses as $course)
        <div class="col-md-6" style="padding: 15px;">
            <div class="box-course-list">
                <a href="{{ route('academic_students_my_course', $course->id) }}">
                    <div class="row">
                        <div class="col-md-2" style="padding: 20px; margin-left: 10px;">
                            <img class="img-courses" src="{{ asset('theme-lyontech/images/leon.png') }}">
                        </div>
                        <div class="col-md-10" style="padding: 0px; margin-left: -10px;">
                            <p class="p-large mt-2">{{ $course->name }}</p>
                            <div class="row">
                                <div class="col-md-4">
                                    <h5 class="mb-0">Videos: 5</h5>
                                    <h5 class="mt-0">Guías:&nbsp;&nbsp;&nbsp;13</h5>
                                </div>
                                <div class="col-md-4">
                                    <div wire:ignore.self>
                                        <div  style="cursor: pointer" class="rating rating-24">
        
                                            @for ($i=0; $i < $course->rating; $i++)
                                            <div class="rating__item"><i class="material-icons"  value="{{ $i+1 }}">star</i></div>
                                            @endfor
        
                                            @if ($course->half)
                                            <div class="rating__item"><i class="material-icons" value="{{ $i }}">star_half</i></div>
                                            @endif
        
                                            @for ($x = 0; $x < $course->empty; $x++)
                                            <div class="rating__item" value="{{ $i }}"><i class="material-icons">star_border</i></div>
                                            @endfor
        
                                        </div>
                                    </div>
        
                                    <div style="margin-top: 4px;">
                                        @if ($course->voters == 1)
                                            <small class="mt-0">{{ $course->voters }} calificación</small>
                                        @else
                                            <small class="mt-0">{{ $course->voters }} calificaciones</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        @endforeach
    </div>
    @endif
    <br>
</div>

<div class="container page__container movil-screen">
    <br>
    <div class="row">
        <div class="col-md-12">
            <h5 style="text-align:center;">
                <img style="width: 100px;" src={{ asset('theme-lyontech/images/libro-m.png') }}>
                <strong style="font-size: 1.8rem;letter-spacing: 0.0em;">CURSOS</strong>
            </h5>
        </div>
    </div>
    @if (count($courses) > 0)
    <div class="row">
        @foreach ($courses as $course)
        <div class="col-md-6" style="padding: 15px;">
            <div class="box-course-list">
                <a href="{{ route('academic_students_my_course', $course->id) }}">
                    <div class="row">
                        <div class="col-md-2" style="padding: 0px;">
                            <!--<img style="width: 100%;" src="{{ url($course->course_image) }}" class="card-img">-->
                            <img class="img-courses" src="{{ asset('theme-lyontech/images/leon.png') }}">
                        </div>
                        <div class="col-md-10">
                            <p class="p-large">{{ $course->name }}</p>
                            <div class="row">
                                <div class="col-md-4">
                                    <h5 class="mb-0">Videos: 5 &nbsp;&nbsp;&nbsp;| &nbsp;&nbsp;&nbsp;Guías: 13</h5>
                                </div>
                                <div class="col-md-4">
                                    <div wire:ignore.self>
                                        <div  style="cursor: pointer" class="rating rating-24">
        
                                            @for ($i=0; $i < $course->rating; $i++)
                                            <div class="rating__item"><i class="material-icons"  value="{{ $i+1 }}">star</i></div>
                                            @endfor
        
                                            @if ($course->half)
                                            <div class="rating__item"><i class="material-icons" value="{{ $i }}">star_half</i></div>
                                            @endif
        
                                            @for ($x = 0; $x < $course->empty; $x++)
                                            <div class="rating__item" value="{{ $i }}"><i class="material-icons">star_border</i></div>
                                            @endfor
        
                                        </div>
                                    </div>
        
                                    <div style="margin-top: 4px;">
                                        @if ($course->voters == 1)
                                            <small class="mt-0">{{ $course->voters }} calificación</small>
                                        @else
                                            <small class="mt-0">{{ $course->voters }} calificaciones</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        @endforeach
    </div>
    @endif
    <br>
</div>



