<div class="">
    <div class="container page__container">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME','Laravel') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('academic_courses') }}">{{ __('academic::labels.courses') }}</a></li>
            <li class="breadcrumb-item">{{ $course->name }}</li>
            <li class="breadcrumb-item active"><a href="{{ route('academic_sections',$course->id) }}">{{ __('academic::labels.sections') }}</a></li>
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
                    <div class="col-lg-8 d-flex align-items-center">
                        <form  wire:submit.prevent="save" class="flex">

                            <div class="form-group">
                                <label class="form-label" for="content_type_id">{{ __('labels.Content Type') }}
                                    *</label>
                                <select
                                    wire:model.defer="content_type_id"
                                    type="select"
                                    class="form-control"
                                    id="content_type_id"
                                    disabled
                                >
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

                                <div class="form-group" style="display: {{ $content_type_id == 1 ? 'block' : 'none' }}" id="txturl" wire:ignore>
                                    <label class="form-label" for="txturl">URL *</label>
                                    <input wire:model="txturl" type="text" class="form-control" id="content_url"
                                        placeholder="{{ __('labels.enter the video link here (youtube, vimeo, etc)') }}">
                                    @error('content_url') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group" style="display: {{ $content_type_id == 2 ? 'block' : 'none' }}" id="txttexto" wire:ignore>
                                    <label class="form-label" for="txttexto">Texto *</label>
                                    <div>
                                        <textarea  class="form-control" id="editor"
                                            rows="10" cols="80">{!! $txttexto !!}</textarea>
                                        @error('content_url') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="form-group" style="display: {{ $content_type_id == 3 ? 'block' : 'none' }}" id="txtarchivo" wire:ignore>
                                    <label class="form-label" for="txtarchivo">Archivo *</label>
                                    <input type="file" wire:model="txtarchivo"
                                        accept=".pdf,.doc ,.docx,.xls,.xlsx,.ppt,.pptx,.txt">
                                    @error('content_url') <span class="error">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group" style="display: {{ $content_type_id == 4 ? 'block' : 'none' }}" id="txtimage" wire:ignore.self>
                                    <label class="form-label" for="txtimage">Imagen *</label>
                                    @if ($txtimage && ($this->txtimage_last != $this->txtimage))
                                    {{ __('labels.Photo Preview') }}:

                                <img class="img-fluid rounded float-right" alt="Responsive image"
                                    src="{{ $txtimage->temporaryUrl() }}">
                                    @else
                                        {{ __('labels.Photo Preview') }}:
                                        <img class="img-fluid rounded float-right" alt="Responsive image" src="{{ env('APP_URL') }}/{{ $txtimage }}">
                                    @endif
                                    <input type="file" wire:model="txtimage" accept="image/png, image/jpeg, image/jpg, image/bmp, image/gif">
                                    @error('content_url') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <button type="button" wire:loading.attr="disabled" wire:target="save,txtimage, txtarchivo" wire:click="save"class="btn btn-primary">Guardar</button>

                        </div>

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
            }).then(() => {
                @this.back();
            });
        })

        function setDataText(data){
            @this.set('txttexto',data);
        }
    </script>
</div>

