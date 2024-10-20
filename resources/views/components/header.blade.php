@php
    $path = explode('/', request()->path());
@endphp
@if ($path[0] == 'login' || $path[0] == 'register' || $path[0] == 'pricing')
    <div id="header" class="mdk-header bg-dark js-mdk-header mb-0" data-effects="waterfall blend-background" data-fixed
        data-condenses>
        <div class="mdk-header__content">

            <div data-primary class="navbar navbar-expand-sm navbar-dark bg-dark p-0" id="default-navbar">
                <div class="container">

                    <!-- Navbar Brand -->
                    <a href="{{ route('home') }}" class="navbar-brand">
                        <img class="navbar-brand-icon" src="{{ url('assets/images/logo/white-60.png') }}" width="30"
                            alt="{{ env('APP_NAME', 'Laravel') }}">
                        <span class="d-none d-md-block">{{ env('APP_NAME', 'Laravel') }}</span>
                    </a>

                    <!-- Main Navigation -->
                    <ul class="nav navbar-nav ml-auto d-none d-sm-flex">
                        {{-- <li class="nav-item">
                        <a href="pricing.html" class="nav-link">Pricing</a>
                    </li> --}}
                        <li class="nav-item {{ $path[0] == 'register' ? 'active' : '' }}">
                            <a href="{{ route('register') }}" class="nav-link"> {{ __('labels.signup') }}</a>
                        </li>
                        <li class="nav-item {{ $path[0] == 'login' ? 'active' : '' }}">
                            <a href="{{ route('login') }}" class="nav-link">@lang('labels.login')</a>
                        </li>
                    </ul>
                    <!-- // END Main Navigation -->

                    <!-- Navbar toggler -->
                    <button class="navbar-toggler navbar-toggler-right d-block d-md-none" type="button"
                        data-toggle="sidebar">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                </div>
            </div>

        </div>
    </div>
@else
    <div id="header" class="mdk-header bg-dark js-mdk-header mb-0" data-effects="waterfall blend-background"
        data-fixed data-condenses>
        <div class="mdk-header__content">
            <div class="navbar navbar-expand-sm navbar-dark bg-dark pr-0 pr-md-16pt" id="default-navbar" data-primary>
                <!-- Navbar toggler -->
                <button class="navbar-toggler navbar-toggler-right d-block d-md-none" type="button"
                    data-toggle="sidebar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Navbar Brand -->
                <a href="{{ route('home') }}" class="navbar-brand">
                    <img class="navbar-brand-icon mr-0 mr-md-8pt" src="{{ url('assets/images/logo/white-60.png') }}"
                        width="30" alt="{{ env('APP_NAME', 'Laravel') }}">
                    <span class="d-none d-md-block">{{ env('APP_NAME', 'Laravel') }}</span>
                </a>


                <!-- Aquí esta el boton de Cursos_____________________________________________________ -->

                <!-- Main Navigation -->
                <nav class="nav navbar-nav ml-auto flex-nowrap">
                    @if (Auth::check())
                        <style>
                            #courses:hover {
                                color: gray;
                            }
                        </style>

                        @if (auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Instructor'))
                            <div class="nav-item">
                                <div class="dropdown">
                                    <a href="#" class="btn btn-black mr-16pt" data-toggle="dropdown"
                                        aria-expanded="false" id="courses">{{ __('labels.My Courses') }}</a>
                                    <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end"
                                        style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-38px, 44px, 0px);">


                                        @if (count($courses) > 0)
                                            @foreach ($courses as $course)
                                                <a href="{{ route('academic_students_my_course', $course->id) }}"
                                                    class="dropdown-item">
                                                    <span class="media-left mr-16pt">
                                                        <img src="{{ asset($course->course_image) }}" width="30"
                                                            alt="avatar" class="rounded-circle">
                                                    </span>
                                                    <div class="media-body">
                                                        {{ $course->name }}
                                                    </div>
                                                </a>
                                            @endforeach
                                        @else
                                            <a href="{{ route('home') }}" class="dropdown-item">
                                                <span class="media-left mr-16pt">
                                                    <img src="{{ url('assets/images/logo/white-60.png') }}"
                                                        width="30" alt="avatar" class="rounded-circle">
                                                </span>
                                                <div class="media-body">
                                                    {{ __('labels.No courses') }}
                                                </div>
                                            </a>
                                        @endif

                                    </div>
                                </div>
                            </div>
                            <livewire:investigation::thesis.header-investigation />
                        @else
                            @can('academico_directo_tesis')
                                <livewire:investigation::thesis.header-investigation />
                            @endcan
                        @endif
                    @endif

                    @if (Route::has('login'))

                        @auth
                            <div class="nav-item dropdown d-none d-sm-flex ml-16pt">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                                    @if (Auth::user()->avatar)
                                        <img width="32" height="32" class="rounded-circle"
                                            src="{{ url('storage/' . Auth::user()->avatar) }}"
                                            alt="{{ Auth::user()->name }}" />
                                    @else
                                        <img width="32" height="32" class="rounded-circle"
                                            src="{{ ui_avatars_url(Auth::user()->name, 32, 'none') }}"
                                            alt="{{ Auth::user()->name }}" />
                                    @endif
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <div class="dropdown-header"><strong>{{ Auth::user()->name }}</strong></div>
                                    <a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a>
                                    @can('academico_cursos_instructor')
                                        <a class="dropdown-item" href="{{ route('academic_dash_instructor_courses_list') }}">
                                            {{ __('labels.Courses') }}
                                        </a>
                                    @endcan
                                    <div class="dropdown-divider"></div>
                                    <div class="dropdown-header"><strong>{{ __('labels.Account') }}</strong></div>
                                    <a class="dropdown-item" href="{{ route('user_edit_account') }}">
                                        {{ __('labels.Edit Account') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}">Cerrar sesión</a>
                                </div>
                            </div>
                            @livewire('chat::contact-list')
                        @else
                            <div class="ml-16pt nav-item">
                                <a href="{{ route('login') }}" class="nav-link">
                                    <i class="material-icons">lock_open</i>
                                    <span class="sr-only">Login</span>
                                </a>
                            </div>
                            @if (Route::has('register'))
                                <div class="d-none d-sm-flex nav-item">
                                    <a href="{{ route('register') }}" class="btn btn-accent">Registrar</a>
                                </div>
                            @endif
                        @endauth

                        {{-- <div class="d-none d-sm-flex nav-item">
                        <a href="pricing.html" class="btn btn-accent">Get started</a>
                    </div> --}}
                    @endif
                </nav>
                <!-- // END Main Navigation -->
            </div>
        </div>
    </div>


@endif
