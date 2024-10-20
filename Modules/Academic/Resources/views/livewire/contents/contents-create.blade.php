<div class="">
    <div class="container page__container">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME','Laravel') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('academic_courses') }}">{{ __('academic::labels.courses')
                    }}</a></li>
            <li class="breadcrumb-item">{{ $course->name }}</li>
            <li class="breadcrumb-item active"><a href="{{ route('academic_sections',$course->id) }}">{{
                    __('academic::labels.sections') }}</a></li>
            <li class="breadcrumb-item">{{ $section->title }}</li>
            <li class="breadcrumb-item active">{{ __('labels.Contents') }}</li>
        </ol>
    </div>
    <div class="container page__container">
        <div class="col-lg-12 p-0 mx-auto">
            <div class="card card-body mb-32pt">
                <div class="row">
                    <div class="col-lg-4">
                        <h4 class="card-title">Registro de un Nuevo Contenido</h4>
                        <p class="text-70">todos los campos que tienen * son obligatorios para el registro</p>
                    </div>
                    <div class="col-lg-8 d-flex align-items-center" wire:ignore.self>

                        <div class="flex">

                            <div class="form-group">
                                <label class="form-label" for="content_type_id">{{ __('labels.Content Type') }}
                                    *</label>
                                <select wire:model.defer="content_type_id" type="select" class="form-control"
                                    id="content_type_id" onchange="selectType(event)">
                                    <option value="">Seleccionar</option>
                                    @foreach ($content_types as $types)
                                    <option value="{{ $types->id }}">{{ $types->name }}</option>

                                    @endforeach
                                </select>
                                @error('content_type_id')
                                <span class="invalid-feedback-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="name">{{ __('labels.Name') }} *</label>
                                <input wire:model.defer="name" type="text" class="form-control" id="name"
                                    placeholder="{{ __('labels.Name') }}">
                                @error('name') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                            </div>
                            <div>

                                <div class="form-group" style="display: none" id="txturl" wire:ignore>
                                    <label class="form-label" for="txturl">URL *</label>
                                    <input wire:model="txturl" type="text" class="form-control" id="content_url"
                                        placeholder="{{ __('labels.enter the video link here (youtube, vimeo, etc)') }}">
                                    @error('content_url') <span class="invalid-feedback-2">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group" style="display: none" id="txttexto" wire:ignore>
                                    <label class="form-label" for="txttexto">Texto *</label>
                                    <div>
                                        <textarea wire:model="txttexto" class="form-control" id="editor" rows="10"
                                            cols="80"></textarea>
                                        @error('content_url') <span class="invalid-feedback-2">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group" style="display: none" id="txtarchivo" wire:ignore
                                    x-data="{ isUploading: false, progress: 0 }"
                                    x-on:livewire-upload-start="isUploading = true"
                                    x-on:livewire-upload-finish="isUploading = false"
                                    x-on:livewire-upload-error="isUploading = false"
                                    x-on:livewire-upload-progress="progress = $event.detail.progress">
                                    <label class="form-label" for="txtarchivo">Archivo *</label>
                                    <input type="file" wire:model="txtarchivo"
                                        accept=".pdf,.doc ,.docx,.xls,.xlsx,.ppt,.pptx,.txt">
                                    @error('content_url') <span class="error">{{ $message }}</span> @enderror
                                    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.10.5/cdn.min.js"
                                        integrity="sha512-y22y4rJ9d7NGoRLII5LVwUv0BfQKf6MpATy5ebVu/fbHdtJCxBpZRHZMHJv8VYl8scWjuwZcMPzwYk4sEoyL4A=="
                                        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

                                    <div x-show="isUploading">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="sr-only">Cargando...</span>
                                        </div>
                                        <progress max="100" x-bind:value="progress"></progress>

                                    </div>
                                </div>

                                <div class="form-group" style="display: none" id="txtimage" wire:ignore.self
                                    x-data="{ isUploading: false, progress: 0 }"
                                    x-on:livewire-upload-start="isUploading = true"
                                    x-on:livewire-upload-finish="isUploading = false"
                                    x-on:livewire-upload-error="isUploading = false"
                                    x-on:livewire-upload-progress="progress = $event.detail.progress">
                                    <label class="form-label" for="txtimage">Imagen *</label>
                                    @if ($txtimage)

                                    {{ __('labels.Photo Preview') }}:

                                    <img class="img-fluid rounded float-right" alt="Responsive image"
                                        src="{{ $txtimage->temporaryUrl() }}">

                                    @endif
                                    <input type="file" wire:model="txtimage"
                                        accept="image/png, image/jpeg, image/jpg, image/bmp, image/gif">
                                    @error('content_url') <span class="error">{{ $message }}</span> @enderror
                                    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.10.5/cdn.min.js"
                                        integrity="sha512-y22y4rJ9d7NGoRLII5LVwUv0BfQKf6MpATy5ebVu/fbHdtJCxBpZRHZMHJv8VYl8scWjuwZcMPzwYk4sEoyL4A=="
                                        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

                                    <div x-show="isUploading">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="sr-only">Cargando...</span>
                                        </div>
                                        <progress max="100" x-bind:value="progress"></progress>

                                    </div>
                                </div>
                            </div>
                            <button type="button" wire:loading.attr="disabled" wire:target="save,txtimage, txtarchivo" wire:click='save'
                                class="btn btn-primary">Guardar</button>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('aca-content-create', event => {
            cuteAlert({
                type: "success",
                title: event.detail.tit,
                message: event.detail.msg,
                buttonText: "Okay"
            }).then(() => {
                @this.back();
            });
        })

        function selectType(e){
            let t = e.target.value;

            if(t == 1){
                document.getElementById('txturl').style.display = 'block';
                document.getElementById('txttexto').style.display = 'none';
                document.getElementById('txtarchivo').style.display = 'none';
                document.getElementById('txtimage').style.display = 'none';
            }
            if(t == 2){
                document.getElementById('txturl').style.display = 'none';
                document.getElementById('txttexto').style.display = 'block';
                document.getElementById('txtarchivo').style.display = 'none';
                document.getElementById('txtimage').style.display = 'none';
            }
            if(t == 3){
                document.getElementById('txturl').style.display = 'none';
                document.getElementById('txttexto').style.display = 'none';
                document.getElementById('txtarchivo').style.display = 'block';
                document.getElementById('txtimage').style.display = 'none';
            }
            if(t == 4){
                document.getElementById('txturl').style.display = 'none';
                document.getElementById('txttexto').style.display = 'none';
                document.getElementById('txtarchivo').style.display = 'none';
                document.getElementById('txtimage').style.display = 'block';
            }
        }
        function setDataText(data){
            @this.set('txttexto',data);
        }
    </script>
</div>
