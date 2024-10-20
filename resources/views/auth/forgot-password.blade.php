

  <x-master>
    <x-slot name="jumbotron">
        <div class="bg-gradient-primary py-32pt">
            <div class="container d-flex flex-column flex-md-row align-items-center text-center text-md-left">
                <img src="assets/images/illustration/student/128/white.svg" class="mr-md-32pt mb-32pt mb-md-0"
                    alt="student">
                <div class="flex mb-32pt mb-md-0">
                    <h1 class="text-white mb-0">{{ __('labels.Recover password') }}</h1>
                    <p class="lead measure-lead text-white-50">{{ __('labels.We will send you an email so you can reset your password') }}</p>
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
 <form method="POST" action="{{ route('password.email') }}">
     @csrf
     <div class="form-group">
         <label>{{ __('labels.email') }}:</label>
         <input id="email" type="text" class="form-control" name="email" :value="old('email')"
             required autofocus placeholder="{{ __('labels.forgot_your_password?') }} ...">
         <small class="form-text text-muted">{{__('labels.We will send you an email so you can reset your password')}}.</small>
     </div>


     <style>
         div.g-recaptcha {
             margin: 0 auto;
             width: 304px;
         }
     </style>
     <div>
         <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.key')}}"></div>
         <!-- reCaptcha -->
     </div>
     <br />
     <script src="https://www.google.com/recaptcha/api.js" async defer></script>



     <div class="text-center">
         <button class="btn btn-orange btn-lg">{{ __('labels.Email Password Reset Link') }}</button>
     </div>
 </form>



            </div>
        </div>




        <x-slot name="navigation">
            <x-navigation></x-navigation>
        </x-slot>
</x-master>
