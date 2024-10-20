<div class="">
    <div class="container page__container">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME', 'Laravel') }}</a></li>
            <li class="breadcrumb-item active">{{ __('labels.Instructors of Homepage') }}</li>
        </ol>
    </div>
    <div class="container page__container">
        <div class="col-lg-12 p-0 mx-auto">
            <div class="card card-body mb-32pt">
                <div class="row">
                    <div class="col-lg-3">
                        <h4 class="card-title">Listado</h4>
                        <p class="text-70">{{ __('labels.Instructors') }}</p>
                        @can('configuraciones_modulos_nuevo')
                            <a href="{{ route('homepage_instructors_create') }}" type="button"
                                class="btn btn-primary">{{ __('labels.New Instructor') }}</a>
                        @endcan
                    </div>
                    <div class="col-lg-8 d-flex align-items-center">
                        <!-- Wrapper -->
                        <div class="table-responsive" data-toggle="lists" data-lists-values='["name"]'>
                            <!-- Search -->














                            <div class="page-section">
                                <div class="container page__container">
                                    @if (1>2)
                                    <div class="page-headline text-center">
                                        <h2>Feedback</h2>
                                        <p class="lead measure-lead mx-auto text-black-70">What other students turned professionals have to say about us after learning with us and reaching their goals.</p>
                                    </div>
                                    @endif

                                    <div class="position-relative carousel-card">
                                        <div class="row d-block js-mdk-carousel" id="carousel-feedback">
                                            <a class="carousel-control-next js-mdk-carousel-control mt-n24pt" href="#carousel-feedback" role="button" data-slide="next">
                                                <span class="carousel-control-icon material-icons" aria-hidden="true">keyboard_arrow_right</span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                            <div class="mdk-carousel__content">

                                                @foreach ($instructors as $instructor)
                                                <div class="col-12 col-md-6">
                                                    <button onclick="deletes({{ $instructor->id }})" type="button"
                                                        class="btn btn-danger btn-sm">
                                                        <i class="fa fa-trash-alt"></i></button>
                                                    <a href="{{ route('homepage_instructors_edit',['id'=> $instructor->id]) }}" type="button"
                                                        class="btn btn-primary btn-sm">
                                                        <i class="fa fa-pencil-alt"></i></a>
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


















                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function deletes(id) {
            cuteAlert({
                type: "question",
                title: "¿Desea eliminar estos datos?",
                message: "Advertencia:¡Esta acción no se puede deshacer!",
                confirmText: "Okay",
                cancelText: "Cancel"
            }).then((e) => {
                if (e == ("confirm")) {
                    @this.destroy(id)
                }
            });
        }
        window.addEventListener('home-instructors-delete', event => {
            cuteAlert({
                type: event.detail.res,
                title: event.detail.tit,
                message: event.detail.msg,
                buttonText: "Okay"
            }).then((e) => {
                    @this.back();
            });
        })
    </script>
</div>
