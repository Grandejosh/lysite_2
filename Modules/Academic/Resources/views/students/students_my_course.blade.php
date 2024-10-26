@extends('layouts.tutorio')

@section('lycss')

    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">

@stop
@section('content')

    <body>
        <x-lyontech.header></x-lyontech.header>
        <x-lyontech.student-data></x-lyontech.student-data>

        <div class="container mt-5">
            <h1>{{ $course->name }}</h1>
            <button id="openModalBtn" class="btn btn-primary">Ver Video</button>
        </div>


        <!-- Welcome Modal -->
        <style>
            /* Estilos para el borde del modal */
            #welcomeModal .modal-content {
                border: 5px solid #ff9152;
            }

            /* Estilos para la parte superior del modal (fondo rojo) */
            #welcomeModal .modal-body {
                background-color: #ff9152;
                /* Color de fondo rojo para la parte superior del modal */
                color: white;
                /* Color del texto en la parte superior del modal */
            }

            /* Estilos para el botón de cierre del modal */
            #welcomeModal .modal-header .close {
                color: #ff9152;
            }

            /* Estilos para la parte inferior del modal */
            #welcomeModal .modal-footer {
                background-color: #ffbc94;
                /* Color de fondo oscuro para la parte inferior del modal */
                color: white;
                /* Color del texto en la parte inferior del modal */
            }
        </style>
        @if (isset($course->video_url))
            <div class="modal fade" id="welcomeModal" tabindex="-1" role="dialog" aria-labelledby="welcomeModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="welcomeModalLabel">Welcome!</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="padding:61.88% 0 0 0;position:relative;"><iframe id="videoPlayer"
                                    src="https://player.vimeo.com/video/{{ $course->video_url }}?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479"
                                    frameborder="0" allow="autoplay; fullscreen; picture-in-picture; clipboard-write"
                                    style="position:absolute;top:0;left:0;width:100%;height:100%;"
                                    title="LYONTEACH VIDEO PRESENTACION FINAL"></iframe></div>
                            <script src="https://player.vimeo.com/api/player.js"></script>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">X</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @livewire('academic::students.students-course-section', ['course_id' => $course->id])
    </body>
@stop

@section('modales')
    <div wire:ignore.self class="modal fade" id="WelcomeVideo" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ $course->name }} -
                        {{ __('labels.Welcome Video') }}</h5>
                    <button type="button" class="close" onclick="closeModalWelcomeVideo()" aria-label="Close">
                        <span aria-hidden="true close-btn">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="js-player embed-responsive embed-responsive-16by9 mb-32pt">
                        <div class="player embed-responsive-item">
                            <div class="player__content">
                                <div class="player__image"
                                    style="--player-image: url(assets/images/illustration/player.svg)">
                                </div>
                                <a href="" class="player__play">
                                    <span class="material-icons">play_arrow</span>
                                </a>
                            </div>
                            <div class="player__embed d-none">
                                <!-- Aqui abajo va el Video -->
                                {{-- @if ($course->video_type == 0)
                                    <iframe id="frameWelcomeVideo" class="embed-responsive-item"
                                    src="https://player.vimeo.com/video/{{ $course->video_url }}?title=0&amp;byline=0&amp;portrait=0"
                                    allowfullscreen=""></iframe>
                                @endif
                                @if ($course->video_type == 1)
                                    <iframe id="frameWelcomeVideo" class="embed-responsive-item"
                                    src="https://www.youtube.com/embed/{{ $course->video_url }}?title=0&amp;byline=0&amp;portrait=0"
                                    allowfullscreen=""></iframe>
                                @endif --}}
                                <iframe id="frameWelcomeVideo" class="embed-responsive-item" src=""
                                    allowfullscreen=""></iframe>
                                <!-- Aqui arriba va el Video -->
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-btn"
                        onclick="closeModalWelcomeVideo()">{{ __('labels.Close') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var welcomeModal = document.getElementById('welcomeModal');
            var openModalBtn = document.getElementById('openModalBtn');
            var video = document.getElementById('videoPlayer');

            function showModal() {
                $('#welcomeModal').modal('show');
            }

            function hideModal() {
                var src = video.src;
                video.src = '';
                video.src = src;
                $('#welcomeModal').modal('hide');

            }

            function setModalShown() {
                localStorage.setItem('modalShown' + {{ $course->id }}, 'true');
            }

            function hasModalBeenShown() {
                return localStorage.getItem('modalShown' + {{ $course->id }}) === 'true';
            }

            if (!hasModalBeenShown()) {
                showModal();
            }

            $('#welcomeModal').on('hidden.bs.modal', function() {
                setModalShown();
                var src = video.src;
                video.src = '';
                video.src = src;
            });

            openModalBtn.addEventListener('click', function() {
                showModal();
            });
        });
    </script>
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
