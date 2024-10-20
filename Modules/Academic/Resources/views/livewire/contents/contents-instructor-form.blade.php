<div>
    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="exampleModalContent" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">SECCIÓN: {{ $this->section_name }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">{{ __('academic::labels.type') }} *</label>
                                <select onchange="changeType(event)" wire:model.defer="content_type_id"
                                    class="form-control">
                                    <option value="">Seleccionar</option>
                                    @foreach ($content_types as $content_type)
                                        <option value="{{ $content_type->id }}">{{ $content_type->name }}</option>
                                    @endforeach
                                </select>
                                @error('content_type_id')
                                    <span class="invalid-feedback-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">{{ __('academic::labels.name') }} *</label>
                                <input wire:model.defer="name" type="text" class="form-control">
                                @error('name')
                                    <span class="invalid-feedback-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" wire:ignore>
                            <div class="form-group" id="link1" style="display: none">
                                <label for="link">{{ __('academic::labels.link') }} *</label>
                                <input wire:model.defer="link" class="form-control" type="text">
                                @error('link')
                                    <span class="invalid-feedback-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group" id="text2">
                                <label for="text">{{ __('academic::labels.content') }} *</label>
                                <div wire:ignore class="form-group" id="editorForm">
                                    <script src="https://cdn.ckeditor.com/ckeditor5/31.1.0/classic/ckeditor.js"></script>
                                    <script src="https://cdn.ckeditor.com/ckeditor5/31.1.0/classic/translations/sp.js"></script>

                                    <textarea wire:model="text" name="text" class="form-control" id="editor" rows="10" cols="80">
                                    </textarea>
                                    @error('content_url')
                                        <span class="invalid-feedback-2">{{ $message }}</span>
                                    @enderror
                                    <script>
                                        ClassicEditor
                                            .create(document.querySelector('#editor'), {
                                                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote',
                                                    'insertTable', 'mediaEmbed', '|', 'undo', 'redo'
                                                ],
                                                heading: {
                                                    options: [{
                                                            model: 'paragraph',
                                                            title: 'Normal',
                                                            class: 'ck-heading_paragraph'
                                                        },
                                                        {
                                                            model: 'heading1',
                                                            view: 'h1',
                                                            title: 'Muy Grande',
                                                            class: 'ck-heading_heading1'
                                                        },
                                                        {
                                                            model: 'heading2',
                                                            view: 'h2',
                                                            title: 'grande',
                                                            class: 'ck-heading_heading2'
                                                        },
                                                        {
                                                            model: 'heading3',
                                                            view: 'h3',
                                                            title: 'Mediano',
                                                            class: 'ck-heading_heading3'
                                                        }
                                                    ]
                                                }
                                            })
                                            .then(function(editor) {
                                                editor.model.document.on('change:data', () => {
                                                    @this.set('text', editor.getData());
                                                })
                                            })
                                            .catch(error => {
                                                console.error(error);
                                            });
                                    </script>
                                    <br>
                                </div>
                            </div>
                            <div class="form-group" id="file3" style="display: none">
                                <label for="file">{{ __('academic::labels.file') }} *</label>
                                <input wire:model.defer="file" type="file">
                                @error('file')
                                    <span class="invalid-feedback-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-row-reverse">
                        <button wire:click="saveContent" wire:loading.attr="disabled" wire:target="saveContent"
                            class="btn btn-primary ml-auto">Guardar</button>
                    </div>
                    <hr>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-center">Acción</th>
                                <th>Tipo</th>
                                <th>Nombre</th>
                                <th>Contenido</th>
                                <th>Nombre Original</th>
                                <th>Numero de Orden</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <script wire:ignore src="https://cdn.ckeditor.com/ckeditor5/31.1.0/classic/ckeditor.js"></script>
                            @if (count($contents) > 0)
                                @foreach ($contents as $key => $content)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td class="text-center">
                                            <button onclick="deletes({{ $content->id }})" type="button"
                                                class="btn btn-danger btn-sm"
                                                title="{{ __('labels.Remove assignment') }}"><i
                                                    class="fa fa-trash-alt"></i></button>
                                        </td>
                                        <td>{{ $content->content_type_name }}</td>
                                        <td>{{ $content->content_name }}</td>
                                        @if ($content->content_type_name == 'Texto')
                                            <td>
                                                <div id="accordion">
                                                    <div class="">
                                                        <div class="" id="h{{ $content->id }}">
                                                            <h5 class="mb-0">
                                                                <button class="btn btn-link" data-toggle="collapse"
                                                                    data-target="#cd{{ $content->id }}"
                                                                    aria-expanded="true"
                                                                    aria-controls="cd{{ $content->id }}">
                                                                    Click para ver Texto
                                                                </button>
                                                            </h5>
                                                        </div>
                                                        <div id="cd{{ $content->id }}" class="collapse"
                                                            aria-labelledby="h{{ $content->id }}" data-parent="#accordion">
                                                            <div class="">
                                                                {!! html_entity_decode($content->content_url, ENT_QUOTES, 'UTF-8') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                            </td>
                                        @else
                                            <td>{{ $content->content_url }}</td>
                                        @endif
                                        <td>{{ $content->original_name }}</td>
                                        <td class="text-center">{{ $content->count }}</td>
                                        <td>
                                            @if ($content->status)
                                                <span class="badge badge-success">Activo</span>
                                            @else
                                                <span class="badge badge-danger">Inactivo</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="text-center">No Existen Registros</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        window.addEventListener('aca-content-open-modal', event => {
            $('#exampleModalContent').modal('show')
        });

        function changeType(e) {
            if (e.target.value == '1') {
                $('#link1').css('display', 'block');
                $('#text2').css('display', 'none');
                $('#file3').css('display', 'none');
            } else if (e.target.value == '2') {
                $('#link1').css('display', 'none');
                $('#text2').css('display', 'block')
                $('#file3').css('display', 'none');
            } else if (e.target.value == '3') {
                $('#link1').css('display', 'none');
                $('#text2').css('display', 'none')
                $('#file3').css('display', 'block');
            } else if (e.target.value == '4') {
                $('#link1').css('display', 'none');
                $('#text2').css('display', 'none')
                $('#file3').css('display', 'block');
            } else {
                $('#link1').css('display', 'none');
                $('#text2').css('display', 'block')
                $('#file3').css('display', 'none');
            }
        }

        function deletes(id) {
            cuteAlert({
                type: "question",
                title: "¿Desea quitar a este instructor del curso?",
                message: "¿está seguro?",
                confirmText: "Okay",
                cancelText: "Cancel"
            }).then((e) => {
                if (e == ("confirm")) {
                    @this.destroy(id)
                }
            });
        }
        window.addEventListener('aca-content-delete', event => {
            cuteAlert({
                type: event.detail.res,
                title: event.detail.tit,
                message: event.detail.msg,
                buttonText: "Okay"
            });
        })
    </script>
</div>
