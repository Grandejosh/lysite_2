
<div class="page-section bg-white border-bottom-2">
    <div class="container page__container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h4>{{ __('academic::labels.course_title') }}</h4>
                <div class="form-group">
                    <input wire:model="course_name" type="text" class="form-control form-control-lg">
                    @error('course_name') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                </div>
                <h4>{{ __('academic::labels.description') }}</h4>
                <div class="form-group">
                    <textarea wire:model="course_description" class="form-control" rows="3"></textarea>
                    @error('course_description') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="card m-0">
                    <div class="card-header text-center">
                        <button wire:click="sabeChanges" class="btn btn-accent">{{ __('academic::labels.save_changes') }}</button>
                    </div>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex">
                            <div class="custom-control custom-checkbox">
                                <input wire:model="course_status" class="custom-control-input" type="checkbox" id="invalidCheck01">
                                <label class="custom-control-label" for="invalidCheck01">
                                    {{ __('academic::labels.state') }}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('aca-courses-update', event => {
            cuteAlert({
                type: "success",
                title: event.detail.tit,
                message: event.detail.msg,
                buttonText: "Okay"
            });
        })
    </script>
</div>
