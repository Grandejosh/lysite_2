<div class="">
    <div class="container page__container">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME','Laravel') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('academic_content_types') }}">{{ __('labels.Content Types') }}</a></li>
            <li class="breadcrumb-item active">{{ __('labels.Edit') }}</li>
        </ol>
    </div>
    <div class="container page__container">
        <div class="col-lg-12 p-0 mx-auto">
            <div class="card card-body mb-32pt">
                <div class="row">
                    <div class="col-lg-4">
                        <h4 class="card-title">Formulario de Edición de Tipos de Contenido</h4>
                        <p class="text-70">todos los campos que tienen * son obligatorios para el registro</p>
                    </div>
                    <div class="col-lg-8 d-flex align-items-center">
                        <form wire:submit.prevent="update" class="flex">

                            <div class="form-group">
                                <label class="form-label" for="name">Nombre *</label>
                                <input wire:model="name" type="text" class="form-control" id="name">
                                @error('name') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="name">Descripcion *</label>
                                <textarea wire:model="description" class="form-control" id="description"></textarea>
                                @error('description') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                            </div>
                            <button type="submit" wire:loading.attr="disabled" wire:target="save" class="btn btn-primary">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('aca-content-update', event => {
            cuteAlert({
                type: "success",
                title: event.detail.tit,
                message: event.detail.msg,
                buttonText: "Okay"
            });
        })
        </script>
</div>
