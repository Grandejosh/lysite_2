<div>
    <div class="bg-white pt-32pt pt-sm-64pt pb-32pt">
        <div class="container page__container">
            <form  class="col-md-5 p-0 mx-auto">
                <div class="form-group">
                    <label for="email">{{ __('labels.email') }}:</label>
                    <input wire:model="email" id="email" type="text" class="form-control" placeholder="{{ __('labels.Your_email') }} ...">
                    @error('email') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="password">{{ __('labels.Password') }}:</label>
                    <input wire:model="password" wire:keydown.enter="login" id="password" type="password" class="form-control" placeholder="{{ __('labels.Your_password') }} ...">
                    @error('password') <span class="text-danger error">{{ $message }}</span>@enderror
                    <p class="text-right"><a href="{{ route('password.request') }}" class="small">{{ __('labels.forgot_your_password?') }}</a></p>
                </div>
                @if (session()->has('message'))
                <div class="alert alert-danger" role="alert">
                    {{ session('message') }}
                </div>
                @endif
                <div class="text-center">
                    <button wire:click="login" type="button" class="btn btn-lg btn-accent">{{ __('labels.login') }}</button>
                </div>
            </form>
        </div>
    </div>
    {{-- <div class="page-separator m-0">
        <div class="page-separator__text">o inicia sesión con</div>
        <div class="page-separator__bg-top bg-white"></div>
    </div>
    <div class="bg-body pt-32pt pb-32pt pb-md-64pt text-center">
        <div class="container page__container">
            <a href="student-dashboard.html" class="btn btn-lg btn-secondary btn-block-xs">Facebook</a>
            <a href="student-dashboard.html" class="btn btn-lg btn-secondary btn-block-xs">Twitter</a>
            <a href="student-dashboard.html" class="btn btn-lg btn-secondary btn-block-xs">Google+</a>
        </div>
    </div> --}}
</div>
