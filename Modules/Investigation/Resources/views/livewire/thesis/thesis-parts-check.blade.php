<div>
    @push('scripts')
        <script src="{{ asset('assets/js/ckeditor/manual_citation.js') }}"></script>
        <script src="{{ asset('assets/js/ckeditor/comments.js') }}"></script>
    @endpush
    <div class="container page__container">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME', 'Laravel') }}</a></li>
            <li class="breadcrumb-item active">{{ __('investigation::labels.thesis_parts') }}</li>
            <li class="breadcrumb-item active">{{ $student_name }}</li>
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
                <div class="btn-group" role="group" aria-label="">
                    {{-- <button wire:click="goEdit({{ $thesis_student->id }})" type="button" class="btn btn primary"><i
                            class="fa fa-pencil-alt mr-1"></i>
                    </button> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="m-5">
        <div class="card card-body mb-3">
            <div class="row">
                <div class="col-md-3">
                    <ul class="list-point-none">
                        @if (count($parts) > 0)
                            @foreach ($parts as $part)
                                @if ($part['id'] == $focus_id)
                                    <li class="alert alert-primary">
                                        <a class="alert-link"
                                            href="{{ route('investigation_thesis_check', [$thesis_id, $part['id']]) }}">
                                            {{ $part['number_order'] . ' ' . $part['description'] }}</a>
                                        {!! $part['items'] !!}
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ route('investigation_thesis_check', [$thesis_id, $part['id']]) }}">
                                            {{ $part['number_order'] . ' ' . $part['description'] }}</a>
                                        {!! $part['items'] !!}
                                    </li>
                                @endif
                            @endforeach
                        @else
                            <div class="alert alert-info">
                                Este formato aún está pendiente de contenido. vuelve a intentarlo mas tarde o comunicarse
                                con el administrador del sitio.
                            </div>
                        @endif
                    </ul>
                    {{-- <a href="{{ route('investigation_thesis_export_pdf', $thesis_id) }}"
                        class="btn btn-warning btn-block mt-3" target="_blank">
                        Exportar PDF
                    </a> --}}
                </div>
                <div class="col-lg-9">
                    @if ($focused_part)
                        <div class="row justify-content-md-center">
                            <div class="col col-lg-12">
                                <label class="form-label" for="content">{{ $focused_part->description }}</label>
                            </div>
                        </div>
                        <div class="flex">
                            @if ($focused_part->body == true)
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        {{-- <div wire:ignore>
                                            <textarea class="form-control" id="editor" rows="40" cols="80">{!! $content_old !!}</textarea>
                                        </div> --}}
                                        <div wire:ignore class="col-12" id="documentsheet">
                                            <div class="div-body" data-editor="DecoupledDocumentEditor"
                                                data-collaboration="false" data-revision-history="false">
                                                <div class="div-main">
                                                    <div class="centered" wire:ignore>
                                                        <div class="row">
                                                            <div class="document-editor__toolbar"></div>
                                                        </div>
                                                        <div class="row row-editor">
                                                            <div class="editor-container">
                                                                <div class="editor" id="editor">
                                                                    {!! $content_old !!}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @error('content')
                                            <span class="invalid-feedback-2">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label for="commentary">Nota:</label>
                                        <textarea wire:model.defer="commentary" id="commentary" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-9">
                                        <button type="button" class="btn-primary btn" wire:target="save"
                                            wire:loading.attr="disabled" onclick="savePart()">
                                            {{ __('labels.Save') }}
                                        </button>
                                    </div>
                                </div>
                            @else
                                <div>
                                    <h5>Esta Sección solo es un título o subtitulo sin contenido.</h5>
                                    <input type="hidden" name="" id="editor">
                                </div>
                            @endif

                        </div>

                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        var data = "";

        window.addEventListener('inve-student-part-create', event => {
            cuteAlert({
                type: 'success',
                title: 'Enhorabuena',
                message: 'Se registro correctamente',
                buttonText: "Okay"
            });
        });

        document.addEventListener('livewire:load', function() {
            if (document.getElementById("editor").tagName == "DIV") {
                //CKEDITOR.replace('editor');
                activeCkeditor5TUTOR();
            }
        });

        function savePart() {
            if (document.getElementById("editor").tagName == "DIV") {
                //data = CKEDITOR.instances.editor.getData();
                data = window.editor.getData();
                @this.set('content', data);
                @this.save();
            }
        }
    </script>
    <script>
        function activeCkeditor5TUTOR() {
            DecoupledDocumentEditor.create(document.querySelector('#editor'), {
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
                        'insertTable',
                        '|',
                        'comments',
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
                        options: [
                            { model: '10pt', title: '10' },
                            { model: '11pt', title: '11' },
                            { model: '12pt', title: '12' },
                            { model: '14pt', title: '14' },
                            { model: '16pt', title: '16' },
                            { model: '18pt', title: '18' },
                            { model: '20pt', title: '20' },
                            { model: '24pt', title: '24' },
                            { model: '30pt', title: '30' },
                            { model: '36pt', title: '36' },
                            { model: '40pt', title: '40' }
                        ]
                    },
                config: {
                    fontFamily: {
                        default: 'Times New Roman' // Establece "Times New Roman" como fuente predeterminada
                    }
                },
                licenseKey: 'AH9z8JZzCLSSQ0QH0GEZwxX2c65Li7fafzEp7GaVXKRtezRZlEIY7lFoyIdA',
                simpleUpload: {
                    uploadUrl: "{{ route('investigation_thesis_upload_image') }}",
                    withCredentials: true,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                comments: {
                    ajax: {
                        url: "{{ route('investigation_thesis_selection_comments') }}",
                        data: {
                            thesi_student_part_id: {{ $xpart_id }},
                            thesi_student_id: {{ $thesis_student->id }},
                            thesi_format_part_id: {{ $focus_id }}
                        },
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    },
                    urlData: "{{ route('investigation_thesis_get_comments', $thesis_student->id) }}"
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
            }).then(editor => {
                window.editor = editor;
                document.querySelector('.document-editor__toolbar').appendChild(editor.ui.view.toolbar.element);
                document.querySelector('.ck-toolbar').classList.add('ck-reset_all');
            }).catch(error => {
                console.error('Oops, something went wrong!');
                console.error(
                    'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:'
                );
                console.warn('Build id: nqbbe5edhs9m-u9490jx48w7r');
                console.error(error);
            });

        }
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
    @stack('scripts')
    <style>
        p {
  font-family: "Times New Roman", Times, serif;
}
    </style>
</div>
