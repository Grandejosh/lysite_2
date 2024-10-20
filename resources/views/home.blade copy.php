<x-master>
    <x-slot name="jumbotron">
        <div class="mdk-box mdk-box--bg-gradient-primary bg-dark js-mdk-box position-relative overflow-hidden mb-0"
            data-effects="parallax-background blend-background">
            <div class="mdk-box__bg">
                <div class="mdk-box__bg-front"
                    style="background-image: url(assets/images/1280_work-station-straight-on-view.jpg);"></div>
            </div>
            <div class="mdk-box__content">
                <div class="container page__container py-64pt py-md-112pt">
                    <div class="row align-items-center text-center text-md-left">
                        <div class="col-md-6 col-lg-5 order-1 order-md-0">
                            <h1 class="text-white">{{env('APP_NAME')}} te apoyamos con: <span
                                    class="d-block d-md-inline-block text-scramble js-text-scramble">Tesis</span></h1>
                            <p class="lead mb-32pt mb-lg-48pt text-white">Aprende a hacer tu tesis, hacemos asesorías, simulacros de sustentación y más...</p>
                            <a href="library.html" class="btn btn-lg btn-white btn--raised mb-16pt">Browse Courses</a>
                            <p class="mb-0"><a href="" class="text-white-70 text-underline"><strong>Are you a
                                        teacher?</strong></a></p>
                        </div>
                        <div class="col-md-6 col-lg-7 order-0 order-md-1 text-center mb-32pt mb-md-0">
                            <img src="assets/images/macbook-teal.png" alt="macbook" class="home-macbook">
                        </div>
                    </div>
                </div>
                <!-- <div class="hero container text-center py-112pt">
                    <h1 class="text-white">Learn to Code</h1>
                    <p class="lead measure-hero-lead mx-auto mb-48pt text-white">Business, Technology and Creative Skills taught by industry experts. Explore a wide range of skills with our professional tutorials.</p>
                    <a href="library.html" class="btn btn-lg btn-outline-white">Browse Courses</a>
                </div> -->
            </div>
        </div>
    </x-slot>

    <div class="bg-white border-bottom-2 py-16pt py-sm-24pt py-md-32pt ">
        <div class="container page__container">
            <div class="row align-items-center">
                <div class="d-flex col-md align-items-center border-bottom border-md-0 mb-16pt mb-md-0 pb-16pt pb-md-0">
                    <div
                        class="rounded-circle bg-primary w-64 h-64 d-inline-flex align-items-center justify-content-center mr-16pt">
                        <i class="material-icons text-primary-light">subscriptions</i>
                    </div>
                    <div class="flex">
                        <p class="mb-0"><strong>8,000+ Courses</strong></p>
                        <p class="text-black-70 mb-0">Explore a wide range of skills.</p>
                    </div>
                </div>
                <div class="d-flex col-md align-items-center border-bottom border-md-0 mb-16pt mb-md-0 pb-16pt pb-md-0">
                    <div
                        class="rounded-circle bg-primary w-64 h-64 d-inline-flex align-items-center justify-content-center mr-16pt">
                        <i class="material-icons text-primary-light">verified_user</i>
                    </div>
                    <div class="flex">
                        <p class="mb-0"><strong>By Industry Experts</strong></p>
                        <p class="text-black-70 mb-0">Professional development from the best people.</p>
                    </div>
                </div>
                <div class="d-flex col-md align-items-center">
                    <div
                        class="rounded-circle bg-primary w-64 h-64 d-inline-flex align-items-center justify-content-center mr-16pt">
                        <i class="material-icons text-primary-light">update</i>
                    </div>
                    <div class="flex">
                        <p class="mb-0"><strong>Unlimited Access</strong></p>
                        <p class="text-black-70 mb-0">Unlock Library and learn any topic with one subscription.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-section border-bottom-2">
        <div class="container page__container">


            @livewire('homepage::homepage.histories')


        </div>
    </div>
{{--
    <div class="page-section bg-white border-bottom-2">
        <div class="container page__container">
            <div class="page-headline text-center">
                <h2>Learning Paths</h2>
                <p class="lead text-black-70 measure-lead mx-auto">Stop guessing what to learn next and start making
                    progress faster based on your current skill level and experience.</p>
            </div>

            <div class="row d-block js-mdk-carousel">
                <div class="mdk-carousel__content">


                    <div class="col-12 col-sm-6 col-md-4">

                        <a href="path.html"
                            class="card stack stack--hidden-hover card-featured-path overlay js-overlay">
                            <span class="card-featured-path__content">
                                <span data-position="center" class="js-image" data-height="96">
                                    <img src="assets/images/paths/angular_430x168.png" alt="course">
                                </span>
                                <span class="overlay__content">
                                    <span class="overlay__action card-title mb-0">Angular</span>
                                </span>
                            </span>
                        </a>

                    </div>
                    <div class="col-12 col-sm-6 col-md-4">

                        <a href="path.html"
                            class="card stack stack--hidden-hover card-featured-path overlay js-overlay">
                            <span class="card-featured-path__content">
                                <span data-position="left" class="js-image" data-height="96">
                                    <img src="assets/images/paths/react_430x168.png" alt="course">
                                </span>
                                <span class="overlay__content">
                                    <span class="overlay__action card-title mb-0">React Native</span>
                                </span>
                            </span>
                        </a>

                    </div>
                    <div class="col-12 col-sm-6 col-md-4">

                        <a href="path.html"
                            class="card stack stack--hidden-hover card-featured-path overlay js-overlay">
                            <span class="card-featured-path__content">
                                <span data-position="center" class="js-image" data-height="96">
                                    <img src="assets/images/paths/swift_430x168.png" alt="course">
                                </span>
                                <span class="overlay__content">
                                    <span class="overlay__action card-title mb-0">Swift</span>
                                </span>
                            </span>
                        </a>

                    </div>

                </div>
            </div>

            <div class="row mt-16pt mt-lg-32pt">
                <div class="col-i8-6 col-md-3 mb-16pt">
                    <a href="path.html" class="media">
                        <img src="assets/images/paths/angular_40x40@2x.png" width="40" height="40" alt="Angular"
                            class="media-left rounded">
                        <span class="media-body">
                            <span class="card-title text-body d-block mb-0">Angular</span>
                            <span class="text-muted d-flex lh-1">24 courses</span>
                        </span>
                    </a>
                </div>
                <div class="col-i8-6 col-md-3 mb-16pt">
                    <a href="path.html" class="media">
                        <img src="assets/images/paths/react_40x40@2x.png" width="40" height="40" alt="React Native"
                            class="media-left rounded">
                        <span class="media-body">
                            <span class="card-title text-body d-block mb-0">React Native</span>
                            <span class="text-muted d-flex lh-1">18 courses</span>
                        </span>
                    </a>
                </div>
                <div class="col-i8-6 col-md-3 mb-16pt">
                    <a href="path.html" class="media">
                        <img src="assets/images/paths/swift_40x40@2x.png" width="40" height="40" alt="Swift"
                            class="media-left rounded">
                        <span class="media-body">
                            <span class="card-title text-body d-block mb-0">Swift</span>
                            <span class="text-muted d-flex lh-1">22 courses</span>
                        </span>
                    </a>
                </div>
                <div class="col-i8-6 col-md-3 mb-16pt">
                    <a href="path.html" class="media">
                        <img src="assets/images/paths/wordpress_40x40@2x.png" width="40" height="40" alt="WordPress"
                            class="media-left rounded">
                        <span class="media-body">
                            <span class="card-title text-body d-block mb-0">WordPress</span>
                            <span class="text-muted d-flex lh-1">13 courses</span>
                        </span>
                    </a>
                </div>
                <div class="col-i8-6 col-md-3 mb-16pt">
                    <a href="path.html" class="media">
                        <img src="assets/images/paths/swift_40x40@2x.png" width="40" height="40" alt="Swift"
                            class="media-left rounded">
                        <span class="media-body">
                            <span class="card-title text-body d-block mb-0">Swift</span>
                            <span class="text-muted d-flex lh-1">22 courses</span>
                        </span>
                    </a>
                </div>
                <div class="col-i8-6 col-md-3 mb-16pt">
                    <a href="path.html" class="media">
                        <img src="assets/images/paths/wordpress_40x40@2x.png" width="40" height="40" alt="WordPress"
                            class="media-left rounded">
                        <span class="media-body">
                            <span class="card-title text-body d-block mb-0">WordPress</span>
                            <span class="text-muted d-flex lh-1">13 courses</span>
                        </span>
                    </a>
                </div>
                <div class="col-i8-6 col-md-3 mb-16pt">
                    <a href="path.html" class="media">
                        <img src="assets/images/paths/devops_40x40@2x.png" width="40" height="40"
                            alt="Development Tools" class="media-left rounded">
                        <span class="media-body">
                            <span class="card-title text-body d-block mb-0">Development Tools</span>
                            <span class="text-muted d-flex lh-1">5 courses</span>
                        </span>
                    </a>
                </div>
                <div class="col-i8-6 col-md-3 mb-16pt">
                    <a href="path.html" class="media">
                        <img src="assets/images/paths/react_40x40@2x.png" width="40" height="40" alt="React Native"
                            class="media-left rounded">
                        <span class="media-body">
                            <span class="card-title text-body d-block mb-0">React Native</span>
                            <span class="text-muted d-flex lh-1">18 courses</span>
                        </span>
                    </a>
                </div>
            </div>

            <div class="pt-8pt pt-md-32pt text-center">
                <a href="paths.html" class="btn btn-outline-secondary">Browse Learning Paths</a>
            </div>
        </div>
    </div> --}}

    <div class="page-section">

        @livewire('homepage::homepage.instructors')

    </div>




    <x-slot name="navigation">
        <x-navigation></x-navigation>
    </x-slot>
</x-master>
