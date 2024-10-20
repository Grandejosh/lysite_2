<div class="container page__container">
    <form wire:submit.prevent="save" >
        <div class="row">
            <div class="col-lg-9">
                <div class="page-section">
                    <h4>{{ __('labels.Privacy of your profile') }}</h4>
                    <div class="list-group list-group-form">
                        <div class="list-group-item">
                            <div class="form-group row mb-0">
                                <label class="col-form-label col-sm-3">{{ __('labels.Your Pic') }}</label>
                                <div class="col-sm-9 media align-items-center">
                                    <a href="" class="media-left mr-16pt">
                                        @if($avatar_show)
                                        <img src="{{ url('storage/'.$avatar_show) }}" alt="people" width="56" class="rounded-circle" />
                                        @else
                                        <img src="{{ url(ui_avatars_url(Auth()->user()->name,56,'none',true)) }}" alt="people" width="56" class="rounded-circle" />
                                        @endif
                                    </a>
                                    <div class="media-body">
                                        <div  wire:ignore>
                                            <input wire:model="avatar" type="file"  id="inputGroupFile01">
                                            {{-- <label  for="inputGroupFile01">Elija el archivo</label> --}}
                                        </div>
                                        @error('avatar') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="form-group row mb-0">
                                <label class="col-form-label col-sm-3">{{ __('labels.Nickname') }}</label>
                                <div class="col-sm-9">
                                    <input wire:model="username" type="text" class="form-control">
                                    @error('username') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="form-group row mb-0">
                                <label class="col-form-label col-sm-3">{{ __('labels.About You') }}</label>
                                <div class="col-sm-9">
                                    <textarea wire:model="description" rows="3" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="custom-control custom-checkbox">
                                <input wire:model="np" type="checkbox" class="custom-control-input-orange" checked id="customCheck1">
                                <label class="custom-control-label" for="customCheck1">{{ __('labels.Show your real name on your profile') }}</label>
                                <small class="form-text text-muted">{{ __('labels.If not checked, your Nickname will be displayed instead of your full name') }}.</small>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="custom-control custom-checkbox">
                                <input wire:model="pp" type="checkbox" class="custom-control-input-orange" checked id="customCheck2">
                                <label class="custom-control-label" for="customCheck2">{{ __('labels.Allow everyone to see your profile') }}</label>
                                <small class="form-text text-muted">{{ __('labels.If it is not checked, your profile will be private and no one except you will be able to see it') }}.</small>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-3 page-nav">
                <div class="page-section pt-lg-112pt">
                    @livewire('user.nav')
                    <div class="page-nav__content">
                        <button type="submit" wire:target="save" wire:loading.attr="disabled" class="btn btn-orange" style="padding: 5px 20px;">{{ __('labels.Save Changes') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script>
        window.addEventListener('set-user-update', event => {
            cuteAlert({
                type: "success",
                title: event.detail.tit,
                message: event.detail.msg,
                buttonText: "Okay"
            });
        });
    </script>
</div>
