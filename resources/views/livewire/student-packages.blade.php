<div class="container page__container" style="margin-bottom: 40px">
    <div class="page-headline text-center">
        <h2>Modulos Disponibles</h2>
        <p class="lead text-black-70 measure-lead mx-auto">Con nuestros módulos, podrás potenciar tu aprendizaje y llevar
            a cabo tus proyectos de investigación de manera ágil y eficiente.</p>
    </div>
    <div class="row">

        @if (auth()->user()->hasRole('Admin') ||
                auth()->user()->hasRole('Instructor'))
            <div class="col-12 col-sm-6 col-md-4">
                <a href="{{ route('help_gpt') }}"
                    class="card stack stack--hidden-hover card-featured-path overlay js-overlay">
                    <span class="card-featured-path__content">
                        <span data-position="center" class="js-image" data-height="250">
                            <img src="/img/asistente-virtual.png" alt="CONSULTAS IA">
                        </span>
                        <span class="overlay__content">
                            <span class="overlay__action card-title mb-0">CONSULTAS IA</span>
                        </span>
                    </span>
                </a>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <a href="{{ route('dashboard_courses') }}"
                    class="card stack stack--hidden-hover card-featured-path overlay js-overlay">
                    <span class="card-featured-path__content">
                        <span data-position="left" class="js-image" data-height="250">
                            <img src="/img/ensenando.png" alt="CURSOS">
                        </span>
                        <span class="overlay__content">
                            <span class="overlay__action card-title mb-0">CURSOS</span>
                        </span>
                    </span>
                </a>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <a href="{{ route('investigation_thesis_all') }}"
                    class="card stack stack--hidden-hover card-featured-path overlay js-overlay">
                    <span class="card-featured-path__content">
                        <span data-position="center" class="js-image" data-height="250">
                            <img src="/img/graduacion.png" alt="TESIS">
                        </span>
                        <span class="overlay__content">
                            <span class="overlay__action card-title mb-0">TESIS</span>
                        </span>
                    </span>
                </a>
            </div>
        @else
            @can('academico_directo_gpt')
                <div class="col-12 col-sm-6 col-md-4">
                    <a href="{{ route('help_gpt') }}"
                        class="card stack stack--hidden-hover card-featured-path overlay js-overlay">
                        <span class="card-featured-path__content">
                            <span data-position="center" class="js-image" data-height="250">
                                <img src="/img/asistente-virtual.png" alt="CONSULTAS IA">
                            </span>
                            <span class="overlay__content">
                                <span class="overlay__action card-title mb-0">CONSULTAS IA</span>
                            </span>
                        </span>
                    </a>
                </div>
            @else
                <div class="col-12 col-sm-6 col-md-4">
                    <a href="#" title="Consultar con el Administrador"
                        class="card stack stack--hidden-hover card-featured-path overlay js-overlay">
                        <span class="card-featured-path__content">
                            <span data-position="center" class="js-image" data-height="250">
                                <img src="/img/asistente-virtual.png" alt="CONSULTAS IA">
                            </span>
                            <span class="overlay__content">
                                <span class="overlay__action card-title mb-0">CONSULTAS IA</span>
                            </span>
                        </span>
                    </a>
                </div>
            @endcan
            @can('academico_directo_cursos')
                <div class="col-12 col-sm-6 col-md-4">
                    <a href="{{ route('dashboard_courses') }}"
                        class="card stack stack--hidden-hover card-featured-path overlay js-overlay">
                        <span class="card-featured-path__content">
                            <span data-position="left" class="js-image" data-height="250">
                                <img src="/img/ensenando.png" alt="CURSOS">
                            </span>
                            <span class="overlay__content">
                                <span class="overlay__action card-title mb-0">CURSOS</span>
                            </span>
                        </span>
                    </a>
                </div>
            @else
                <div class="col-12 col-sm-6 col-md-4">
                    <a href="#" title="Consultar con el Administrador"
                        class="card stack stack--hidden-hover card-featured-path overlay js-overlay">
                        <span class="card-featured-path__content">
                            <span data-position="left" class="js-image" data-height="250">
                                <img src="/img/ensenando.png" alt="CURSOS">
                            </span>
                            <span class="overlay__content">
                                <span class="overlay__action card-title mb-0">CURSOS</span>
                            </span>
                        </span>
                    </a>
                </div>
            @endcan
            @can('academico_directo_tesis')
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="card stack stack--hidden-hover card-featured-path overlay js-overlay">
                        <span class="card-featured-path__content">
                            <span data-position="center" class="js-image" data-height="250">
                                <img src="/img/graduacion.png" alt="TESIS">
                            </span>
                            <span class="overlay__content" style="pointer-events: all !important">
                                <span class="overlay__action card-title mb-0">TESIS</span>
                                <ul class="overlay__action">
                                    @if (count($pathesis) > 0)
                                        @foreach ($pathesis as $item)
                                            <li class="text-white"><a class="text-white"
                                                    href="{{ route('investigation_thesis_parts', $item->id) }}">{{ $item->short_name }}</a>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </span>
                        </span>
                    </div>
                </div>
            @else
                <div class="col-12 col-sm-6 col-md-4">
                    <a href="#" title="Consultar con el Administrador"
                        class="card stack stack--hidden-hover card-featured-path overlay js-overlay">
                        <span class="card-featured-path__content">
                            <span data-position="left" class="js-image" data-height="250">
                                <img src="/img/graduacion.png" alt="TESIS">
                            </span>
                            <span class="overlay__content">
                                <span class="overlay__action card-title mb-0">TESIS</span>
                            </span>
                        </span>
                    </a>
                </div>
            @endcan
        @endif
    </div>
</div>
