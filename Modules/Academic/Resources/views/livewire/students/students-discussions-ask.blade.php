<div>
    <nav class="navbar navbar-expand-sm navbar-list navbar-submenu navbar-light py-sm-16pt">
        <div class="container">
            <ul class="nav navbar-nav w-100">
                <li class="nav-item navbar-list__item py-16pt py-sm-0">
                    <a href="{{ route('academic_students_take_lesson', [$course_id, $section_id, $content_id]) }}" class="nav-link"><i class="material-icons icon--left">keyboard_backspace</i> Volver a la lección</a>
                </li>
                <li class="nav-item navbar-list__item py-16pt py-sm-0">
                    <div class="media">
                        <div class="media-left mr-16pt">
                            <a href="{{ route('academic_students_take_lesson', [$course_id, $section_id, $content_id]) }}"><img src="{{ url($course->course_image) }}" width="40" alt="{{ $course->name }}" class="rounded"></a>
                        </div>
                        <div class="media-body">
                            <a href="{{ route('academic_students_take_lesson', [$course_id, $section_id, $content_id]) }}" class="card-title text-body mb-0">{{ $course->name }}</a>
                            <p class="lh-1 d-flex align-items-center mb-0">
                                <span class="text-50 small font-weight-bold mr-8pt">{{ $instruct->names }}</span>
                                <span class="text-50 small">{{ $instruct->email }}</span>
                            </p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    
    <div class="box-section">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <div class="page-section">
                        <h4>Hacer una pregunta</h4>
                        <div class="card--connect pb-32pt pb-lg-64pt">
                            <div class="card o-hidden mb-0">
                                <div class="card-body table--elevated">
                                    <div class="form-group m-0" role="group" aria-labelledby="label-title">
                                        <div class="form-row align-items-center">
                                            <label id="label-title" for="title" class="col-md-3 col-form-label form-label">Título de la pregunta</label>
                                            <div class="col-md-9">
                                                <input wire:keydown.enter="searchQuestion" wire:model.defer="question_title" id="title" type="text" placeholder="Tu pregunta .." class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
    
                                @if(count($questions) > 0)
                                    <div class="card-header bg-transparent">
                                        <h5 class="text-uppercase mb-0">Preguntas similares</h5>
                                    </div>
    
                                    @foreach($questions as $question)
                                        
                                        <div class="list-group list-group-flush">
    
                                            <div class="list-group-item p-3">
                                                <div class="row align-items-center">
                                                    <div class="col-md-3 mb-8pt mb-md-0">
                                                        <div class="media">
                                                            <div class="media-left mr-16pt">
                                                                @if($question->avatar)
                                                                <a href="#"><img src="{{ url('storage/'.$question->avatar) }}" width="40" alt="{{ $question->full_name }}" class="rounded-circle"></a>
                                                                @else
                                                                <a href="#"><img src="{{ ui_avatars_url($question->full_name,40,'none') }}" width="40" alt="{{ $question->full_name }}" class="rounded-circle"></a>
                                                                @endif
                                                            </div>
                                                            <div class="media-body media-middle">
                                                                <p class="text-muted m-0">{{ \Carbon\Carbon::parse($question->created_at)->diffForHumans() }}</p>
                                                                <p class="m-0"><a href="#" class="text-body">{{ $question->full_name }}</a></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col mb-8pt mb-md-0">
                                                        <p class="mb-8pt"><a href="{{ route('academic_students_discussion',[$course_id, $section_id, $content_id,$question->id]) }}" class="text-body"><strong>{{ $question->question_title }}</strong></a></p>
                                                    </div>
                                                    <div class="col-auto d-flex flex-column align-items-center justify-content-center">
                                                        <h5 class="m-0">{{ $question->answers }}</h5>
                                                        <p class="lh-1 mb-0"><small class="text-70">Respuestas</small></p>
                                                    </div>
                                                </div>
                                            </div>
    
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
    
                        <div class="list-group">
                            <div class="list-group-item">
                                <div role="group" aria-labelledby="label-question" class="m-0 form-group">
                                    <div class="form-row">
                                        <label id="label-question" for="question" class="col-md-3 col-form-label form-label">Detalles de la pregunta</label>
                                        <div class="col-md-9">
                                            <textarea wire:model.defer="question_text" id="question" placeholder="Describe detalladamente tu pregunta..." rows="4" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input wire:model.defer="email" id="notify" type="checkbox" class="custom-control-input-orange">
                                    <label for="notify" class="custom-control-label">Notificarme por correo electrónico cuando alguien responda a mi pregunta</label>
                                </div>
                                <small id="description-notify" class="form-text text-muted">Si no está marcado, seguirá recibiendo notificaciones en nuestro sitio web.</small>
                            </div>
                            <div class="list-group-item">
                                <button wire:click="save" type="button" class="btn btn-orange" wire:loading.attr="disabled">Publicar pregunta</button>
                            </div>
                        </div>
    
                    </div>
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-3 page-nav" style="padding: 15px 0px 5px 10px;">
                    <div data-perfect-scrollbar data-perfect-scrollbar-wheel-propagation="true">
                        <div class="page-section pt-lg-112pt">
                            <div class="nav page-nav__menu mb-0">
                                <h6 style="margin-left: -5px;">
                                    <i class="fa fa-circle" style="color: #ff9152; border-color: #fff; font-size: 10px;"></i> 
                                    &nbsp;&nbsp;Antes de publicar
                                </h6>
                                <!--
                                <a href="javascript:void(0)" class="nav-link active" style="background: none;">Antes de publicar</a>
                                -->
                            </div>
                            <div class="page-nav__content">
                                <p class="text-70">Puede haber otros estudiantes que hayan hecho la misma pregunta antes.</p>
                                <p class="text-70">Primero debe hacer una búsqueda rápida para asegurarse de que su pregunta sea única.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('aca-question-publicate', event => {
            cuteAlert({
                type: "lyon",
                title: event.detail.tit,
                message: event.detail.msg,
                buttonText: "Okay"
            });
        });
    </script>
</div>
