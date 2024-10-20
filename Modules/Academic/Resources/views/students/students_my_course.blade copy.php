<x-master>

    <x-slot name="jumbotron">
        <div class="mdk-box bg-dark mdk-box--bg-gradient-primary js-mdk-box mb-0" data-effects="blend-background">
            <div class="mdk-box__content">
                <div class="hero py-64pt text-center text-sm-left">
                    <div class="container">
                        <h1 class="text-white">{{ $course->name }}</h1>
                        <p class="lead text-white-50 measure-hero-lead mb-24pt">{{ $course->description }}</p>
                        <button type="button" class="btn btn-white" onclick="openModalWelcomeVideo()">

                            {{ __('labels.Welcome Video') }}

                        </button>

                    </div>
                </div>
                <div class="navbar navbar-expand-sm navbar-submenu navbar-light navbar-list p-0 m-0 align-items-center">
                    <div class="container page__container">
                        <ul class="nav navbar-nav flex align-items-sm-center">
                            <li class="nav-item navbar-list__item">
                                <div class="media align-items-center">

                                    @livewire('academic::instructors.instructors-drop-show',['course_id' => $course->id])
                                </div>
                            </li>
                            {{-- <li class="nav-item navbar-list__item">
                                <i class="material-icons text-muted icon--left">schedule</i>
                                2h 46m
                            </li>
                            <li class="nav-item navbar-list__item">
                                <i class="material-icons text-muted icon--left">assessment</i>
                                Beginner
                            </li> --}}
                            <li class="nav-item ml-sm-auto text-sm-center flex-column navbar-list__item">
                                @livewire('academic::courses.course-rating',['course_id' => $course->id])
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    @livewire('academic::students.students-course-section',['course_id' => $course->id])

    <x-slot name="navigation">
        <x-navigation></x-navigation>
    </x-slot>
    @section('modales')
    <div wire:ignore.self class="modal fade" id="WelcomeVideo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ $course->name }} - {{ __('labels.Welcome Video') }}</h5>
                    <button type="button" class="close" onclick="closeModalWelcomeVideo()" aria-label="Close">
                        <span aria-hidden="true close-btn">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="js-player embed-responsive embed-responsive-16by9 mb-32pt">
                        <div class="player embed-responsive-item">
                            <div class="player__content">
                                <div class="player__image" style="--player-image: url(assets/images/illustration/player.svg)">
                                </div>
                                <a href="" class="player__play">
                                    <span class="material-icons">play_arrow</span>
                                </a>
                            </div>
                            <div class="player__embed d-none">
                                <!-- Aqui abajo va el Video -->
                                {{-- @if ($course->video_type==0)
                                    <iframe id="frameWelcomeVideo" class="embed-responsive-item"
                                    src="https://player.vimeo.com/video/{{ $course->video_url }}?title=0&amp;byline=0&amp;portrait=0"
                                allowfullscreen=""></iframe>
                                @endif
                                @if ($course->video_type==1)
                                <iframe id="frameWelcomeVideo" class="embed-responsive-item" src="https://www.youtube.com/embed/{{ $course->video_url }}?title=0&amp;byline=0&amp;portrait=0" allowfullscreen=""></iframe>
                                @endif --}}
                                <iframe id="frameWelcomeVideo" class="embed-responsive-item" src="" allowfullscreen=""></iframe>
                                <!-- Aqui arriba va el Video -->
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-btn" onclick="closeModalWelcomeVideo()">{{ __('labels.Close') }}</button>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @section('script')
    <script>
        var urlVideo = "{{ $course->video_url }}";
        var typeVideo = "{{ $course->video_type }}";
        var srcVideo = "";

        function closeModalWelcomeVideo() {
            document.getElementById("frameWelcomeVideo").src = "";
            $('#WelcomeVideo').modal('hide');
        }

        function openModalWelcomeVideo() {
            if (typeVideo == '0') {
                srcVideo = "https://player.vimeo.com/video/" + urlVideo + "?title=0&amp;byline=0&amp;portrait=0";
                document.getElementById("frameWelcomeVideo").src = srcVideo;
            }
            if (typeVideo == '1') {
                srcVideo = "https://www.youtube.com/embed/" + urlVideo + "?title=0&amp;byline=0&amp;portrait=0";
                document.getElementById("frameWelcomeVideo").src = srcVideo;
            }
            $('#WelcomeVideo').modal('show');
        }
    </script>
    @endsection
</x-master>