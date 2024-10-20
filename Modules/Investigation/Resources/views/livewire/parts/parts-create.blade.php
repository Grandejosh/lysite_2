<div>
    <div wire:ignore.self class="modal fade" id="modalPartCreate" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPartCreateLabel">Formato</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="index_order" class="col-sm-2 col-form-label">Número de orden</label>
                        <div class="col-sm-4">
                            <input wire:model.defer="index_order" type="text" class="form-control" id="index_order">
                            @error('index_order')
                                <span class="invalid-feedback-2">{{ $message }}</span>
                            @enderror
                            <span>Este es el orden, el cual se mostraran los items(no se muestra)</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="number_order" class="col-sm-2 col-form-label">Identificador</label>
                        <div class="col-sm-4">
                            <input wire:model.defer="number_order" type="text" class="form-control" id="number_order">
                            @error('number_order')
                                <span class="invalid-feedback-2">{{ $message }}</span>
                            @enderror
                            <span>Este campo es el identificador en el index ejemplo:I,II o 1.1,1.2,1.3.....</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="description" class="col-sm-2 col-form-label">Descripción</label>
                        <div class="col-sm-10">
                            <input wire:model.defer="description" type="text" class="form-control" id="description">
                            @error('description')
                                <span class="invalid-feedback-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="information" class="col-sm-2 col-form-label">Mostrar/imprimir Descripción</label>
                        <div class="col-sm-10">
                            <div class="form-check">
                                <input wire:model="show_description" class="form-check-input" type="checkbox" name="exampleRadios5"
                                    id="exampleRadios5" title="si lo desactiva no se mostrará el subtítulo al exportar en PDF o WORD">
                                <label class="form-check-label" for="exampleRadios5">Si</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="information" class="col-sm-2 col-form-label">Iniciar en página nueva</label>
                        <div class="col-sm-10">
                            <div class="form-check">
                                <input wire:model="salto_de_pagina" class="form-check-input" type="checkbox" name="exampleRadios5"
                                    id="exampleRadios5" title="active si desea que inicie en una página nueva">
                                <label class="form-check-label" for="exampleRadios5">Si</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="information" class="col-sm-2 col-form-label">Información</label>
                        <div class="col-sm-10">
                            <textarea wire:model.defer="information" class="form-control" id="information"></textarea>
                            @error('information')
                                <span class="invalid-feedback-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="information" class="col-sm-2 col-form-label">Ingresar Contenido</label>
                        <div class="col-sm-10">
                            <div class="form-check">
                                <input wire:model="body" class="form-check-input" type="checkbox" name="exampleRadios4"
                                    id="exampleRadios4">
                                <label class="form-check-label" for="exampleRadios4">Si</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="information" class="col-sm-2 col-form-label">Estado</label>
                        <div class="col-sm-10">
                            <div class="form-check">
                                <input wire:model="state" class="form-check-input" type="checkbox" name="exampleRadios"
                                    id="exampleRadios3">
                                <label class="form-check-label" for="exampleRadios3">Activo</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">{{ __('labels.Close') }}</button>
                    <button wire:click="savePartNew" type="button"
                        class="btn btn-primary">{{ __('labels.Add') }}</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('open-modal-parts', event => {
            $('#modalPartCreateLabel').html(event.detail.title);
            $('#modalPartCreate').modal('show');
        });
        window.addEventListener('inve-parts-save', event => {
            cuteAlert({
                type: event.detail.res,
                title: event.detail.tit,
                message: event.detail.msg,
                buttonText: "Okay"
            });
        });
    </script>
</div>
