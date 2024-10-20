<div>
    <div wire:ignore.self class="modal fade" id="modalIndexes" tabindex="-1" aria-labelledby="modalIndexesLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <input type="hidden" id="thesis-index-type" value="0">
                <textarea name="" id="index_copy" cols="1" rows="1" style="height: 0px; display:none;"></textarea>
                <div class="modal-header">
                    <h5 class="modal-title" id="modalIndexesLabel">Índices</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="nav justify-content-center" id="index-tabs">
                        <li class="nav-item">
                            <a class="nav-link {{ $type == 0 ? 'active' : '' }}" wire:click="activeType(0)"
                                href="javascript:void(0)">General</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $type == 1 ? 'active' : '' }}" wire:click="activeType(1)"
                                href="javascript:void(0)">Tablas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $type == 2 ? 'active' : '' }}" wire:click="activeType(2)"
                                href="javascript:void(0)">Imagenes</a>
                        </li>
                    </ul>
                    <div wire:ignore id="index-titulo-btn">
                        <button wire:click="addTitleIndexNew" id="btn-titulo-index" type="button"
                            class="btn btn-success btn-sm mb-4"><i class="fa fa-plus mr-1"></i>Titulo</button>
                    </div>

                    <div id="index">
                        @if (count($items) > 0)

                            @foreach ($items as $k => $item)
                                <div class="row mb-1">
                                    <div class="col-md-1 text-right">
                                        @if ($item['id'])
                                            <button
                                                onclick="addSubIndexNewJS({{ $k }},{{ $item['id'] }},{{ $item['type'] }})"
                                                type="button" class="btn btn-secondary btn-sm">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        @endif
                                    </div>
                                    <div class="col-md-1">
                                        <input wire:model="items.{{ $k }}.prefix"
                                            id="prefix-{{ $k }}" type="text"
                                            class="form-control form-control-sm text-right">
                                    </div>
                                    <div class="col-md-8">
                                        <input wire:model="items.{{ $k }}.content"
                                            id="content-{{ $k }}" type="text"
                                            class="form-control form-control-sm" style="background: #fff">
                                    </div>
                                    <div class="col-md-1">
                                        <input wire:model="items.{{ $k }}.page"
                                            id="page-{{ $k }}" type="text"
                                            class="form-control form-control-sm text-right" style="background: #fff">
                                    </div>
                                    <div class="col-md-1 text-right p-0">
                                        <div class="input-group-prepend">
                                            <button wire:loading.attr="disabled"
                                                wire:click="saveTitleIndexNew({{ $k }})" type="button"
                                                class="btn btn-success btn-sm mr-1">
                                                <span wire:loading wire:target="saveTitleIndexNew({{ $k }})"
                                                    wire:loading.class="spinner-border spinner-border-sm"
                                                    wire:loading.class.remove="fal fa-check" class="fa fa-check"
                                                    role="status" aria-hidden="true"></span>
                                            </button>
                                            <button wire:click="removeTitleIndex({{ $k }})" type="button"
                                                class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @error('items.' . $k . '.prefix')
                                        <small>{{ $message }}</small>
                                    @enderror
                                    @error('items.' . $k . '.content')
                                        <small>{{ $message }}</small>
                                    @enderror
                                    @error('items.' . $k . '.page')
                                        <small>{{ $message }}</small>
                                    @enderror
                                    <div id="sub-items-{{ $k . $item['id'] }}" class="col-md-11 offset-md-1 mt-1">
                                        @if ($item['items'])
                                            {!! $item['items'] !!}
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="copyIndex()">Copiar Indice al
                        editor</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('inve-thesis-indexes-item', event => {
            //let index = event.detail.keyItem;
            document.getElementById("btn-titulo-index").disabled = true;
        });
        window.addEventListener('inve-thesis-indexes-item-remove', event => {
            //let index = event.detail.keyItem;
            document.getElementById("btn-titulo-index").disabled = false;
        });
        window.addEventListener('inve-thesis-indexes-item-store', event => {
            //let index = event.detail.keyItem;
            document.getElementById("btn-titulo-index").disabled = false;
        });

        window.addEventListener('inve-thesis-indexes-change-type', event => {
            //let index = event.detail.keyItem;
            document.getElementById("thesis-index-type").value = event.detail.index_type;
        });

        function addSubIndexNewJS(k, id, type) {

            var ulsubpartFormat = document.getElementById('sub-items-' + k + id);
            var divExistente = document.getElementById('div-row-subitem-' + k + id);

            if (!divExistente) {
                var newLi = document.createElement('div');
                newLi.classList.add('row');
                newLi.id = 'div-row-subitem-' + k + id;
                newLi.innerHTML = `
                        <div class="col-md-1 text-right">
                        </div>
                        <div class="col-md-1">
                            <input
                                id="subprefix-` + k + id + `" type="text"
                                class="form-control form-control-sm text-right">
                        </div>
                        <div class="col-md-8">
                            <input
                                id="subcontent-` + k + id + `" type="text"
                                class="form-control form-control-sm" style="background: #fff">
                        </div>
                        <div class="col-md-1">
                            <input
                                id="subpage-` + k + id + `" type="text"
                                class="form-control form-control-sm text-right"
                                style="background: #fff">
                        </div>
                        <div class="col-md-1 text-right p-0">
                            <div class="input-group-prepend">
                                <button onclick="saveSubItemNewJS(${k},${id},${type})" id="btn-new-subitem-` + k + id + `" type="button" class="btn btn-success btn-sm mr-1">
                                    <span id="span-new-subitem-` + k + id + `" class="fa fa-check"></span>
                                </button>
                                <button
                                    onclick="removeSubItemNew(${k},${id})"
                                    type="button" class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>`;

                ulsubpartFormat.appendChild(newLi);

                var ulElemento = document.getElementById('sub-items-' + k + id);
                var cantidadLi = ulElemento.childElementCount;
            }
        }

        function removeSubItemNew(k, id) {
            var divExistente = document.getElementById('div-row-subitem-' + k + id);

            if (divExistente) {
                divExistente.remove();
            }
        }

        function saveSubItemNewJS(k, id, type) {

            var boton = document.getElementById('btn-new-subitem-' + k + id);
            var span = document.getElementById('span-new-subitem-' + k + id);
            var prefix = document.getElementById('subprefix-' + k + id).value;
            var content = document.getElementById('subcontent-' + k + id).value;
            var page = document.getElementById('subpage-' + k + id).value;

            if (prefix.trim() === '') {
                // Uno o ambos campos están vacíos, detener aquí
                alert('Por favor, completa todos los prefix.');
                return;
            }
            if (content.trim() === '') {
                // Uno o ambos campos están vacíos, detener aquí
                alert('Por favor, completa todos los contenido.');
                return;
            }
            if (page.trim() === '') {
                alert('Por favor, completa todos los pagina.');
                return;
            }

            if (boton && span) {

                boton.disabled = true;

                // Quitar la clase 'fa-check' y agregar la clase 'spinner-border'
                span.classList.remove('fa-check');
                span.classList.add('spinner-border', 'spinner-border-sm');

                var datos = {
                    id: null,
                    type: type,
                    thesis_id: {{ $thesis_student_id }},
                    prefix: prefix,
                    content: content,
                    page: page,
                    item_id: id
                };

                var token = "{{ csrf_token() }}";

                fetch("{{ route('investigation_thesis_student_index_store') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token, // Aquí se agrega el token
                        },
                        body: JSON.stringify(datos),
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        // Aquí puedes manejar la respuesta del servidor
                        @this.getIndexes()

                        // Por ejemplo, podrías habilitar el botón y restaurar la clase del span
                        boton.disabled = false;
                        span.classList.remove('spinner-border', 'spinner-border-sm');
                        span.classList.add('fa-check');
                    })
                    .catch(error => {
                        // Aquí puedes manejar errores en la solicitud
                        console.error('Error:', error);
                    })
                    .finally(() => {
                        // Aquí puedes realizar acciones que se ejecuten siempre, independientemente de si la solicitud fue exitosa o falló
                        // Por ejemplo, podrías habilitar el botón y restaurar la clase del span
                        boton.disabled = false;
                        span.classList.remove('spinner-border', 'spinner-border-sm');
                        span.classList.add('fa-check');
                    });
            }
        }

        function removeSubItemDB(k, id) {
            var divExistente = document.getElementById('div-row-subitem-db-' + k + id);

            if (divExistente) {
                divExistente.remove();
                @this.removeTitleSubIndex(id)
            }
        }

        function saveSubItemUpdateJS(k, id, uid) {

            var boton = document.getElementById('btn-new-subitem-db-' + k + uid);
            var span = document.getElementById('span-new-subitem-db-' + k + uid);
            var prefix = document.getElementById('subprefix-db-' + k + uid).value;
            var content = document.getElementById('subcontent-db-' + k + uid).value;
            var page = document.getElementById('subpage-db-' + k + uid).value;

            if (prefix.trim() === '') {
                // Uno o ambos campos están vacíos, detener aquí
                alert('Por favor, completa todos los prefix.');
                return;
            }
            if (content.trim() === '') {
                // Uno o ambos campos están vacíos, detener aquí
                alert('Por favor, completa todos los contenido.');
                return;
            }
            if (page.trim() === '') {
                alert('Por favor, completa todos los pagina.');
                return;
            }

            if (boton && span) {

                boton.disabled = true;

                // Quitar la clase 'fa-check' y agregar la clase 'spinner-border'
                span.classList.remove('fa-check');
                span.classList.add('spinner-border', 'spinner-border-sm');

                var datos = {
                    id: uid,
                    type: {{ $type }},
                    thesis_id: {{ $thesis_student_id }},
                    prefix: prefix,
                    content: content,
                    page: page,
                    item_id: id
                };

                var token = "{{ csrf_token() }}";

                fetch("{{ route('investigation_thesis_student_index_store') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token, // Aquí se agrega el token
                        },
                        body: JSON.stringify(datos),
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        // Aquí puedes manejar la respuesta del servidor
                        @this.getIndexes()

                        // Por ejemplo, podrías habilitar el botón y restaurar la clase del span
                        boton.disabled = false;
                        span.classList.remove('spinner-border', 'spinner-border-sm');
                        span.classList.add('fa-check');
                    })
                    .catch(error => {
                        // Aquí puedes manejar errores en la solicitud
                        console.error('Error:', error);
                    })
                    .finally(() => {
                        // Aquí puedes realizar acciones que se ejecuten siempre, independientemente de si la solicitud fue exitosa o falló
                        // Por ejemplo, podrías habilitar el botón y restaurar la clase del span
                        boton.disabled = false;
                        span.classList.remove('spinner-border', 'spinner-border-sm');
                        span.classList.add('fa-check');
                    });
            }
        }

        function copyIndex() {
            var datos = {
                type: document.getElementById("thesis-index-type").value,
                thesis_id: {{ $thesis_student_id }},
            };
            var routePost = "{{ route('investigation_index_export') }}";

            axios.post(routePost, datos).then(function(response) {
                    // Manejar la respuesta exitosa
                    var text = response.data.html;
                    //console.log(textarea_c)
                    try {
                        xEditor.setData(text)

                        /////aqui seria para quitar el borde de la tabla en la documentacion de 
                        ////////ckeditro puede estar

                        $('#modalIndexes').modal('hide');
                    } catch (error) {
                        console.error('Error al copiar el texto al portapapeles:', error);
                    }

                })
                .catch(function(error) {
                    // Manejar el error
                    console.error(error);
                });

        }
    </script>
</div>
