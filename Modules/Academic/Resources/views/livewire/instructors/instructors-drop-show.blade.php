<div>
    <div class="col-lg d-flex flex-wrap align-items-center">
        <div class="ml-lg-auto dropdown">
            <a href="#" class="btn btn-link dropdown-toggle text-black-70" data-toggle="dropdown" aria-expanded="false">{{ __('labels.Instructors') }}</a>
            <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-38px, 44px, 0px);">


                @foreach ($instructors as $instructor)
                            <a href="" class="dropdown-item">
                                <span class="media-left mr-16pt">
                                    <img src="{{ url('storage/'.$instructor->avatar) }}" width="30" alt="avatar" class="rounded-circle">
                                </span>
                                <div class="media-body">
                                    {{ $instructor->full_name }}
                                </div>
                            </a>
                @endforeach

            </div>
        </div>
    </div>
</div>





