<div>
    <script>
        function downloadFile(url) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', url, true);
            xhr.responseType = 'blob';

            xhr.onload = function(e) {
                if (this.status == 200) {
                    // La descarga ha finalizado con éxito
                    console.log('File downloaded successfully');
                    showViewer();                    
                }
            };

            xhr.send();
        }

                function showViewer() {
                    document.getElementById('loader').style.display = "none";
                    document.getElementById('viewer').style.display = "";
        }

        setTimeout(showViewer, 4200);
    </script>
    
    <div class="bg-orange pb-lg-64pt py-32pt">
        <div class="container">

            @if ($content->content_type_id == 1)

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
                            @if ($video == 0)
                                <iframe class="embed-responsive-item"
                                    src="https://player.vimeo.com/video/{{ $content->content_url }}?title=0&amp;byline=0&amp;portrait=0"
                                    allowfullscreen=""></iframe>
                            @endif
                            @if ($video == 1)
                                <iframe class="embed-responsive-item"
                                    src="https://www.youtube.com/embed/{{ $content->content_url }}?title=0&amp;byline=0&amp;portrait=0"
                                    allowfullscreen=""></iframe>
                            @endif
                            <!-- Aqui arriba va el Video -->
                        </div>
                    </div>
                </div>

            @endif


            @if ($content->content_type_id == 2)
                <div class="card">
                    <div class="card-body">
                        {!! html_entity_decode($content->content_url, ENT_QUOTES, 'UTF-8') !!}
                    </div>
                </div>
            @endif

            @if ($content->content_type_id == 3)
                <div class="card" id="loader">
                    <div class="card-body">
                        <p class="text-70 m-0">El archivo está cargando espera un momento...</p>
                    </div>
                    <div class="card-body p-24pt is-loading is-loading-lg">
                        Descargando datos del servidor
                    </div>
                </div>
                <div class="card" id="viewer" style="display:none">
                    <iframe src="/ViewerJS/#{{ route('download_file', [$content->id, $student]) }}"
                        onload="downloadFile('{{ route('download_file', [$content->id, $student]) }}')" width='auto'
                        height='850vh' allowfullscreen webkitallowfullscreen></iframe>
                </div>
            @endif

            @if ($content->content_type_id == 4)
                <div class="card">
                    <img class="img-fluid rounded float-right"
                        alt="{{ $content->original_name }}::{{ __('labels.Image not available') }}"
                        src="{{ env('APP_URL') }}/{{ $content->content_url }}">
                </div>
            @endif

            <div class="d-flex flex-wrap align-items-end mb-16pt">
                <h1 class="text-white flex m-0">{{ $content->name }}</h1>
            </div>
            <a href="{{ route('academic_students_my_course', $course_id) }}" class="btn btn-white">Volver al Curso</a>
        </div>
    </div>
    <div class="page-section bg-white">
        <div class="container page__container">

            <div class="d-flex align-items-center mb-heading">
                <h4 class="m-0" id="preguntas">Preguntas</h4>
                <a href="{{ route('academic_students_discussions_ask', [$course_id, $section_id, $content_id]) }}"
                    class="text-underline ml-auto">Hacer una pregunta</a>
            </div>

            <div class="border-top">

                <div class="list-group list-group-flush">
                    @foreach ($questions as $question)
                        <div class="list-group-item p-3">
                            <div class="row align-items-center">
                                <div class="col-md-3 mb-8pt mb-md-0">
                                    <div class="media">
                                        <div class="media-left mr-16pt">
                                            @if ($question->avatar)
                                                <a href="#"><img src="{{ url('storage/' . $question->avatar) }}"
                                                        width="40" alt="{{ $question->full_name }}"
                                                        class="rounded-circle"></a>
                                            @else
                                                <a href="#"><img
                                                        src="{{ ui_avatars_url($question->full_name, 40, 'none') }}"
                                                        width="40" alt="{{ $question->full_name }}"
                                                        class="rounded-circle"></a>
                                            @endif
                                        </div>
                                        <div class="media-body media-middle">
                                            <p class="text-muted m-0">
                                                {{ \Carbon\Carbon::parse($question->created_at)->diffForHumans() }}</p>
                                            <p class="m-0"><a href="#"
                                                    class="text-body">{{ $question->full_name }}</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col mb-8pt mb-md-0">
                                    <p class="mb-8pt"><a
                                            href="{{ route('academic_students_discussion', [$course_id, $section_id, $content_id, $question->id]) }}"
                                            class="text-body"><strong>{{ $question->question_title }}</strong></a></p>
                                </div>
                                <div class="col-auto d-flex flex-column align-items-center justify-content-center">
                                    <h5 class="m-0">{{ $question->answers }}</h5>
                                    <p class="lh-1 mb-0"><small class="text-70">Respuestas</small></p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>

            {{-- <a href="student-discussions.html" class="btn btn-outline-secondary">See all discussions for this
                lesson</a> --}}

        </div>
    </div>

<!-- Código que corre despues de descargar el archivo, no estoy seguro si lo hace por 2da vez -->
    
</div>
