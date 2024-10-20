<div class="">
    <div class="container page__container">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME','Laravel') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('academic_courses') }}">{{ __('academic::labels.courses') }}</a></li>
            <li class="breadcrumb-item">{{ $course->name }}</li>
            <li class="breadcrumb-item"><a href="{{ route('academic_sections',$course_id) }}">{{ __('academic::labels.sections') }}</a></li>
            <li class="breadcrumb-item active">{{ __('academic::labels.new') }}</li>
        </ol>
    </div>
    <div class="container page__container">
        <div class="col-lg-12 p-0 mx-auto">
            <div class="card card-body mb-32pt">
                <div class="row">
                    <div class="col-lg-4">
                        <h4 class="card-title">Formulario de registro</h4>
                        <p class="text-70">todos los campos que tienen * son obligatorios para el registro</p>
                    </div>
                    <div class="col-lg-8 d-flex align-items-center">
                        <form wire:submit.prevent="save" class="flex">

                            <div class="form-group">
                                <label class="form-label" for="title">{{ __('academic::labels.title') }} *</label>
                                <input wire:model="title" type="text" class="form-control" id="title">
                                @error('title') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="name">Descripcion </label>
                                <textarea wire:model="description" class="form-control" id="description"></textarea>
                                @error('description') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input wire:model="status" class="custom-control-input" type="checkbox" value="" id="invalidCheck01" >
                                    <label class="custom-control-label" for="invalidCheck01">
                                        Estado
                                    </label>
                                </div>
                            </div>
                            <button type="submit" wire:loading.attr="disabled" wire:target="save" class="btn btn-primary">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('aca-sections-create', event => {
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
