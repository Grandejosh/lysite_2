<div class="">
    <div class="container page__container">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME','Laravel') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('Investigation_universities_list') }}">{{ __('labels.Universities')}}</a></li>
            <li class="breadcrumb-item active">{{ __('labels.New') }}</li>
        </ol>
    </div>
    <div class="container page__container">
        <div class="col-lg-12 p-0 mx-auto">
            <div class="card card-body mb-32pt">
                <div class="row">
                    <div class="col-lg-4">
                        <h4 class="card-title">Formulario de registro para Editar proyecto de tesis</h4>
                        <p class="text-70">todos los campos que tienen * son obligatorios para el registro</p>
                    </div>
                    <div class="col-lg-8 d-flex align-items-center">
                        <form wire:submit.prevent="save" class="flex">

                            <div class="form-group">
                                <label class="form-label" for="name">Nombre Corto*</label>
                                <input wire:model="short_name" type="text" class="form-control" id="short_name">
                                @error('short_name') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="title">Título*</label>
                                <textarea wire:model="title" class="form-control" id="title"></textarea>
                                @error('title') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="country_id">{{ __('labels.Country') }}
                                    *</label>
                                <select
                                    wire:model.defer="country_id"
                                    class="form-control"
                                    id="country_id"
                                    wire:change="getUniversities"
                                >
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
                                <label class="form-label">{{ __('labels.University') }}</label>
                                <select wire:change="getSchools" wire:model="university_id" class="form-control" id="university_id">
                                    <option value="">Seleccionar</option>
                                    @foreach($universities as $university)
                                        <option value="{{ $university->id }}">{{ $university->name }}</option>
                                    @endforeach
                                </select>
                                @error('university_id') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">{{ __('investigation::labels.schools') }}</label>
                                <select wire:change="getFormat" wire:model="school_id" class="form-control" id="school_id">
                                    <option value="">Seleccionar</option>
                                    @foreach($schools as $school)
                                        <option value="{{ $school->id }}">{{ $school->name }}</option>
                                    @endforeach
                                </select>
                                @error('school_id') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">{{ __('investigation::labels.formats') }}</label>
                                <select wire:model="format_id" class="form-control" id="format_id">
                                    <option value="">Seleccionar</option>
                                    @foreach($formats as $format)
                                        <option value="{{ $format->id }}">{{ $format->type_thesis.' - '.$format->normative_thesis.' - '.$format->name }}</option>
                                    @endforeach
                                </select>
                                @error('format_id') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                            </div>

                            <button type="submit" wire:loading.attr="disabled" wire:target="save" class="btn btn-orange">Actualizar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('inve-thesis-student-edit', event => {
            cuteAlert({
                type: "success",
                title: event.detail.tit,
                message: event.detail.msg,
                buttonText: "Okay"
            });
        })
    </script>
</div>
