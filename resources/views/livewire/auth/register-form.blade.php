<div>
    {{-- <div class="py-32pt navbar-submenu">
        <div class="container page__container">
            <div class="progression-bar progression-bar--active-accent">
                <a href="pricing.html" class="progression-bar__item progression-bar__item--complete">
                    <span class="progression-bar__item-content">
                        <i class="material-icons progression-bar__item-icon">done</i>
                        <span class="progression-bar__item-text h5 mb-0 text-uppercase">Pricing</span>
                    </span>
                </a>
                <a href="signup.html"
                    class="progression-bar__item progression-bar__item--complete progression-bar__item--active">
                    <span class="progression-bar__item-content">
                        <i class="material-icons progression-bar__item-icon"></i>
                        <span class="progression-bar__item-text h5 mb-0 text-uppercase">Account details</span>
                    </span>
                </a>
                <a href="signup-payment.html" class="progression-bar__item">
                    <span class="progression-bar__item-content">
                        <i class="material-icons progression-bar__item-icon"></i>
                        <span class="progression-bar__item-text h5 mb-0 text-uppercase">Payment details</span>
                    </span>
                </a>
            </div>
        </div>
    </div> --}}

    <div class="bg-white py-32pt py-lg-64pt">
        <div class="container page__container">
            <div class="col-lg-5 p-0 mx-auto">
                <div class="row">
                    <div class="col-md-12 mb-24pt mb-md-0">
                        <form wire:submit.prevent="save">
                            <div class="form-group">
                                <label for="name">{{ __('labels.Your full name') }}:</label>
                                <input wire:model="full_name" id="name" type="text" class="form-control"
                                    placeholder="{{ __('labels.Your full name') }} ...">
                            </div>
                            <div class="form-group">
                                <label for="email">{{ __('labels.Your_email') }}:</label>
                                <input wire:model="email" id="email" type="email" class="form-control"
                                    placeholder="{{ __('labels.Your_email') }} ...">
                                @error('email') <span class="error">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group mb-24pt">
                                <label for="password">{{ __('labels.Password') }}:</label>
                                <input wire:model="password" id="password" type="password" class="form-control"
                                    placeholder="{{ __('labels.Your Password') }} ...">
                                @error('password') <span class="error">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group mb-24pt">
                                <label for="repeat_password">{{ __('labels.Repeat password') }}:</label>
                                <input wire:model="repeat_password" id="repeat_password" type="password" class="form-control"
                                    placeholder="{{ __('labels.Your Password') }} ...">
                                @error('repeat_password') <span class="error">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label for="telephone">{{ __('labels.Telephone') }}:({{ __('labels.optional') }})</label>
                                <input wire:model="telephone" id="telephone" type="tel" class="form-control"
                                    placeholder="{{ __('labels.write your phone number if you want us to contact you') }} ...">
                            </div>

                            <button wire.loading@disabled(true) class="btn btn-lg btn-accent">
                                {{ __('labels.signup') }}</button>
                        </form>
                    </div>

                    {{-- <div class="col-md-6">
                        <div class="card mb-0">
                            <div class="card-body">
                                <h5>Purchase summary</h5>
                                <div class="d-flex mb-8pt">
                                    <div class="flex"><strong class="text-70">Subscription</strong></div>
                                    <strong>Student</strong>
                                </div>
                                <div class="d-flex mb-16pt pb-16pt border-bottom">
                                    <span class="material-icons text-muted mr-8pt">check</span>
                                    <span class="text-70">Access to over 1.000 high quality courses. For
                                        individuals.</span>
                                </div>
                                <div class="d-flex mb-16pt pb-16pt border-bottom">
                                    <div class="flex"><strong class="text-70">Price</strong></div>
                                    <strong>US &dollar;9 per month</strong>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" checked id="topic-all">
                                    <label class="custom-control-label">Terms and conditions</label>
                                    <small class="form-text text-muted">By checking here and continuing, I agree to the
                                        Tutorio Terms of Use</small>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="page-separator m-0">
        <div class="page-separator__text">or sign-in with</div>
        <div class="page-separator__bg-top bg-white"></div>
    </div>
    <div class="bg-body pt-32pt pb-32pt pb-md-64pt text-center">
        <div class="container page__container">
            <a href="signup-payment.html" class="btn btn-lg btn-secondary btn-block-xs">Facebook</a>
            <a href="signup-payment.html" class="btn btn-lg btn-secondary btn-block-xs">Twitter</a>
            <a href="signup-payment.html" class="btn btn-lg btn-secondary btn-block-xs">Google+</a>
        </div>
    </div> --}}
</div>
