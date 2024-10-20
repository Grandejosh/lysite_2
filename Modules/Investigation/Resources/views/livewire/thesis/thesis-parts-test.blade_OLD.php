<div>
    <style>
        #container {
            width: 1000px;
            margin: 20px auto;
        }
        .ck-editor__editable[role="textbox"] {
            /* editing area */
            min-height: 200px;
        }
        .ck-content .image {
            /* block images */
            max-width: 80%;
            margin: 20px auto;
        }
    </style>

    <div class="container page__container">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME', 'Laravel') }}</a></li>
            <li class="breadcrumb-item active">{{ __('investigation::labels.thesis_parts') }}</li>
        </ol>
    </div>
    <div class="container page__container">
        <div class="d-flex flex-wrap align-items-start mb-3">
            <div class="d-flex mr-24pt">
                <div class="flex">
                    <a class="text-body"
                        href="{{ route('investigation_thesis_parts', $thesis_student->id) }}"><strong>{{ $thesis_student->title }}</strong></a><br>
                </div>
            </div>
            <div class="d-flex align-items-center py-4pt" style="white-space: nowrap;">
                <div class="btn-group" role="group">
                    <button wire:click="goEdit({{ $thesis_student->id }})" type="button" class="btn btn-primary">
                        <i class="fa fa-pencil-alt mr-1"></i>
                    </button>
                    <button onclick="deleteThesisStudent({{ $thesis_student->id }})" type="button"
                        class="btn btn-primary"><i class="fa fa-trash-alt mr-1"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- Notas de instructor --}}

        @if ($commentary)
            <div class="card card-body mb-3" style="background-color: rgb(181, 168, 255)">

                <div class="row">
                    <div class="col-3 mb-2">
                        <button title="borra la nota o comentario cuando quieras." class="btn-warning btn"
                            onclick="deleteCommentary()">
                            Eliminar nota ->
                        </button>
                    </div>
                    <div class="col-9 mb-3">
                        <label>Nota:</label>
                        <div>{{ $commentary }}</div>
                    </div>

                </div>

            </div>
        @endif

        {{-- Contenido --}}
        <div class="card card-body mb-3">
            <div class="row">
                <div class="col-3">
                    <div class="custom-control custom-checkbox">
                        <input wire:model="auto_save" class="custom-control-input" type="checkbox" value=""
                            id="auto-saveCheck">
                        <label class="custom-control-label" for="auto-saveCheck" onclick="toggleSaving()">
                            {{ __('labels.Automatic save') }}
                        </label>
                    </div>
                </div>
                <div class="col">

                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal"
                        data-target="#exampleModalScrollable">
                        Indice de Contenidos
                    </button>
                    {{-- Begin Modal Indice de Contenido --}}
                    @section('modales')
                        <div>
                            <!-- Modal -->
                            <style>
                                .modal.modal-left .modal-dialog {
                                    max-width: 380px;
                                    min-height: calc(100vh - 0)
                                }

                                .modal.modal-left.show .modal-dialog {
                                    transform: translate(0, 0)
                                }

                                .modal.modal-left .modal-content {
                                    height: calc(100vh - 0);
                                    overflow-y: auto
                                }

                                .modal.modal-left .modal-dialog {
                                    transform: translate(-100%, 0);
                                    margin: 0 auto 0 0
                                }
                            </style>
                            <div class="modal fade modal-left" id="exampleModalScrollable" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalScrollableTitle">Indice de Contenidos
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <ul class="list-point-none">
                                                @if (count($parts) > 0)
                                                    @foreach ($parts as $part)
                                                        @if ($part['id'] == $focus_id)
                                                            <li class="alert alert-primary">
                                                                <a class="alert-link"
                                                                    href="javascript:changeFocus({{ $thesis_id . ', ' . $part['id'] }})">
                                                                    {{ $part['number_order'] . ' ' . $part['description'] }}</a>
                                                                {!! $part['items'] !!}
                                                            </li>
                                                        @else
                                                            <li>
                                                                <a
                                                                    href="javascript:changeFocus({{ $thesis_id . ', ' . $part['id'] }})">
                                                                    {{ $part['number_order'] . ' ' . $part['description'] }}</a>
                                                                {!! $part['items'] !!}
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">{{ __('labels.Close') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endsection
                    {{-- End Modal Indice de Contenido --}}

                </div>
                @if($focused_part)
                <div class="col">
                    <div class="btn-group mr-2">
                        <button type="button" class="btn btn-secondary" wire:click="showVideo"
                            title="{{ __('labels.Watch a Video about') . ': ' . $focused_part->description }}">
                            <i class="fa fa-video"></i>
                        </button>
                        <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="top"
                            title="{{ $focused_part->information }}">
                            <i class="fa fa-info-circle"></i>
                        </button>
                        @if ($focused_part->content_id != null)
                            <button type="button" class="btn btn-secondary" onclick="watchSection()"
                                title="{{ __('labels.Click here if you want to see this topic in the course') }}">
                                <i class="fa fa-book"></i>
                            </button>
                        @else
                            <button type="button" class="btn btn-secondary" disabled onclick="watchSection()"
                                title="{{ __('labels.Click here if you want to see this topic in the course') }}">
                                <i class="fa fa-book"></i>
                            </button>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
        @if($focused_part)
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">{{ $focused_part->description }}</h5>
            </div>
        </div>
        @endif
    </div>
    @if($focused_part)
    @if ($focused_part->body == true)
        {{-- <div class="div-body" data-editor="DecoupledDocumentEditor" data-collaboration="false"
            data-revision-history="false">
            <div class="div-main">
                <div class="centered" wire:ignore>
                    <div class="row">
                        <div class="document-editor__toolbar"></div>
                    </div>
                    <div class="row row-editor">
                        <div class="editor-container">
                            <div class="editor" id="editor">{!! $content_old !!}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="container page__container">
            <div wire:ignore class="editor-container">
                <div class="editor" id="editor">{!! $content_old !!}</div>
            </div>
            @error('content')
                <span class="invalid-feedback-2">{{ $message }}</span>
            @enderror
        </div>
        <div class="container page__container">
            @if ($commentary)
                <div class="row">
                    <div class="col-12 mb-3">
                        <label>Nota:</label>
                        <div>{{ $commentary }}</div>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col mb-2">
                    <a href="{{ route('investigation_thesis_export_pdf', $thesis_id) }}" class="btn btn-warning mt-3"
                        target="_blank">
                        Exportar PDF
                    </a>
                    {{-- <a href="{{ route('investigation_thesis_export_word', $thesis_id) }}" class="btn btn-info mt-3"
                        target="_blank">
                        Exportar WORD
                    </a> --}}
                    <button type="button" class="btn-primary btn  mt-3" wire:loading.attr="disabled"
                        onclick="saveThesisPartStudent()">{{ __('labels.Save') }}
                    </button>
                </div>
            </div>
        </div>
    @else
        <div>
            <h5>Esta Sección solo es un título o subtitulo sin contenido.</h5>
            <input type="hidden" name="" id="editor">

        </div>
    @endif
    @endif
    <div>
        {{-- modal video --}}
        <div wire:ignore class="ventana_flotante" style="display: none" id="video-flotante">

            <div class="content">

                <div class="header">



                    <button type="button" class="close" onclick="closeVideo()" aria-label="Close">

                        <span aria-hidden="true close-btn">×</span>

                    </button>

                </div>

                <div class="body">

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
                                <iframe class="embed-responsive-item" id="iframeVideoPart"
                                    allowfullscreen=""></iframe>
                            </div>

                        </div>
                    </div>

                </div>

                <!-- Footer desde aqui -->

            </div>

        </div>
    </div>
    <script>
        var data = "";

        function deletes(id) {
            cuteAlert({
                type: "question",
                title: "¿Desea eliminar estos datos?",
                message: "Advertencia:¡Esta acción no se puede deshacer!",
                confirmText: "Okay",
                cancelText: "Cancel"
            }).then((e) => {
                if (e == ("confirm")) {
                    @this.destroy(id)
                }
            });
        }

        function deleteCommentary() {
            cuteAlert({
                type: "question",
                title: "¿Desea eliminar esta Nota o Comentario?",
                message: "Advertencia:¡Cerciorate de seguir todas las indicaciones de tu instructor antes de borrar las notas!",
                confirmText: "Si, Borrar nota",
                cancelText: "Cancelar"
            }).then((e) => {
                if (e == ("confirm")) {
                    @this.deleteCommentary()
                }
            });
        }
        window.addEventListener('inve-student-part-create', event => {
            cuteAlert({
                type: event.detail.res,
                title: event.detail.tit,
                message: event.detail.msg,
                buttonText: "Okay"
            });
        });
        window.addEventListener('inve-open-modal-video', event => {
            if (event.detail.success) {
                let url = "https://player.vimeo.com/video/" + event.detail.video +
                    "?title=0&amp;byline=0&amp;portrait=0"
                document.getElementById("iframeVideoPart").src = url;
                document.getElementById('video-flotante').style.display = 'block';
            } else {
                cuteAlert({
                    type: 'error',
                    title: 'Sin Video',
                    message: 'No tiene videos vinculados',
                    buttonText: "Okay"
                });
            }
        });

        function closeVideo() {
            document.getElementById('video-flotante').style.display = 'none';
            document.getElementById("iframeVideoPart").src = null;
        }

        function deleteThesisStudent(id) {
            cuteAlert({
                type: "question",
                title: "¿Desea eliminar estos datos?",
                message: "Advertencia:¡Esta acción no se puede deshacer!",
                confirmText: "Okay",
                cancelText: "Cancel"
            }).then((e) => {
                if (e == ("confirm")) {
                    @this.deleteThesis(id)
                }
            });
        }

        function changeFocus(thesis_id, part_id) { //funcion para cambiar de sección y revisar cambios
            let as = document.getElementById("auto-saveCheck").checked;
            var editor_textarea;
            if (document.getElementById("editor").tagName == "TEXTAREA") {
                editor_textarea = true;
            }
            if (!as) { //autosave desactivado
                updateContent();
                let old = document.getElementById("content_old").value;
                let actual = data; //ahora el actual esta en data
                if (old != actual) {
                    cuteAlert({
                        type: "question",
                        title: "¿Vas a cambiar de Sección y no has guardado tu contenido, deseas Guardarlo ahora?",
                        message: "Advertencia:¡Esta acción no se puede deshacer!",
                        confirmText: "Guardar",
                        cancelText: "No Guardar"
                    }).then((e) => {
                        if (e == ("confirm")) {
                            @this.savingThesisPartStudentBeforeChange(thesis_id, part_id);
                        } else {
                            @this.withoutSavingThesisPartStudentBeforeChange(thesis_id, part_id);
                        }
                    });
                } else {
                    @this.withoutSavingThesisPartStudentBeforeChange(thesis_id, part_id);
                }
            } else { //autosave activado

                updateContent();
                let old = document.getElementById("content_old").value;
                let actual = data; //ahora el actual esta en data
                if (old != actual) {
                    @this.savingThesisPartStudentBeforeChange(thesis_id, part_id);
                } else {
                    @this.withoutSavingThesisPartStudentBeforeChange(thesis_id, part_id);
                }
            }

        }

        window.addEventListener('inve-thesis-delete', event => {
            cuteAlert({
                type: event.detail.res,
                title: event.detail.tit,
                message: event.detail.msg,
                buttonText: "Okay"
            }).then(() => {
                @this.dashboard_next();
            });
        });

        document.addEventListener('livewire:load', function() {

            if (document.getElementById("editor").tagName == "DIV") {
                //CKEDITOR.replace('editor');
                activeCkeditor5();
            }
        })

        function saveThesisPartStudent() {
            updateContent();
            @this.saveThesisPartStudentN(true)
        }
    </script>
    <input type="hidden" id="content_old" wire:model='content_old'>
    <script>
        //Codigo para el Intervalo de AutoGrabado
        var TimeSave;
        var time = 30; //se configura el tiempo en segundos.
        time = time * 1000; //se pasa a milisegundos
        var data;


        function activarAutoGuardado() {
            TimeSave = setInterval(saving, time);
        }

        function stopSaving() {
            clearInterval(TimeSave);
        }

        function saving() {
            updateContent();
            let old = document.getElementById("content_old").value;
            let actual = data; //ahora el actual esta en data
            let as = document.getElementById('auto-saveCheck');
            // revisa que autoguardado esté activado y que haya habido cambio en el contenido
            if (as.checked && old != actual) {
                @this.saveThesisPartStudentAutoSave(); // se guarda el contenido
            }
        }

        function updateContent() {
            //el margen derecho debe descontarse de 21 cm
            @this.right_margin = 21 - CKEDITOR.config.ruler.sliders.right;
            @this.left_margin = CKEDITOR.config.ruler.sliders.left;
            if (document.getElementById("editor").tagName == "DIV") {
                // data = editor.getData();
                // data = editor1.getHTMLCode();
                data = window.editor1.getData();
                @this.set('content', data);
            }
        }

        function toggleSaving() {
            @this.toggleSaving();
        }

        function ShowHide() {
            var index = document.getElementById("IndexBar").style.display;
            if (index == "inline") {
                document.getElementById("IndexBar").style.display = "none";
                document.getElementById("SuperEditor").className = "col-md-12";
                document.getElementById("btnShowHide").innerHTML = ">>";
            } else {
                document.getElementById("IndexBar").style.display = "inline";
                document.getElementById("IndexBar").className = "col-md-4";
                document.getElementById("SuperEditor").className = "col-lg-8";
                document.getElementById("btnShowHide").innerHTML = "<<";
                //document.getElementById("SuperEditor").style.display="none";
                //document.getElementById("SuperEditor").style.display="inline";
            }

        }

        window.onload = activarAutoGuardado; //activa el intervalo de tiempo
    </script>


<script src="{{ url("ckeditor5/build/ckeditor.js") }}"></script>
<script>
DecoupledDocumentEditor
    .create( document.querySelector( '.editor' ), {

        licenseKey: '',



    } )
    .then( editor => {
        window.editor = editor;

        // Set a custom container for the toolbar.
        document.querySelector( '.document-editor__toolbar' ).appendChild( editor.ui.view.toolbar.element );
        document.querySelector( '.ck-toolbar' ).classList.add( 'ck-reset_all' );
    } )
    .catch( error => {
        console.error( 'Oops, something went wrong!' );
        console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
        console.warn( 'Build id: 2naelthjaj8v-iq1331jui4do' );
        console.error( error );
    } );
</script>

    {{-- nueva pestaña para enviar a la sección del video --}}
    <script>
        async function watchSection() {
            try {
                let url = await @this.goToTheCourse();
                window.open(url, '_blank');
            } catch (e) {
                console.log(e);
                alert("No es posible mostrar el curso");
            }
        }
    </script>
</div>
