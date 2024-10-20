<div>
    @push('scripts')
        <script src="{{ asset('assets/js/ckeditor/manual_citation.js') }}"></script>
        <script src="{{ asset('assets/js/ckeditor/comments.js') }}"></script>
    @endpush
    <style>
        #editor {
            padding: {{ $top_margin }}mm {{ $right_margin }}mm {{ $bottom_margin }}mm {{ $left_margin }}mm;
        }

        strong {
            font-weight: bold;
        }
    </style>
    @stack('scripts')
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


        <div class="form-group">
            <label class="text-danger" id="paraphrase_left">Tienes {{ $paraphrase_left }} oportunidades de ayudas
                asistidas por Lyonteach(parafrasear, corregir, recomendar y proponer).</label>
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
                @if ($focused_part)
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
        @if ($focused_part)
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">{{ $focused_part->description }}</h5>
                </div>
            </div>
        @endif
    </div>
    @if ($focused_part)
        @if ($focused_part->body == true)
            <div class="m-5">
                <div class="row" id="worksheet">
                    <div wire:ignore class="col-3" id="paraphrase" style="display: none">
                        <div class="card p-2">
                            <div>
                                <div class="form-group">
                                    <label for="text1">Escribe aquí lo que desee parafrasear</label>
                                    <select class="form-control prompty bg-primary text-white" name="prompt">
                                        <option value="0">Como Investigador</option>
                                        <option value="1">Disminuir Similitud</option>
                                        <option value="2">Humanizar Texto</option>
                                    </select>
                                    <style>
                                        .prompty:hover {
                                            background-color: #ccc;
                                            color: red;
                                            animation: shake 0.4s;
                                        }

                                        @keyframes shake {
                                            0% {
                                                transform: translateX(0);
                                            }

                                            25% {
                                                transform: translateX(-5px);
                                            }

                                            50% {
                                                transform: translateX(5px);
                                            }

                                            75% {
                                                transform: translateX(-5px);
                                            }

                                            100% {
                                                transform: translateX(0);
                                            }
                                        }
                                    </style>
                                    <textarea rows="8" class="form-control" wire:model='consulta' name="text1" id="text1"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="text2">Aquí verá el resultado</label>
                                    <textarea rows="8" class="form-control" wire:model='resultado' name="text2" id="text2" readonly
                                        placeholder="Escribe o copia arriba un párrafo para ser parafraseado y luego haz click en 'procesar' para obtener el resultado de nuestro servicio.">{!! $resultado !!}</textarea>
                                </div>
                                <button onclick="closeParahrase()" type="button"
                                    class="btn btn-success">Cancelar</button>
                                <button type="button" class="btn btn-warning" id="paraphrasing">Copiar</button>
                                <button class="btn btn-primary" wire:click="paraphrasing">Procesar</button>
                            </div>
                        </div>
                    </div>

                    <div wire:ignore class="col-12" id="documentsheet">
                        <div class="div-body" data-editor="DecoupledDocumentEditor" data-collaboration="false"
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
                        </div>
                        <div class="row">
                            <div class="col mb-2"
                                style="display: flex; align-items: center; justify-content: center;">
                                <button type="button" class="btn-primary btn  mt-0" wire:loading.attr="disabled"
                                    onclick="saveThesisPartStudent()">{{ __('labels.Save') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            {{-- <div class="container page__container">
            <div wire:ignore>
                <div class="editor" id="editor">{!! $content_old !!}</div>
            </div>
            @error('content')
                <span class="invalid-feedback-2">{{ $message }}</span>
            @enderror
        </div> --}}
            {{-- <div class="container page__container">
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
                    <button type="button" class="btn-primary btn  mt-3" wire:loading.attr="disabled"
                        onclick="saveThesisPartStudent()">{{ __('labels.Save') }}
                    </button>
                </div>
            </div>
        </div> --}}
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

            <input id="xleft-margin" type="hidden" value="{{ $left_margin }}">
            <input id="xright-margin" type="hidden" value="{{ $right_margin }}">
            <input id="xtop-margin" type="hidden" value="{{ $top_margin }}">
            <input id="xbottom-margin" type="hidden" value="{{ $bottom_margin }}">
        </div>
    </div>
    <input type="hidden" id="content_old" wire:model='content_old'>
    <script>
        var data = "";
        var xEditor;

        const textarea = document.getElementById('text2');
        const button = document.getElementById("paraphrasing");

        button.addEventListener("click", function() {
            textarea.select();
            document.execCommand("copy");
        });

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

        function onPageLoad() {
            document.addEventListener('livewire:load', function() {
                if (document.getElementById("editor").tagName == "DIV") {
                    // CKEDITOR.replace('editor');
                    activeCkeditor5();
                    updateMargenes();
                    updateContent();
                }
            });
        }

        document.addEventListener('DOMContentLoaded', onPageLoad);



        function saveThesisPartStudent() {
            updateContent();
            @this.saveThesisPartStudentN(true)
        }

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
            // @this.right_margin = 21 - CKEDITOR.config.ruler.sliders.right;
            // @this.left_margin = CKEDITOR.config.ruler.sliders.left;

            try {
                leftMargin = document.getElementById('left-margin').value;
                rightMargin = document.getElementById('right-margin').value;
                topMargin = document.getElementById('top-margin').value;
                bottomMargin = document.getElementById('bottom-margin').value;

                console.log(leftMargin, rightMargin, topMargin, bottomMargin);
                @this.set('left_margin', leftMargin);
                @this.set('top_margin', topMargin);
                @this.set('bottom_margin', bottomMargin);
                @this.set('right_margin', rightMargin);
                @this.updateMargins();
            } catch (error) {
                leftMargin = document.getElementById('xleft-margin').value;
                rightMargin = document.getElementById('xright-margin').value;
                topMargin = document.getElementById('xtop-margin').value;
                bottomMargin = document.getElementById('xbottom-margin').value;

                console.log('With Error', leftMargin, rightMargin, topMargin, bottomMargin);
                @this.set('left_margin', leftMargin);
                @this.set('top_margin', topMargin);
                @this.set('bottom_margin', bottomMargin);
                @this.set('right_margin', rightMargin);
                @this.updateMargins();
            }

            if (document.getElementById("editor").tagName == "DIV") {
                //data = editor.getData();
                // data = editor1.getHTMLCode();
                if (window.editor && typeof window.editor.getData === 'function') {
                    data = window.editor.getData();

                    @this.set('content', data);
                }

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


    <script>
        function activeCkeditor5() {
            DecoupledDocumentEditor.create(document.querySelector('.editor'), {
                    toolbar: {
                        items: [
                            'heading',
                            '|',
                            'fontSize',
                            'fontFamily',
                            '|',
                            'fontColor',
                            'fontBackgroundColor',
                            '|',
                            'bold',
                            'italic',
                            'underline',
                            'strikethrough',
                            '|',
                            'alignment',
                            '|',
                            'numberedList',
                            'bulletedList',
                            '|',
                            'outdent',
                            'indent',
                            '|',
                            'todoList',
                            'link',
                            'blockQuote',
                            'imageUpload',
                            '|',
                            'insertTable',
                            'paraphrase',
                            'completethesis',
                            'margins',
                            'referenciar',
                            'helpkeywords',
                            'recommendation',
                            'indexes',
                            '|',
                            'undo',
                            'redo',
                            'pageBreak',
                            '|',
                            'specialCharacters',
                            'findAndReplace',
                            'mediaEmbed'
                        ]
                    },
                    fontFamily: {
                        options: [
                            'Times New Roman, serif',
                            'Arial, sans-serif',
                            'Courier New, monospace',
                            'Georgia, serif',
                            'Verdana, sans-serif'
                        ]

                    },
                    fontSize: {
                        options: [{
                                model: '10pt',
                                title: '10'
                            },
                            {
                                model: '11pt',
                                title: '11'
                            },
                            {
                                model: '12pt',
                                title: '12'
                            },
                            {
                                model: '14pt',
                                title: '14'
                            },
                            {
                                model: '16pt',
                                title: '16'
                            },
                            {
                                model: '18pt',
                                title: '18'
                            },
                            {
                                model: '20pt',
                                title: '20'
                            },
                            {
                                model: '24pt',
                                title: '24'
                            },
                            {
                                model: '30pt',
                                title: '30'
                            },
                            {
                                model: '36pt',
                                title: '36'
                            },
                            {
                                model: '40pt',
                                title: '40'
                            }
                        ]
                    },
                    config: {
                        fontFamily: {
                            default: 'Times New Roman' // Establece "Times New Roman" como fuente predeterminada
                        }
                    },
                    simpleUpload: {
                        uploadUrl: "{{ route('investigation_thesis_upload_image') }}",
                        withCredentials: true,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    },
                    comments: {
                        urlData: "{{ route('investigation_thesis_get_comments', $this->thesis_id) }}"
                    },
                    references: {
                        url: "{{ route('investigation_thesis_references') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    },
                    recommendation: {
                        url: "{{ route('investigation_thesis_recommendation') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    },
                    helpkeywords: {
                        url: "{{ route('investigation_thesis_grammar_correction') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    },
                    htmlSupport: {
                        allow: [{
                            name: /.*/,
                            attributes: true,
                            classes: true,
                            styles: true
                        }]
                    }
                })
                .then(editor => {
                    window.editor = editor;
                    xEditor = editor;
                    document.querySelector('.document-editor__toolbar').appendChild(editor.ui.view.toolbar.element);
                    document.querySelector('.ck-toolbar').classList.add('ck-reset_all');

                    editor.editing.view.getDomRoot().style.paddingLeft = {{ $left_margin }} + 'mm';
                    editor.editing.view.getDomRoot().style.paddingRight = {{ $right_margin }} + 'mm';
                    editor.editing.view.getDomRoot().style.paddingTop = {{ $top_margin }} + 'mm';
                    editor.editing.view.getDomRoot().style.paddingBottom = {{ $bottom_margin }} + 'mm';


                })
                .catch(error => {
                    console.error('Oops, something went wrong!');
                    console.error(
                        'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:'
                    );
                    console.warn('Build id: nqbbe5edhs9m-u9490jx48w7r');
                    console.error(error);
                });

        }
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
        async function closeParahrase() {
            try {
                let cparaphrase = document.getElementById('paraphrase');
                let cdocumentsheet = document.getElementById('documentsheet');
                cparaphrase.style.display = 'none';

                cdocumentsheet.classList.remove("col-9");
                cdocumentsheet.classList.add("col-12");
            } catch (e) {
                console.log(e);
            }
        }


        // async function copyToClipboard() {
        //     var $temp = $("<input>")
        //     $("body").append($temp);
        //     $temp.val($('#text2').text()).select();
        //     document.execCommand("copy");
        //     $temp.remove();
        // }
    </script>
    <script>
        function applyStylesToStrongElements() {
            // Encuentra todos los elementos strong en la página
            var strongElements = document.getElementsByTagName('strong');

            // Itera sobre todos los elementos strong y cambia sus estilos
            for (var i = 0; i < strongElements.length; i++) {
                strongElements[i].style.fontWeight = 'bold';
            }
        }

        var isWindows11 = /Windows NT 10\.0/.test(navigator.userAgent) && /Win64/.test(navigator.userAgent);

        if (isWindows11) {

            // Ejecuta la función inicialmente
            applyStylesToStrongElements();

            // Ejecuta la función cada 300ms utilizando setInterval
            setInterval(applyStylesToStrongElements, 80);

            console.log('Estás utilizando Windows 11');

        } else {

            window.addEventListener('DOMContentLoaded', function() {
                // Encuentra todos los elementos strong en la página
                var strongElements = document.getElementsByTagName('strong');

                // Itera sobre todos los elementos strong y cambia sus estilos
                for (var i = 0; i < strongElements.length; i++) {
                    strongElements[i].style.fontWeight = 'bold';
                }
            });

            // Agrega un evento de escucha para el evento DOMNodeInserted en el body
            document.body.addEventListener('DOMNodeInserted', function(event) {
                // Verifica si el elemento agregado es un strong
                if (event.target.nodeName === 'STRONG') {
                    event.target.style.fontWeight = 'bold';
                }
            });

            console.log('No estás utilizando Windows 11');
        }
    </script>

    <script>
        function __getDestroyComments(id, index, tesis_id) {
            var confirmacion = confirm("¿Estás seguro de que deseas continuar?");

            if (confirmacion) {

                const xhr = new XMLHttpRequest();
                let url = '/investigation/thesis/comentary/thesis/destroy/' + id + '/' + tesis_id;
                xhr.open('GET', url, true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        document.getElementById("ly-list-item-" + index).remove();
                        if (response.exists === false) {
                            document.getElementById("lyc-ck-sidebar-list-comments").remove();
                        }

                    } else {
                        console.log('Error: ' + xhr.status);
                    }
                };

                xhr.onerror = function() {
                    console.log('Error de red.');
                };

                xhr.send();
            }
        }
    </script>
    <style id="margenes">

    </style>
    <script>
        function updateMargenes() {
            var topm = @this.top_margin;
            var botm = @this.bottom_margin;
            var leftm = @this.left_margin;
            var rightm = @this.right_margin;

            var styleTag = document.getElementById('margenes');
            styleTag.textContent = ".ck-content p {\n" +
                "    margin-left: " + leftm + "mm;\n" +
                "    margin-right: " + rightm + "mm;\n" +
                "    margin-top: " + topm + "mm;\n" +
                "    margin-bottom: " + botm + "mm;\n" +
                "    /* Puedes ajustar el valor según tus necesidades */\n" +
                "}";
        }
    </script>

    <script>
        function hacerClicEnBoton() {
            // Buscar el botón con la clase "ck ck-button ck-off ck-dropdown__button" y el código HTML especificado
            var botones = document.querySelectorAll('.ck.ck-button.ck-off.ck-dropdown__button');
            var boton;
            for (var i = 0; i < botones.length; i++) {
                if (botones[i].innerHTML.trim() ===
                    '<path d="M11.03 3h6.149a.75.75 0 1 1 0 1.5h-5.514L11.03 3zm1.27 3h4.879a.75.75 0 1 1 0 1.5h-4.244L12.3 6zm1.27 3h3.609a.75.75 0 1 1 0 1.5h-2.973L13.57 9zm-2.754 2.5L8.038 4.785 5.261 11.5h5.555zm.62 1.5H4.641l-1.666 4.028H1.312l5.789-14h1.875l5.789 14h-1.663L11.436 13z"></path>'
                ) {
                    boton = botones[i];
                    break;
                }
            }

            // Verificar si se encontró el botón
            if (boton) {
                // Simular un evento de clic en el botón
                var eventoClic = new MouseEvent('click', {
                    bubbles: true,
                    cancelable: true,
                    view: window
                });
                boton.dispatchEvent(eventoClic);
            }
        }


        function hacerClicEnSpan() {
            // Buscar el span con la clase "ck ck-button__label" y el texto "Times New Roman"
            var spans = document.querySelectorAll('.ck.ck-button__label');
            var span;
            for (var i = 0; i < spans.length; i++) {
                if (spans[i].textContent === 'Times New Roman') {
                    span = spans[i];
                    break;
                }
            }

            // Verificar si se encontró el span
            if (span) {
                // Simular un evento de clic en el span
                var eventoClic = new MouseEvent('click', {
                    bubbles: true,
                    cancelable: true,
                    view: window
                });
                span.dispatchEvent(eventoClic);
            }
        }
        setTimeout(function() {

            setTimeout(function() {
                // Código que se ejecutará después de una pausa de 300 ms
                // Llamar a la función para hacer clic en el botón de fuentes
                hacerClicEnBoton();
                console.log("CLICK");
            }, 444);
            setTimeout(function() {
                // Código que se ejecutará después de una pausa de 300 ms
                // Llamar a la función para hacer clic en boton times new roman
                hacerClicEnSpan();
            }, 444);
        }, 444);
    </script>

    <div id="dialog-ckeditor"></div>
    <style>
        #editor p {
            font-family: "Times New Roman", Times, serif;
        }
    </style>
</div>
