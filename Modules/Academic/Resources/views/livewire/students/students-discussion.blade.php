<div>
    <style>
        [dir=ltr] .btn-orange {
        color: #fff;
        background-color: #ff9152;
        border-color: #ff9152;
        }

        [dir=ltr] .btn-orange:hover {
        color: #fff;
        background-color: #e36e2b;
        border-color: #e36e2b;
        }
    </style>
    <div class="container page__container">
        <div class="page-section">

            <div class="row">
                <div class="col-md-8"
                    <h1 class="h2 mb-2">{{ $question->question_title }}</h1>
                    <p class="text-muted d-flex align-items-center mb-32pt mb-lg-48pt">
                        <a href="{{ route('academic_students_take_lesson', [$this->course_id, $this->section_id, $this->content_id]) }}" class="mr-3">Volver</a>
                        {{-- <a href="#" class="mr-2 text-50">Mute</a>--}}
                        @if($question->user_id == auth()->user()->id)
                            <a wire:click="deleteQuestion({{ $question->id }})" href="javascript:void(0)" class="mr-2 text-50">Eliminar</a>
                            <a href="{{ route('academic_students_discussions_ask_edit',[$this->course_id, $this->section_id, $this->content_id, $question->id]) }}" class="text-50" style="text-decoration: underline;">Editar</a>
                        @endif
                    </p>

                    <div class="card card-body" wire:ignore>
                        <div class="d-flex">
                            <a href="" class="avatar {{ $question->is_online ? 'avatar-online' : '' }} mr-3">
                                @if($question->avatar)
                                    <img src="{{ url('storage/'.$question->avatar) }}" alt="{{ $question->full_name }}" class="avatar-img rounded-circle">
                                @else
                                    <img src="{{ ui_avatars_url($question->full_name, 48, 'none') }}" alt="{{ $question->full_name }}" class="avatar-img rounded-circle">
                                @endif
                            </a>
                            <div class="flex">
                                <p class="d-flex align-items-center mb-2">
                                    <a href="student-profile.html" class="text-body mr-2"><strong>{{ $question->full_name }}</strong></a>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($question->created_at)->diffForHumans() }}</small>
                                </p>
                                <p>{{ $question->question_text }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex mb-4">
                        <a href="student-profile.html" class="avatar mr-3">
                            @if(auth()->user()->avatar)
                                <img src="{{ url('storage/'.auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" class="avatar-img rounded-circle">
                            @else
                                <img src="{{ ui_avatars_url(auth()->user()->name, 48, 'none') }}" alt="{{ auth()->user()->name }}" class="avatar-img rounded-circle">
                            @endif
                        </a>
                        <div class="flex">
                            <div class="form-group">
                                <label for="comment" class="form-label">{{ __('labels.Your answer') }}</label>
                                <textarea wire:model.defer="answer_text" class="form-control" name="comment" id="comment" rows="3" placeholder="Escribe aquí para responder a {{ $question->full_name }}..."></textarea>
                            </div>
                            <button wire:click="postReply" class="btn btn-orange">Publicar comentario</button>
                        </div>
                    </div>
                    <div class="pt-3">
                        <h4>{{ count($answers) }} Respuesta{{ count($answers) > 1 ? 's' : '' }}</h4>

                        @foreach ($answers as $answer)
                            <div class="d-flex mb-3">
                                <a href="javascript:void(0)" class="avatar avatar-xs mr-3">
                                    @if($answer->avatar)
                                        <img src="{{ url('storage/'.$answer->avatar) }}" alt="{{ $question->full_name }}" class="avatar-img rounded-circle">
                                    @else
                                        <img src="{{ ui_avatars_url($answer->full_name, 48, 'none') }}" alt="{{ $question->full_name }}" class="avatar-img rounded-circle">
                                    @endif
                                </a>
                                <div class="flex">
                                    <a href="profile.html" class="text-body"><strong>{{ $answer->full_name }}</strong></a>
                                    <span class="text-70">{{ $answer->answer_text }}</span><br>
                                    <div class="d-flex align-items-center">
                                        <small class="text-50 mr-2">{{ \Carbon\Carbon::parse($answer->created_at)->diffForHumans() }}</small>
                                        @if($answer->user_id == auth()->user()->id)
                                            <a wire:click="deleteAnswer({{ $answer->id }})" href="javascript:void(0)" class="text-50"><small>eliminar</small></a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        {{-- <div class="ml-sm-32pt mt-3 card p-3">
                            <div class="d-flex">
                                <a href="#" class="avatar avatar-xs mr-3">
                                    <img src="assets/images/people/110/guy-6.jpg" alt="Guy" class="avatar-img rounded-circle">
                                </a>
                                <div class="flex">
                                    <div class="d-flex align-items-center">
                                        <a href="profile.html" class="text-body"><strong>FrontendMatter</strong></a>
                                        <small class="ml-auto text-muted">just now</small>
                                    </div>
                                    <p class="mt-1 mb-0 text-70">Hi Joseph,<br> Thank you for purchasing our course! <br><br>Please have a look at the charts library documentation <a href="#">here</a> and follow the instructions.</p>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
                <div class="col-md-4">

                    {{-- <h4 class="card-title">Mayores contribuyentes</h4>
                    <p class="card-subtitle mb-24pt">People who started the most discussions on LearnPlus.</p>



                    <div class="mb-4">

                        <div class="d-flex align-items-center mb-2">
                            <a href="student-profile.html" class="avatar avatar-xs mr-3">
                                <img src="assets/images/people/50/guy-1.jpg" alt="course" class="avatar-img rounded-circle">
                            </a>
                            <a href="student-profile.html" class="flex mr-2 text-body"><strong>Luci Bryant</strong></a>
                            <span class="text-70 mr-2">105</span>
                            <i class="text-muted material-icons font-size-16pt">forum</i>
                        </div>

                    </div> --}}

                </div>
            </div>

        </div>
    </div>
    <script>
        window.addEventListener('aca-answer-not-delete', event => {
            cuteAlert({
                type: "error",
                title: event.detail.tit,
                message: event.detail.msg,
                buttonText: "Okay"
            });
        });
    </script>
</div>
