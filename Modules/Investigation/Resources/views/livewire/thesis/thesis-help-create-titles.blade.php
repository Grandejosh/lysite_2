<div>

    <!-- Modal -->
    <style>
        .modal-dialog-centered .modal-dialog {
            max-width: 620px; /* Ejemplo de ancho fijo en píxeles */
            min-height: calc(100vh - 0);
            transform: translate(0, 0);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .modal-dialog-centered .modal-content {
            height: calc(100vh - 0);
            overflow-y: auto;
        }
    </style>
    <div wire:ignore.self class="modal fade modal-left" id="exampleModalScrollable" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Ayuda para crear Títulos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Ayudanos brindando información de lo que deseas para tu tesis</p>
                    <div class="form-group">
                        <label class="form-label" for="name" title="temas relacionados a tu carrera y lo que quieres investigar">Palabras Clave*</label>
                        <input wire:model="keywords" type="text" class="form-control" id="keywords" placeholder="palabras relacionadas a tu investigación y carrera">
                        @error('keywords') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="name" title="Tu Carrera o especialidad">Carrera/Profesión*</label>
                        <input wire:model="career" type="text" class="form-control" id="career" placeholder="Ingeniería Civil, Medicina, Enfermería, Odontología, etc...">
                        @error('career') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="name" title="Tipo de Tesis">Tipo de Tesis*</label>
                        <input wire:model="type_thesis" type="text" class="form-control" id="type_thesis" placeholder="dinos si será, analítica, descriptiva, experimental, etc...">
                        @error('type_thesis') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="name">Respuesta</label>
                        <textarea rows="8" class="form-control" wire:model='resultado' name="text1" id="text1" disabled>{{  $resultado  }}</textarea>
                        @error('resultado') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                    </div>

                </div>
                <div class="modal-footer">
                    <span wire:loading.style='display:block' style="display: none">Se paciente...</span>
                    <button type="button" class="btn btn-primary"  wire:click="helpwithtitle" wire:target="helpwithtitle" wire:loading.attr="disabled">
                            <span wire:loading.remove>Procesar</span>
                            <span wire:loading.style='display:block' style="display: none">
                                <i class="fas fa-spinner fa-spin"></i> Cargando...
                            </span>
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:loading.attr="disabled">{{ __('labels.Close') }}</button>
                </div>
            </div>
        </div>
    </div>

</div>
