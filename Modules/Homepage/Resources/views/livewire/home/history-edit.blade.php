<div class="">
    <div class="container page__container">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME', 'Laravel') }}</a></li>
            <li class="breadcrumb-item active"><a
                    href="{{ route('homepage_histories') }}">{{ __('labels.Histories') }}</a></li>
            <li class="breadcrumb-item active">{{ __('labels.Edit') }}</li>
            <li class="breadcrumb-item active">{{ $this->title }}</li>
        </ol>
    </div>
    <div class="container page__container">
        <div class="col-lg-12 p-0 mx-auto">
            <div class="card card-body mb-32pt">
                <div class="row">
                    <div class="col-lg-4">
                        <h4 class="card-title">Edición de una Historia</h4>
                        <p class="text-70">todos los campos que tienen * son obligatorios para el registro</p>
                    </div>
                    <div class="col-lg-8 d-flex align-items-center">

                        <div class="flex">

                            <div class="form-group">
                                <label class="form-label" for="title">{{ __('labels.Title') }} *</label>
                                <input wire:model.defer="title" type="text" class="form-control" id="title"
                                    placeholder="{{ __('labels.Title') }}">
                                @error('title')
                                    <span class="invalid-feedback-2">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="author">{{ __('labels.Author') }} *</label>
                                <input wire:model.defer="author" type="text" class="form-control" id="author"
                                    placeholder="{{ __('labels.Author') }}">
                                @error('author')
                                    <span class="invalid-feedback-2">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="thesis_title">{{ __('labels.Thesis Title') }}
                                    *</label>
                                <input wire:model.defer="thesis_title" type="text" class="form-control"
                                    id="thesis_title" placeholder="{{ __('labels.Thesis Title') }}">
                                @error('thesis_title')
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
                                <label class="form-label" for="university">{{ __('labels.University') }}
                                    *</label>
                                <input wire:model.defer="university" type="text" class="form-control" id="university"
                                    placeholder="{{ __('labels.University Acronym') }}">
                                @error('university')
                                    <span class="invalid-feedback-2">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="year">{{ __('labels.Year') }} *</label>
                                <input wire:model.defer="year" type="number" class="form-control" id="year"
                                    placeholder="{{ __('labels.Year') }}">
                                @error('year')
                                    <span class="invalid-feedback-2">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="month">{{ __('labels.Month') }} *</label>
                                <select wire:model.defer="month" name="month" id="month" type="select"
                                    class="form-control" id="month">
                                    <option value="{{ __('labels.Select') }}">{{ __('labels.Select') }}</option>
                                    <option value="January">{{ __('labels.January') }}</option>
                                    <option value="February">{{ __('labels.February') }}</option>
                                    <option value="March">{{ __('labels.March') }}</option>
                                    <option value="April">{{ __('labels.April') }}</option>
                                    <option value="May">{{ __('labels.May') }}</option>
                                    <option value="June">{{ __('labels.June') }}</option>
                                    <option value="July">{{ __('labels.July') }}</option>
                                    <option value="August">{{ __('labels.August') }}</option>
                                    <option value="September">{{ __('labels.September') }}</option>
                                    <option value="October">{{ __('labels.October') }}</option>
                                    <option value="November">{{ __('labels.November') }}</option>
                                    <option value="December">{{ __('labels.December') }}</option>
                                </select>
                                @error('month')
                                    <span class="invalid-feedback-2">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="details">{{ __('labels.Details') }} *</label>
                                <div>
                                    <textarea wire:model="details" class="form-control" id="details" rows="10" cols="80"
                                        placeholder="{{ __('labels.Write each detail separated by a comma, for example: detail 1, here detail 2, detail 3') }}">
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
