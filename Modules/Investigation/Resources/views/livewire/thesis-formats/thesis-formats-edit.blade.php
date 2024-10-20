<div class="">
    <div class="container page__container">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME','Laravel') }}</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('Investigation_universities_list') }}">{{ __('labels.universities') }}</a></li>
            <li class="breadcrumb-item active">{{ $university->siglas }}</li>
            <li class="breadcrumb-item active"><a href="{{ route('Investigation_universities_schools', $university->id) }}">{{ __('labels.schools') }}</a></li>
            <li class="breadcrumb-item active">{{ $school->name }}</li>
            <li class="breadcrumb-item active"><a href="{{ route('Investigation_thesis_formats_list', $school->id) }}">{{ __('labels.Thesis Formats') }}</a></li>
            <li class="breadcrumb-item active">{{ __('labels.New Thesis Format') }}</li>
        </ol>
    </div>
    <div class="container page__container">
        <div class="col-lg-12 p-0 mx-auto">
            <div class="card card-body mb-32pt">
                <div class="row">
                    <div class="col-lg-4">
                        <h4 class="card-title">Formulario de registro para Nuevo Formato de Tesis</h4>
                        <p class="text-70">todos los campos que tienen * son obligatorios para el registro</p>
                    </div>
                    <div class="col-lg-8 d-flex align-items-center">
                        <form wire:submit.prevent="save" class="flex">

                            <div class="form-group">
                                <label class="form-label" for="name">{{ __('labels.Format name') }} *</label>
                                <input wire:model="name" type="text" class="form-control" id="name">
                                @error('name') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="description">{{ __('labels.Description') }} *</label>
                                <input wire:model="description" type="text" class="form-control" id="description">
                                @error('description') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="type_thesis">Enfoque de Tesis:
                                    *</label>
                                <select
                                    wire:model.defer="type_thesis"
                                    type="select"
                                    class="form-control"
                                    id="type_thesis"
                                    onchange="selectType(event)"
                                >
                                    <option value="">Seleccionar</option>
                                    @foreach ($enum_types as $type)
                                    <option value="{{ $type }}">{{ $type }}</option>

                                    @endforeach
                                </select>
                                @error('type_thesis')
                                    <span class="invalid-feedback-2">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="normative_thesis">Normativa de redacción:
                                    *</label>
                                <select
                                    wire:model.defer="normative_thesis"
                                    type="select"
                                    class="form-control"
                                    id="normative_thesis"
                                    onchange="selectType(event)"
                                >
                                    <option value="">Seleccionar</option>
                                    @foreach ($enum_normatives as $type)
                                    <option value="{{ $type }}">{{ $type }}</option>

                                    @endforeach
                                </select>
                                @error('type_thesis')
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
        window.addEventListener('thesis-format-edit', event => {
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
