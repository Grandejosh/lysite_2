<div class="">
    <div class="container page__container">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME', 'Laravel') }}</a></li>
            <li class="breadcrumb-item active"><a
                    href="{{ route('homepage_histories') }}">{{ __('labels.Instructors') }}</a></li>
            <li class="breadcrumb-item active">{{ __('labels.Edit') }}</li>
            <li class="breadcrumb-item active">{{ $this->name_instructor }}</li>
        </ol>
    </div>
    <div class="container page__container">
        <div class="col-lg-12 p-0 mx-auto">
            <div class="card card-body mb-32pt">
                <div class="row">
                    <div class="col-lg-4">
                        <h4 class="card-title">Edición de Instructor</h4>
                        <p class="text-70">todos los campos que tienen * son obligatorios para el registro</p>
                    </div>
                    <div class="col-lg-8 d-flex align-items-center">

                        <div class="flex">

                            <div class="form-group">
                                <label class="form-label" for="name_instructor">{{ __('labels.Name') }} *</label>
                                <input wire:model.defer="name_instructor" type="text" class="form-control" id="name_instructor"
                                    placeholder="{{ __('labels.Name') }}">
                                @error('name_instructor')
                                    <span class="invalid-feedback-2">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label class="form-label" for="career">{{ __('labels.Career') }} *</label>
                                <input wire:model.defer="career" type="text" class="form-control" id="career"
                                    placeholder="{{ __('labels.Career') }}">
                                @error('career')
                                    <span class="invalid-feedback-2">{{ $message }}</span>
                                @enderror
                            </div>



                            <div class="form-group">
                                <label class="form-label" for="content">{{ __('labels.Content') }} *</label>
                                <div>
                                    <textarea wire:model="content" class="form-control" id="content" rows="10" cols="80"
                                        placeholder="{{ __('labels.Add content about the instructors like achievements, courses, etc') }}">
                                    </textarea>
                                    @error('details')
                                        <span class="invalid-feedback-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <div class="form-group" id="image_path">
                                    <div class="form-group">
                                        <label class="form-label" for="image_path">{{ __('labels.Image') }}
                                            *</label>
                                        <input type="file" wire:model="image_path" id="image_path"
                                            wire:loading.attr="disabled"
                                            accept="image/png, image/jpeg, image/jpg, image/bmp, image/gif">
                                        @error('image_path')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                        @if ($image_path && $image_path_last != $image_path)
                                            {{ __('labels.Photo Preview') }}:

                                            <img class="img-fluid rounded float-right" alt="Responsive image"
                                                style="max-height: 340px; min-height: 200px; width: auto;"
                                                src="{{ $image_path->temporaryUrl() }}">
                                        @else
                                            <img class="img-fluid rounded float-right"
                                                alt="{{ __('labels.Image not available') }}"
                                                style="max-height: 340px; min-height: 200px; width: auto;"
                                                src="{{ env('APP_URL') }}/{{ $image_path }}">
                                        @endif
                                    </div>


                                </div>
                            </div>

                            <button type="button" wire:loading.attr="disabled" wire:click='save'
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
    </script>
</div>
