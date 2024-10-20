<x-master>
    <x-slot name="jumbotron">
        <div class="bg-gradient-primary py-32pt">
            <div class="container d-flex flex-column flex-md-row align-items-center text-center text-md-left">
                <img src="assets/images/illustration/student/128/white.svg" class="mr-md-32pt mb-32pt mb-md-0"
                    alt="student">
                <div class="flex mb-32pt mb-md-0">
                    <h1 class="text-white mb-0">{{ __('labels.Recover password') }}</h1>
                    <p class="lead measure-lead text-white-50">{{ __('labels.Enter your new password') }}</p>
                </div>
                <a href="{{ route('register') }}" class="btn btn-outline-white flex-column">
                    {{ __('labels.Don\'t_ have_ an_account') }}?
                    <span class="btn__secondary-text">{{ __('labels.Sign_up_Today') }}!</span>
                </a>
            </div>
        </div>

        <div class="page-section bg-white">
            <div class="container page__container">
                <!-- Session Status -->
                <x-auth-session-status class="mb-4 text-center" :status="session('status')" />

                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4 text-center" :errors="$errors" />

                <form method="POST" action="{{ route('password.update') }}" class="col-sm-5 mx-auto">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="form-group">


                        <x-input id="email" class="form-control" type="hidden" name="email"
                            :value="old('email', $request->email)" required  />
                    </div>
                    <div class="form-group">
                        <label for="password">{{ __('labels.Password') }}:</label>
                        <input id="password" type="password" class="form-control" name="password"
                            placeholder="{{ __('labels.Enter your new password') }} ..." autofocus>
                    </div>
                    <div class="form-group">
                        <label for="password">Confirme su Contraseña:</label>
                        <input id="password_confirmation" type="password" class="form-control"
                            name="password_confirmation" placeholder="{{ __('labels.Confirm your new password') }} ...">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-accent btn-lg">{{ __('labels.Reset Password') }}</button>
                    </div>
                </form>
            </div>
        </div>




        <x-slot name="navigation">
            <x-navigation></x-navigation>
        </x-slot>
</x-master>
