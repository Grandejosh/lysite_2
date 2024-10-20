<div>
    <!-- Modal -->
<div wire:ignore.self class="modal fade" id="modalEditFormatStudent" tabindex="-1" aria-labelledby="modalFormatStudentLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFormatStudentLabel">Editar Mi Formato</h5>
                <button id="btn-add-format-title" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-label" for="normative_thesisx">{{ __('labels.Normative') }}/
                                {{ __('labels.Style') }} </label>
                            *</label>
                            <select wire:model.defer="normative_thesisx" type="select" class="form-control"
                                id="normative_thesisx">
                                <option value="">Seleccionar</option>
                                @foreach ($enum_normatives as $type)
                                    <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                            </select>
                            @error('normative_thesisx')
                                <span class="invalid-feedback-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-label" for="type_thesisx">{{ __('labels.Type Thesis') }}
                                *</label>
                            <select wire:model.defer="type_thesisx" type="select" class="form-control"
                                id="type_thesisx">
                                <option value="">Seleccionar</option>
                                @foreach ($enum_types as $type)
                                    <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                            </select>
                            @error('type_thesisx')
                                <span class="invalid-feedback-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label" for="namex">{{ __('labels.Format name') }} *</label>
                            <input wire:model="namex" type="text" class="form-control" id="namex">
                            @error('namex')
                                <span class="invalid-feedback-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- Inicio Margenes generales para la tesis --}}
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-label" for="xleft">{{ __('Margen Izquierda en mm') }} *</label>
                            <input wire:model="xleft" type="number" class="form-control" id="xleft">
                            @error('xleft')
                                <span class="invalid-feedback-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-label" for="xright">{{ __('Margen Derecha en mm') }} *</label>
                            <input wire:model="xright" type="number" class="form-control" id="xright">
                            @error('xright')
                                <span class="invalid-feedback-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-label" for="xtop">{{ __('Margen Arriba en mm') }} *</label>
                            <input wire:model="xtop" type="number" class="form-control" id="xtop">
                            @error('xtop')
                                <span class="invalid-feedback-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-label" for="xbottom">{{ __('Margen Abajo en mm') }} *</label>
                            <input wire:model="xbottom" type="number" class="form-control" id="xbottom">
                            @error('xbottom')
                                <span class="invalid-feedback-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- Fin Margenes generales para la tesis --}}
                </div>
                <button wire:click="addTitlePartEdit" type="button" class="btn btn-primary btn-sm mb-4"><i class="fa fa-plus mr-1"></i>Titulo</button>
                <ul class="list-point-none">
                    @if(count($parts) > 0)
                        @foreach($parts as $k => $part)
                            <li>
                                @if($part['id'])
                                    <div class="btn-group mr-3">
                                        <button onclick="addSubPartFormatJS({{ $k }},{{ $part['id'] }})" type="button" class="btn btn-secondary btn-sm">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                        <button onclick="deletePartStudentJS({{ $part['id'] }})" type="button" class="btn btn-secondary btn-sm">
                                            <i class="fa fa-trash-alt"></i>
                                        </button>
                                    </div>
                                @endif
                                <a class="formattitleload" href="#" id="xformattitle{{ $k }}" data-type="text" data-pk="{{ $part['id'] }}" data-title="Escriba Titulo">{{ $part['description'] }}</a>
                                <ul id="ULsubpartFormat{{ $k . $part['id'] }}">
                                @if($part['items'])
                                    {!! $part['items']  !!}
                                @endif
                                </ul>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button wire:click="updateFormatStudent" type="button" class="btn btn-primary">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>
<script>
    function openModalEditFormat(id){
        @this.set('format_idx',id);
        @this.getAllData(id);
        @this.getParts();

        $('#modalEditFormatStudent').modal('show');
    }
    $.fn.editable.defaults.mode = 'inline';
    window.addEventListener('inve-thesis-student-format-add-update', event => {
        let index = event.detail.keytitle;
        $('#xformattitle'+index).editable({
            url: function(params) {
                var d = new $.Deferred();
                if(params.value === 'abc') {
                    return d.reject('error message');
                } else {
                    @this.set('descriptionx', params.value);
                    @this.set('number_orderx', index + 1);
                    @this.savePartEstudentEdit();
                }
            }
        });
    });
    window.addEventListener('inve-thesis-student-format-add-load', event => {
        $('.formattitleload').editable({
            url: function(params) {
                var d = new $.Deferred();
                if(params.value === 'abc') {
                    return d.reject('error message');
                } else {
                    @this.set('descriptionx', params.value);
                    @this.savePartEstudentEditUpdate(params.pk);
                }
            }
        });
    });
    function saveFormatStudentJS(){
        let selectElement = document.getElementById('school_id');
        let selectedValue = selectElement.value;

        if (selectedValue === '') {
            alert('Por favor, selecciona una Escuela.');
            return;
        } 

        @this.set('school_id', selectedValue);
        @this.savePartEstudentEdit();
    }
    function deletePartStudentJS(id){
        @this.deletePartStudent(id);
    }
    function addSubPartFormatJS(k,id){
        var ulsubpartFormat = document.getElementById('ULsubpartFormat'+k+id);

        var newLi = document.createElement('li');
        newLi.innerHTML = '<a class="formattitleload" href="#" id="xsubformattitle'+ k + id + '" data-type="text" data-pk="'+ id + '"></a>';

        // Agregar el nuevo elemento li al final del ul
        ulsubpartFormat.appendChild(newLi);
        var ulElemento = document.getElementById('ULsubpartFormat'+k+id);
        var cantidadLi = ulElemento.childElementCount;
        $('#xsubformattitle'+ k + id ).editable({
            url: function(params) {
                var d = new $.Deferred();
                if(params.value === 'abc') {
                    return d.reject('error message');
                } else {
                    @this.set('part_idx', params.pk);
                    @this.set('descriptionx', params.value);
                    @this.set('number_orderx', cantidadLi);
                    @this.savePartEstudentEdit();
                }
            }
        });
    }
    window.addEventListener('thesis-format-create-estudent-edit', event => {
        alert('Se Actualizo correctamente.');
        $('#modalEditFormatStudent').modal('hide');
        reloadFormatStudent();
    });
</script>
</div>