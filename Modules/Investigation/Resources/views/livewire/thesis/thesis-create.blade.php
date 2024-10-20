<div>

    <div class="container page__container">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME','Laravel') }}</a></li>
            <li class="breadcrumb-item"><a href=""> Proyecto </a></li>
            <li class="breadcrumb-item active-black" style="background: none;">{{ __('labels.New') }}</li>
        </ol>
    </div>
    <div class="container page__container">
        <div class="col-lg-12 p-0 mx-auto">
            <div class="card card-body mb-32pt">
                <div class="row">
                    <div class="col-lg-4">
                        <h4 class="card-title">Formulario de registro para Nuevo proyecto de tesis</h4>
                        <p style="font-size: 20px;">todos los campos que tienen * son obligatorios para el registro</p>
                    </div>
                    <div class="col-lg-8 d-flex align-items-center">
                        <div  class="flex">

                            <div class="form-group">
                                <label class="form-label" for="name">Nombre Corto*</label>
                                <input wire:model="short_name" type="text" class="form-control" id="short_name">
                                @error('short_name') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                            </div>

                            <!-- Button trigger modal -->
                            <div class="form-group">
                                <button type="button" class="btn btn-warning" data-toggle="modal"
                                data-target="#exampleModalScrollable"
                                title="Primero debes escoger tu Escuela y el Formato de la Tesis" style="padding: 5px 20px;">
                                <b style="font-size: 15px;">Ayuda para crear Título</b>
                                </button>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="title">Título*</label>
                                <textarea wire:model="title" class="form-control" id="title"></textarea>
                                @error('title') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <div wire:ignore>
                                    <label class="form-label" for="country_id">{{ __('labels.Country') }}
                                        *</label>
                                    <select
                                        onclick="deSelectNormative()"
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
                            </div>

                            <div class="form-group">
                                <div wire:ignore>
                                    <label class="form-label">{{ __('labels.University') }}</label>
                                    <select onclick="deSelectNormative()" wire:change="getSchools" wire:model="university_id" class="form-control" id="university_id">
                                        <option value="">Seleccionar</option>
                                        @foreach($universities as $university)
                                            <option value="{{ $university->id }}">{{ $university->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('university_id') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">{{ __('investigation::labels.schools') }}</label>
                                <select onclick="deSelectNormative()" wire:change="getFormat" wire:model="school_id" class="form-control" id="school_id">
                                    <option value="">Seleccionar</option>
                                    @foreach($schools as $school)
                                        <option value="{{ $school->id }}">{{ $school->name }}</option>
                                    @endforeach
                                </select>
                                @error('school_id') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">{{ __('investigation::labels.formats') }}</label>

                                <div class="input-group mb-3">
                                    <div class="dropdown">
                                        <button wire:ignore class="btn btn-orange-border dropdown-toggle" style="border: 2px solid #ff9152;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          Seleccionar Formato
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            @foreach($formats as $format)
                                                <div class="dropdown-item">
                                                    <button onclick="selectionFormat({{ $format }})" type="button" class="btn btn-link">{{ $format->type_thesis.' - '.$format->normative_thesis.' - '.$format->name }}</button>
                                                    @if($format->user_id == auth()->user()->id)
                                                    <button class="btn btn-sm btn-orange ml-2" onclick="openModalEditFormat({{ $format->id }})">Editar</button>
                                                    <button class="btn btn-sm btn-secondary ml-2" onclick="deletesFormatStudent({{ $format->id }})">Eliminar</button>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="input-group-append">
                                        <button onclick="openModalFormatStudentNew()" class="btn btn-secondary" type="button" id="button-addon2">Crear Formato</button>
                                    </div>
                                </div>
                                @error('format_id') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                            </div>


                            <button type="button" wire:click="saveThesisStudent" wire:loading.attr="disabled" wire:target="saveThesisStudent" class="btn btn-orange">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        function deSelectNormative(){
            var btn = document.getElementById('dropdownMenuButton');
            btn.innerHTML = "Seleccionar Formato";
            @this.set('format_id', null);
        }
        function selectionFormat(format){
            var btn = document.getElementById('dropdownMenuButton');
            btn.innerHTML = format.type_thesis+" - "+format.normative_thesis+" - "+format.name;
            @this.set('format_id', format.id);
        }

        window.addEventListener('inve-thesis-student-create', event => {
            cuteAlert({
                type: "success",
                title: event.detail.tit,
                message: event.detail.msg,
                buttonText: "Okay"
            }).then(() => {
                @this.parts();
            });
        })

        window.addEventListener('inve-thesis-student-error', event => {
            cuteAlert({
                type: "error",
                title: event.detail.tit,
                message: event.detail.msg,
                buttonText: "Okay"
            }).then(() => {
                //@this.parts();
            });
        })
        function deletesFormatStudent(id){
            cuteAlert({
                type: "question",
                title: "¿Desea eliminar estos datos?",
                message: "Advertencia:¡Esta acción no se puede deshacer!",
                confirmText: "Okay",
                cancelText: "Cancel"
            }).then((e)=>{
                if ( e == ("confirm")){
                    @this.destroyFormatStudent(id)
                }
            });
        }
        window.addEventListener('inve-part-delete-format-student', event => {
            cuteAlert({
                type: event.detail.res,
                title: event.detail.tit,
                message: event.detail.msg,
                buttonText: "Okay"
            }).then(() => {
                @this.getFormat();
            });
        });
        function reloadFormatStudent(){
            @this.getFormat();
        }
    </script>

    <script>
        document.addEventListener('livewire:load', function() {

            $('#country_id').select2();
            $('#country_id').on('select2:select', function(e) {
                var data = e.params.data;
                @this.country_id = data.id;
            });

            $('#university_id').select2();
            $('#university_id').on('select2:select', function(e) {
                var data = e.params.data;
                @this.university_id = data.id;
                @this.getSchools();
            });
        });
    </script>
</div>
