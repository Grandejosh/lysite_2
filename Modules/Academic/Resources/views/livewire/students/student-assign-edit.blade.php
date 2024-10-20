<div class="">
    <div class="container page__container">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME','Laravel') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('academic_courses') }}">{{ __('labels.Courses')}}</a></li>
            <li class="breadcrumb-item active">{{ __('labels.Edit') }}</li>
        </ol>
    </div>
    <div class="container page__container">
        <div class="col-lg-12 p-0 mx-auto">
            <div class="card card-body mb-32pt">
                <div class="row">
                    <div class="col-lg-4">
                        <h4 class="card-title">{{ __('labels.Student') }}: {{ $name }}</h4>
                        <p class="text-70">todos los campos que tienen * son obligatorios para el registro</p>
                    </div>
                    <div class="col-lg-8 d-flex align-items-center">
                        <form wire:submit.prevent="update" class="flex">

                            <div class="form-group">
                                <label class="form-label" for="name">{{ __('labels.Status') }} *</label>
                                <input wire:model="status" type="checkbox" class="form-control" id="status">
                                @error('status') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="name">{{ __('labels.Registered until') }} *</label>
                                <input wire:model="registered_until" type="date" class="form-control" id="registered_until">
                                @error('registered_until') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                            </div>

                            <button type="submit" wire:loading.attr="disabled" wire:target="update" class="btn btn-primary">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('aca-student-edit', event => {
            cuteAlert({
                type: "success",
                title: event.detail.tit,
                message: event.detail.msg,
                buttonText: "Okay"
            });
        })
    </script>
</div>
