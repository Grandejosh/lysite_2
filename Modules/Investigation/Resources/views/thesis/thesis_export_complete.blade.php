<!DOCTYPE html><!--
 Copyright (c) 2014-2023, CKSource Holding sp. z o.o. All rights reserved.
 This file is licensed under the terms of the MIT License (see LICENSE.md).
-->

<html lang="en" dir="ltr">

<head>
    <title>Exportar Thesis</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ url('assets/images/logo/white-60.png') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('ckeditor5/sample/styles.css') }}">
    <link type="text/css" href="{{ url('assets/css/style.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body data-editor="DecoupledDocumentEditor" data-collaboration="false" data-revision-history="false">
    <header>
        <div class="centered">
            <h1>
                <a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer">
                    <img src="{{ url('assets/images/logo/white-60.png') }}" alt="{{ env('APP_NAME', 'Laravel') }}">
                    {{ env('APP_NAME', 'Laravel') }}
                </a>
            </h1>
            <nav>
                <ul>
                    {{-- <li><a href="https://ckeditor.com/docs/ckeditor5/" target="_blank" rel="noopener noreferrer">Documentation</a></li> --}}
                    <li><a href="{{ route('logout') }}" rel="noopener noreferrer">Cerrar sesión</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <div class="message">
            <div class="centered">
                <h2>Aquí podrá exportar su tesis: {{ $title }}</h2>
            </div>
        </div>
        <div class="centered">
            <div class="row">
                <div class="document-editor__toolbar"></div>
            </div>
            <div class="row row-editor">
                <div class="editor-container">
                    <div class="editor" id="editor">
                        {{-- {!! $content_old !!} --}}
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <p>Copyright © 2003-2023,
            <a href="{{ env('APP_URL') }}" target="_blank" rel="noopener">{{ env('APP_NAME', 'Laravel') }}</a>
            Reservados todos los derechos.
        </p>
    </footer>
    <div class="loading-overlay" id="loading-overlay">
        <div class="loading-spinner">
            <i class="fa fa-spinner fa-spin fa-3x"></i>
        </div>
    </div>
    <script src="{{ asset('ckeditor5/build/ckeditor.js') }}"></script>
    <script>
        function showLoading() {
            Swal.fire({
                title: 'Cargando',
                text: 'Por favor espera...',
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                showConfirmButton: false,
                onOpen: () => {
                    Swal.showLoading();
                }
            });
        }

        function hideLoading() {
            Swal.close();
        }
    </script>
    <script>
        window.onload = function() {
            showLoading();
            var thesis = {{ $thesis }}
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    hideLoading();
                    let data = JSON.parse(this.responseText);
                    createEditor(data);
                }
            };
            xhttp.open("POST", "{{ route('investigation_thesis_export_word_datos') }}", true);
            xhttp.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("thesis=" + thesis);
        };
    </script>
    <script>
        function createEditor(data) {
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
                            'margins',
                            'exportWord',
                            '|',
                            'undo',
                            'redo',
                            'pageBreak',
                            '|',
                            'specialCharacters',
                            'findAndReplace',
                            'mediaEmbed',
                            'insertTable'
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
                                default: 'Times New Roman, serif', // Establece "Times New Roman" como fuente predeterminada
                            }
                        },
                    // exportWord: {
                    //     tokenUrl: 'https://95003.cke-cs.com/token/dev/46e503e955d7f77b38008d51eaa879208855ed5db33746b583d26ebb8dae?limit=10',
                    //     fileName: 'MiTesis_con_Lyonteach.docx',
                    //     converterOptions: {
                    //         format: 'A4', // Default value, you don't need to specify it explicitly for A4.
                    //         margin_top: data.margins.top_margin + 'mm',
                    //         margin_bottom: data.margins.bottom_margin + 'mm',
                    //         margin_right: data.margins.right_margin + 'mm',
                    //         margin_left: data.margins.left_margin + 'mm'
                    //     }
                    // }

                    exportWord: {
                        converterUrl: 'https://docx-converter.cke-cs.com/v1/convert',
                        tokenUrl: "{{ route('ckeditor_token_generate') }}",
                        fileName: 'MiTesis_con_Lyonteach.docx',
                        converterOptions: {
                            format: 'A4', // Default value, you don't need to specify it explicitly for A4.
                            margin_top: data.margins.top_margin + 'mm',
                            margin_bottom: data.margins.bottom_margin + 'mm',
                            margin_right: data.margins.right_margin + 'mm',
                            margin_left: data.margins.left_margin + 'mm'
                        }
                    }

                })
                .then(editor => {
                    window.editor = editor;
                    editor.setData(data.content);
                    // Set a custom container for the toolbar.
                    document.querySelector('.document-editor__toolbar').appendChild(editor.ui.view.toolbar.element);
                    document.querySelector('.ck-toolbar').classList.add('ck-reset_all');

                    editor.editing.view.getDomRoot().style.paddingLeft = data.margins.left_margin + 'mm';
                    editor.editing.view.getDomRoot().style.paddingRight = data.margins.right_margin + 'mm';
                    editor.editing.view.getDomRoot().style.paddingTop = data.margins.top_margin + 'mm';
                    editor.editing.view.getDomRoot().style.paddingBottom = data.margins.bottom_margin + 'mm';
                })
                .catch(error => {
                    console.error('Oops, something went wrong!');
                    console.error(
                        'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:'
                    );
                    console.warn('Build id: kehfuamz5tol-66hszd8qikx0');
                    console.error(error);
                });
        }
    </script>
    <div id="global-modal"></div>
    <style>
        #editor {
            padding: {{ $top_margin }}mm {{ $right_margin }}mm {{ $bottom_margin }}mm {{ $left_margin }}mm;
        }
        p {
        /* font-family: "Times New Roman", Times, serif; */
        font-family: "Times New Roman", Times, serif;
        }
    </style>



</body>

</html>
