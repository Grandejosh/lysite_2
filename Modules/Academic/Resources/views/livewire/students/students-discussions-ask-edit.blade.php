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

    <div class="container page__container">

        <div class="row">
            <div class="col-lg-9">
                <div class="page-section">
                    <h4>Modificar pregunta</h4>

                    <div class="card--connect pb-32pt pb-lg-64pt">
                        <div class="card o-hidden mb-0">
                            <div class="card-body table--elevated">
                                <div class="form-group m-0" role="group" aria-labelledby="label-title">
                                    <div class="form-row align-items-center">
                                        <label id="label-title" for="title" class="col-md-3 col-form-label form-label">Título de la pregunta</label>
                                        <div class="col-md-9">
                                            <input wire:model.defer="question_title" id="title" type="text" placeholder="Tu pregunta .." class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                <input wire:model.defer="email" id="notify" type="checkbox" class="custom-control-input">
                                <label for="notify" class="custom-control-label">Notificarme por correo electrónico cuando alguien responda a mi pregunta</label>
                            </div>
                            <small id="description-notify" class="form-text text-muted">Si no está marcado, seguirá recibiendo notificaciones en nuestro sitio web.</small>
                        </div>
                        <div class="list-group-item">
                            <button wire:click="update" type="button" class="btn btn-accent">Publicar pregunta</button>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-lg-3 page-nav">

            </div>
        </div>

    </div>
    <script>
        window.addEventListener('aca-question-update', event => {
            cuteAlert({
                type: "success",
                title: event.detail.tit,
                message: event.detail.msg,
                buttonText: "Okay"
            });
        });
    </script>
</div>
