@extends('layouts.tutorio')
@section('lycss')
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/ckeditor-docs.css') }}">

@stop
@section('content')

    <body>
        <div style="margin-top: -24px;">
            <x-lyontech.header></x-lyontech.header>
        </div>
        <div class="media mt-4">
            <div class="container">
                <div class="row ">
                    <div class="col-md-6 col-sm-12 offset-md-3 d-flex justify-content-center align-items-center">
                        <div class="image-der mr-3">
                            <img src="{{ asset('theme-lyontech/images/hoja-m.png') }}" alt="Card image cap"
                                style="width: 100px; margin: auto;">
                        </div>
                        <div class="texto">
                            <h5 class="mb-0" style="margin-left: -10px;">
                                <strong style="font-size: 1.8rem;letter-spacing: 0.0em;">HOJA DE TRABAJO</strong>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="div-body" data-editor="DecoupledDocumentEditor" data-collaboration="false"
            data-revision-history="false">
            <div class="div-main">
                <div class="centered">
                    <div class="row">
                        <div class="document-editor__toolbar"></div>
                    </div>
                    <div class="row row-editor">
                        <div class="editor-container">
                            <div class="editor" id="editor"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>

@stop
@section('global-modal')
    <div class="modal fade" id="ventanaModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
        aria-labelledby="tituloVentana" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="padding: 0px 15px 0px 30px;">
            <div class="modal-content bg-orange" style="border-radius: 10px;">
                <div class="modal-header" style="border: 0px">
                </div>
                <div class="modal-body pb-0" style="border: 0px; text-align:center;">
                    <img style="width: 50%;" src="{{ asset('assets/images/logoBlanco.png') }}" alt="">
                    <h3 style="font-weight: 700;">
                        ESTA HERRAMIENTA ESTÁ DISPONIBLE EN EL PLAN BASIC,
                        STANDARD Y PREMIUM
                    </h3>
                </div>
                <div class="modal-footer justify-content-center" style="border: 0px">
                    <a href="{{ route('modo_page') }}" type="button" class="btn btn-secondary btn-lg"
                        style="background-color: black;">
                        <strong>Mejorar</strong>
                    </a>
                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    <script src="{{ asset('ckeditor5/build/ckeditor.js') }}"></script>
    <script>
        function activeCkeditor5Default() {
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
        $(document).ready(function() {
            $('#ventanaModal').modal('show');
            activeCkeditor5Default();
        });
    </script>
@endsection
