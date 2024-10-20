<div class="page-section">
    <div class="container page__container">

        <div class="page-headline text-center">
            <h2>{{ __('labels.Our Instructors') }}</h2>
            <p class="lead measure-lead mx-auto text-black-70">Estos son algunos de nuestros instructores que te ayudarán a lograr tu meta, culminar exitosamente tu tesis, apoyandote en todo momento.</p>
        </div>

        <div class="position-relative carousel-card">
            <div class="row d-block js-mdk-carousel" id="carousel-feedback">
                <a class="carousel-control-next js-mdk-carousel-control mt-n24pt" href="#carousel-feedback" role="button" data-slide="next">
                    <span class="carousel-control-icon material-icons" aria-hidden="true">keyboard_arrow_right</span>
                    <span class="sr-only">Next</span>
                </a>
                <div class="mdk-carousel__content">

                    @foreach ($instructors as $instructor)
                    <div class="col-12 col-md-6">
                        <div class="card card--elevated card-body">
                            <blockquote class="mb-0">
                                <p class="text-70">{{ $instructor->content }}</p>

                                <div class="media">
                                    <div class="media-left">
                                        <img src="{{ env('APP_URL') }}/{{ $instructor->image_path }}" width="40" alt="avatar" class="rounded-circle">
                                    </div>
                                    <div class="media-body media-middle">
                                        <p class="mb-0"><a href="" class="text-body"><strong>{{ $instructor->name_instructor }}</strong></a></p>
                                        <div class="rating">
                                            {{ $instructor->career }}
                                        </div>
                                    </div>
                                </div>
                            </blockquote>
                        </div>
                    </div>
                    @endforeach



                </div>
            </div>
        </div>
    </div>
</div>
