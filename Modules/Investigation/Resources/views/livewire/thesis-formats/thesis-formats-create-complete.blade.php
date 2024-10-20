<div class="">
    <div class="container page__container">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME', 'Laravel') }}</a></li>
            <li class="breadcrumb-item active"><a
                    href="{{ route('Investigation_thesis_formats_list_complete') }}">{{ __('labels.Thesis Formats') }}</a>
            </li>
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
                                @error('name')
                                    <span class="invalid-feedback-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="description">{{ __('labels.Description') }}
                                    *</label>
                                <input wire:model="description" type="text" class="form-control" id="description">
                                @error('description')
                                    <span class="invalid-feedback-2">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="type_thesis">{{ __('labels.Type Thesis') }}
                                    *</label>
                                <select wire:model.defer="type_thesis" type="select" class="form-control"
                                    id="type_thesis" onchange="selectType(event)">
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
                                <label class="form-label" for="normative_thesis">{{ __('labels.Normative') }}/
                                    {{ __('labels.Style') }} </label>
                                *</label>
                                <select wire:model.defer="normative_thesis" type="select" class="form-control"
                                    id="normative_thesis" onchange="selectType(event)">
                                    <option value="">Seleccionar</option>
                                    @foreach ($enum_normatives as $type)
                                        <option value="{{ $type }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                                @error('normative_thesis')
                                    <span class="invalid-feedback-2">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="country_id">{{ __('labels.Country') }}
                                    *</label>
                                <select wire:model.defer="country_id" type="select" class="form-control"
                                    id="country_id" wire:change="getUniversities">
                                    <option value="">Seleccionar</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->description }}</option>
                                    @endforeach
                                </select>
                                @error('country_id')
                                    <span class="invalid-feedback-2">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label class="form-label" for="university_id">{{ __('labels.University') }}
                                    *</label>
                                <select wire:model.defer="university_id" type="select" class="form-control"
                                    id="university_id" wire:change="getSchools">
                                    <option value="">Seleccionar</option>
                                    @foreach ($universities as $university)
                                        <option value="{{ $university->id }}">{{ $university->name }}</option>
                                    @endforeach
                                </select>
                                @error('id_university')
                                    <span class="invalid-feedback-2">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label class="form-label" for="school_id;">{{ __('labels.School') }}
                                    *</label>
                                <select wire:model.defer="school_id" type="select" class="form-control"
                                    id="school_id">
                                    <option value="">Seleccionar</option>
                                    @foreach ($schools as $school)
                                        <option value="{{ $school->id }}">{{ $school->name }}</option>
                                    @endforeach
                                </select>
                                @error('school_id')
                                    <span class="invalid-feedback-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="right_margin">Margen derecho *</label>
                                <input wire:model="right_margin" type="text" class="form-control" id="right_margin" title="ingrese numero en cm ejemplo &quot;2.50&quot;">
                                @error('right_margin')
                                    <span class="invalid-feedback-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="left_margin">Margen izquierdo *</label>
                                <input wire:model="left_margin" type="text" class="form-control" id="left_margin" title="ingrese numero en cm ejemplo &quot;2.50&quot;">
                                @error('left_margin')
                                    <span class="invalid-feedback-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="between_lines">Entre líneas *</label>
                                <input wire:model="between_lines" type="text" class="form-control" id="between_lines" title="ingrese numero en cm ejemplo &quot;2.50&quot;">
                                @error('between_lines')
                                    <span class="invalid-feedback-2">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="top_margin">Margen Superior *</label>
                                <input wire:model="top_margin" type="text" class="form-control" id="top_margin" title="ingrese numero en cm ejemplo &quot;2.50&quot;">
                                @error('top_margin')
                                    <span class="invalid-feedback-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="bottom_margin">Margen Inferior *</label>
                                <input wire:model="bottom_margin" type="text" class="form-control" id="bottom_margin" title="ingrese numero en cm ejemplo &quot;2.50&quot;">
                                @error('bottom_margin')
                                    <span class="invalid-feedback-2">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" wire:loading.attr="disabled" wire:target="save"
                                class="btn btn-primary">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('thesis-format-create', event => {
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
