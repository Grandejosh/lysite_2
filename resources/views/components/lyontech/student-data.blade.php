<!--<div class="mdk-box bg-dark mdk-box--bg-gradient-primary js-mdk-box mb-0" data-effects="blend-background">-->
<div class="mdk-box js-mdk-box mb-0" data-effects="blend-background" style="background-color: #ff9152;">
    <div class="mdk-box__content" style="padding: 60px 0px 0px 0px;">
        <div class="hero mod-orange py-48pt text-center text-sm-left" style="padding: 10px;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-md-offset-3">
                        <div class="media">
                            <div class="image-container">
                                <img src="{{ asset('theme-lyontech/images/user-orange.jpg') }}"
                                    class="align-self-end  b-img-fluid" alt="Card image cap" width="120">
                            </div>
                            <div class="media-body text-container align-self-center">
                                <h2 class="text-white" style="margin-top: 30px;">{{ auth()->user()->name }}</h2>
                                <p class="lead text-white-50" style="margin-top: -25px;">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--edy-->
        <div style="background-color: #ffb890; padding: 10px;">
            <div class="container page__container text-center">
                <div class="row">
                    <div class="col-md-12">
                        <b style="font-weight: 700;">Aumenta tus oportunidades:</b>&nbsp; Únete a premium. &nbsp;&nbsp;<a
                            href="{{ route('modo_page') }}" class="btn-border-black">Mejora</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
