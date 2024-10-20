<div class="">
    <div class="container page__container">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME','Laravel') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('academic_courses') }}">{{ __('labels.Courses')}}</a></li>
            <li class="breadcrumb-item active">{{ __('labels.New') }}</li>
        </ol>
    </div>
    <div class="container page__container">
        <div class="col-lg-12 p-0 mx-auto">
            <div class="card card-body mb-32pt">
                <div class="row">
                    <div class="col-lg-4">
                        <h4 class="card-title">Formulario de registro para Nuevo Curso</h4>
                        <p class="text-70">todos los campos que tienen * son obligatorios para el registro</p>
                    </div>
                    <div class="col-lg-8 d-flex align-items-center">
                        <form wire:submit.prevent="save" class="flex">

                            <div class="form-group">
                                <label class="form-label" for="name">Nombre *</label>
                                <input wire:model="name" type="text" class="form-control" id="name">
                                @error('name') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="name">Descripción *</label>
                                <textarea wire:model="description" class="form-control" id="description"></textarea>
                                @error('description') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="main_video">{{ __('labels.Url').' '.__('labels.Main
                                    Video') }} *</label>
                                <input wire:model="main_video" type="text" class="form-control" id="main_video" required>
                                @error('main_video') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group" x-data="{ isUploading: false, progress: 0 }"
                                x-on:livewire-upload-start="isUploading = true"
                                x-on:livewire-upload-finish="isUploading = false"
                                x-on:livewire-upload-error="isUploading = false"
                                x-on:livewire-upload-progress="progress = $event.detail.progress">

                                <label class="form-label" for="name">{{ __('labels.Course Picture') }}</label>
                                @if ($course_image)

                                {{ __('labels.Photo Preview') }}:

                                <img class="img-fluid rounded float-right" alt="Responsive image"
                                    src="{{ $course_image->temporaryUrl() }}">

                                @endif
                                <input type="file" wire:model="course_image"
                                    accept="image/png, image/jpeg, image/jpg, image/bmp, image/gif">
                                @error('course_image') <span class="error">{{ $message }}</span> @enderror

                                <!-- Progress Bar -->
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

                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input wire:model="status" class="custom-control-input" type="checkbox" value=""
                                        id="invalidCheck01">
                                    <label class="custom-control-label" for="invalidCheck01">
                                        Estado
                                    </label>
                                </div>
                            </div>

                                <button type="submit" wire:loading.attr="disabled" wire:target="save,course_image"
                                    class="btn btn-primary">Guardar</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('aca-courses-create', event => {
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
