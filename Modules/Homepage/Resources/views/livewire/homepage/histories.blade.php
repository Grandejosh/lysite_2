<div>
    <div class="page-headline text-center">

        <h2>{{ __('labels.Our Success Histories') }}</h2>
        <p class="lead text-black-70 measure-lead mx-auto">Proyectos de investigación, tesis para grado, maestrías, doctorados,
            te apoyamos en desarrollar tu proyecto, contamos con curso online de tesis junto a nuestro sistema de desarrollo asistido de tesis.</p>
    </div>
    <div class="row">
        @foreach ($histories as $key => $history)
            <div class="col-sm-6 col-md-4 col-lg-4">

                <div class="card card--elevated card-course overlay js-overlay mdk-reveal js-mdk-reveal "
                    data-partial-height="40" data-toggle="popover" data-trigger="click">



                    <img src="{{ env('APP_URL') }}/{{ $history->image_path }}" alt="course" style="height: 170px;">
                    <span class="overlay__content">
                        <span class="overlay__action d-flex flex-column text-center">
                            <i class="material-icons"><i class="fa fa-university" aria-hidden="true"></i></i>
                        </span>

                    </span>


                    <span
                        class="corner-ribbon corner-ribbon--default-right-top corner-ribbon--shadow bg-accent text-white">{{ $history->university }}</span>

                    <div class="mdk-reveal__content">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex">
                                    <b class="card-title">{{ $history->title }}</b>
                                    <small
                                        class="text-50 font-weight-bold mb-4pt">{{ __('labels.Institution') }}:
                                        {{ $history->university }}</small>
                                </div>

                            </div>
                            <div class="d-flex">
                                <small class="text-50">{{ $history->year }}</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="popoverContainer d-none">
                    <div class="media">
                        <div class="media-left">
                            <img src="{{ env('APP_URL') }}/{{ $history->image_path }}" width="40"
                                height="40" alt="Image" class="rounded">
                        </div>
                        <div class="media-body">
                            <div class="card-title mb-0">{{ $history->title }}
                            </div>
                            <p class="lh-1 mb-0">
                                <span class="text-black-50 small">{{ __('labels.Author') }}</span>
                                <span
                                    class="text-black-50 small font-weight-bold">{{ $history->author }}</span>
                            </p>
                        </div>
                    </div>

                    <p class="my-16pt text-black-70">{{ $history->thesis_title }}</p>

                    <div class="mb-16pt">
                        @livewire('homepage::home.details', ['history_id' => $history->id])
                    </div>

                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="d-flex align-items-center mb-4pt">
                                <span class="material-icons icon-16pt text-black-50 mr-4pt"><i
                                        class="fa fa-calendar-alt"></i></span>
                                <p class="flex text-black-50 lh-1 mb-0">
                                    <small>{{ __('labels.' . $history->month) }}
                                        {{ $history->year }}</small>
                                </p>
                            </div>

                            <div class="d-flex align-items-center">
                                <span class="material-icons icon-16pt text-black-50 mr-4pt"><i
                                        class="fa fa-user-graduate"></i></span>
                                <p class="flex text-black-50 lh-1 mb-0">
                                    <small>{{ $history->career }}</small>
                                </p>
                            </div>

                            <div class="d-flex align-items-center">
                                <span class="material-icons icon-16pt text-black-50 mr-4pt"><i
                                        class="fa fa-university"></i></span>
                                <p class="flex text-black-50 lh-1 mb-0">
                                    <small>{{ $history->university }}</small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @endforeach

    </div>

    
</div>