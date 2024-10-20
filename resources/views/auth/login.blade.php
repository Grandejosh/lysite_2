<x-master>
    <x-slot name="jumbotron">
        <div class="bg-gradient-primary py-32pt">
            <div class="container d-flex flex-column flex-md-row align-items-center text-center text-md-left">
                <img src="assets/images/illustration/student/128/white.svg" class="mr-md-32pt mb-32pt mb-md-0"
                    alt="student">
                <div class="flex mb-32pt mb-md-0">
                    <h1 class="text-white mb-0">{{ __('labels.Log_in') }}</h1>
                    <p class="lead measure-lead text-white-50">{{ __('labels.Enter_your_email_and_password') }}</p>
                </div>
                <a href="{{ route('register') }}" class="btn btn-outline-white flex-column">
                    {{ __('labels.Don\'t_ have_ an_account') }}?
                    <span class="btn__secondary-text">{{ __('labels.Sign_up_Today') }}!</span>
                </a>
            </div>
        </div>
    </x-slot>

    @livewire('auth.login-form')

    <x-slot name="navigation">
        <x-navigation></x-navigation>
    </x-slot>
</x-master>
