<div class="">
    <div class="container page__container">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME','Laravel') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('Investigation_universities_list') }}">{{ __('labels.Universities')}}</a></li>
            <li class="breadcrumb-item">{{ __('labels.Edit') }}</li>
            <li class="breadcrumb-item active">{{ $university->siglas}}</li>
        </ol>
    </div>
    <div class="container page__container">
        <div class="col-lg-12 p-0 mx-auto">
            <div class="card card-body mb-32pt">
                <div class="row">
                    <div class="col-lg-4">
                        <h4 class="card-title">Formulario para Actualizar datos de Universidad</h4>
                        <p class="text-70">todos los campos que tienen * son obligatorios para el registro</p>
                    </div>
                    <div class="col-lg-8 d-flex align-items-center">
                        <form wire:submit.prevent="save" class="flex">

                            <div class="form-group">
                                <label class="form-label" for="name">{{ __('labels.University name') }}*</label>
                                <input wire:model="name" type="text" class="form-control" id="name">
                                @error('name') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="siglas">{{ __('labels.University acronym') }}*</label>
                                <input wire:model="siglas" type="text" class="form-control" id="siglas">
                                @error('siglas') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="Country">{{ __('labels.Country') }}
                                    *</label>
                                <select
                                    wire:model.defer="country"
                                    type="select"
                                    class="form-control"
                                    id="country"
                                    onchange="selectType(event)"
                                >
                                    <option value="">Seleccionar</option>
                                    @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->description }}</option>

                                    @endforeach
                                </select>
                                @error('country')
                                    <span class="invalid-feedback-2">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" wire:loading.attr="disabled" wire:target="save" class="btn btn-primary">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('university_update', event => {
            cuteAlert({
                type: "success",
                title: event.detail.tit,
                message: event.detail.msg,
                buttonText: "Okay"
            }).then(() => {
            @this.back();
        });
        })
        </script>
</div>
