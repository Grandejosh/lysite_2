<x-master>
    <x-slot name="jumbotron">
        <div class="py-64pt bg-gradient-primary">
            <div class="container d-flex flex-column flex-md-row align-items-center text-center text-md-left">
                <img src="assets/images/illustration/student/128/white.svg" class="mr-md-32pt mb-32pt mb-md-0" alt="student">
                <div class="flex mb-32pt mb-md-0">
                    <h1 class="text-white mb-8pt">{{ __('labels.signup') }}</h1>
                    <p class="lead measure-lead text-white-50">{{ __('labels.Your thesis is easy to do if you do it with us') }}.</p>
                </div>

            </div>
        </div>
    </x-slot>
    <br>
    <style>
        div.g-recaptcha {
          margin: 0 auto;
          width: 304px;
        }
        </style>

    @livewire('auth.register-form')

    <x-slot name="navigation">
        <x-navigation></x-navigation>
    </x-slot>
</x-master>
