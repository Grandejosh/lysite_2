<div wire:ignore.self>
    <a class="dropdown-toggle " href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <img src="{{ asset('theme-lyontech/images/msj-black.png') }}"
            style="width: 50px; height:auto;" alt="Icono">
    </a>
    @if (!$is_instructor && 0 > 1)
        <div class="dropdown-menu dropdown-menu-lg-right dropdown-toggle" aria-labelledby="navbarDropdown">
            {{-- <form class="search-form search-form search-form-courses d-none d-md-flex mb-2 ml-2" action="#">

                <button class="btn" type="submit" role="button"><i class="material-icons">search</i></button>
                <input type="text" class="form-control" placeholder="Buscar...?">
            </form> --}}
            @if (count($instructors) > 0)
                @foreach ($instructors as $instructor)
                    <span onclick="showChatMessagesById({{ $instructor->id }},2)" class="d-flex ml-2">
                        <span class="media-left mr-16pt">
                            @if ($instructor->avatar)
                                <img src="{{ url('storage/' . $instructor->avatar) }}" alt="people"
                                    class="avatar-img rounded-circle" width="40">
                            @else
                                <img src="{{ ui_avatars_url($instructor->full_name, 40, 'none') }}" alt="people"
                                    class="avatar-img rounded-circle">
                            @endif
                        </span>
                        <div class="media-body {{ $instructor->is_seen == 1 || is_null($instructor->is_seen) ? '' : 'text-primary' }}"
                            id="user{{ $instructor->id }}">
                            <a class="card-title m-0 " href="instructor-profile.html">Instructor:
                                {{ $instructor->full_name }}</a>
                            <p class="flex text-black-50 lh-1 mb-0"><small>{{ $instructor->email }}</small></p>
                        </div>
                    </span>
                @endforeach
            @endif
            @if (count($students) > 0)
                @foreach ($students as $student)
                    <span onclick="showChatMessagesById({{ $student['id'] }},1)" class="d-flex ml-2">

                        <span class="media-left mr-16pt">
                            @if ($student['avatar'])
                                <img src="{{ url('storage/' . $student['avatar']) }}" alt="people"
                                    class="avatar-img rounded-circle" width="40">
                            @else
                                <img src="{{ ui_avatars_url($student['full_name'], 40, 'none') }}" alt="people"
                                    class="avatar-img rounded-circle">
                            @endif
                        </span>
                        <div class="media-body {{ $student['is_seen'] == 1 || is_null($student['is_seen']) ? '' : 'text-primary' }}"
                            id="user{{ $student['id'] }}">
                            <a class="card-title m-0 " href="instructor-profile.html">{{ $student['full_name'] }}</a>

                            <p class="flex text-black-50 lh-1 mb-0"><small>{{ $student['email'] }}</small></p>
                        </div>

                    </span>
                @endforeach
            @endif
        </div>
    @else
        <div class="dropdown-menu dropdown-menu-lg-right dropdown-toggle" aria-labelledby="navbarDropdown">
            <form class="search-form search-form search-form-courses d-none d-md-flex mb-2 ml-2" action="#" style="width: 95%;">

                <button wire:click="getSearch" class="btn" type="submit" role="button"><i
                        class="material-icons">search</i></button>
                <input wire:keydown.enter="getSearch" wire:model.defer="search" type="text" class="form-control"
                    placeholder="Buscar...?">
            </form>
            @if (count($instructors) > 0)
                @foreach ($instructors as $instructor)
                    <span onclick="showChatMessagesById({{ $instructor['id'] }},2)" class="d-flex ml-2">

                        <span class="media-left mr-16pt">
                            @if ($instructor['avatar'])
                                <img src="{{ url('storage/' . $instructor['avatar']) }}" alt="avatar" width="40">
                            @else
                                <img src="{{ ui_avatars_url($instructor['full_name'], 40, 'none') }}" alt="avatar">
                            @endif
                        </span>
                        <div class="media-body {{ $instructor['is_seen'] == 1 || is_null($instructor['is_seen']) ? '' : 'text-primary' }}"
                            id="user{{ $instructor['id'] }}">
                            <a class="card-title m-0" href="#" style="padding: 5px 15px;">{{ $instructor['utype'] }}: 
                                {{ $instructor['full_name'] }}</a>

                            <p class="flex text-black-50 lh-1 mb-0">
                                @if ($instructor['is_online'])
                                    <div class="status"> <i class="fa fa-user-clock online"></i>
                                        {{ $this->getLastActivity($instructor['chat_last_activity']) }}
                                    </div>
                                @else
                                    <div class="status"> <i class="fa fa-user-clock offline"></i>
                                        {{ $this->getLastActivity($instructor['chat_last_activity']) }}
                                    </div>
                                @endif
                            </p>
                        </div>

                    </span>
                @endforeach
            @endif
            @if (count($students) > 0)
                @foreach ($students as $student)
                    <span onclick="showChatMessagesById({{ $student['id'] }},1)" class="d-flex mt-2 ml-2">
                        <span class="media-left mr-16pt">
                            @if ($student['avatar'])
                                <img src="{{ url('storage/' . $student['avatar']) }}" alt="avatar" width="40">
                            @else
                                <img src="{{ ui_avatars_url($student['full_name'], 40, 'none') }}" alt="avatar">
                            @endif
                        </span>
                        <div class="media-body {{ $student['is_seen'] == 1 || is_null($student['is_seen']) ? '' : 'text-primary' }}"
                            id="user{{ $student['id'] }}">
                            <a class="card-title m-0 color-azul" href="#" style="padding: 5px 15px;">{{ $student['full_name'] }}</a>
                            <p class="flex text-black-50 lh-1 mb-0">
                                @if ($student['is_online'])
                                    <div id="activity" valor="{{ $student['chat_last_activity'] }}" class="status"> <i
                                            class="fa fa-circle online"></i>
                                        {{ $this->getLastActivity($student['chat_last_activity']) }}
                                    </div>
                                @else
                                    <div id="activity" valor="{{ $student['chat_last_activity'] }}" class="status"> <i
                                            class="fa fa-circle offline"></i>
                                        {{ $this->getLastActivity($student['chat_last_activity']) }}
                                    </div>
                                @endif
                            </p>
                        </div>
                    </span>
                @endforeach
            @endif

        </div>
        <style>
            
            .dropdown-toggle::after{
                            display: none !important;
                        }
            body {
                background-color: #f4f7f6;
                margin-top: 20px;
            }

            .card {
                background: #fff;
                transition: .5s;
                border: 0;
                margin-bottom: 30px;
                border-radius: .55rem;
                position: relative;
                width: 100%;
                box-shadow: 0 1px 2px 0 rgb(0 0 0 / 10%);
            }

            .chat-app .people-list {
                width: 280px;
                position: absolute;
                left: 0;
                top: 0;
                padding: 20px;
                z-index: 7
            }

            .chat-app .chat {
                margin-left: 280px;
                border-left: 1px solid #eaeaea
            }

            .people-list {
                -moz-transition: .5s;
                -o-transition: .5s;
                -webkit-transition: .5s;
                transition: .5s
            }

            .people-list .chat-list li {
                padding: 10px 15px;
                list-style: none;
                border-radius: 3px
            }

            .people-list .chat-list li:hover {
                background: #efefef;
                cursor: pointer
            }

            .people-list .chat-list li.active {
                background: #efefef
            }

            .people-list .chat-list li .name {
                font-size: 15px
            }

            .people-list .chat-list img {
                width: 45px;
                border-radius: 50%
            }

            .people-list img {
                float: left;
                border-radius: 50%
            }

            .people-list .about {
                float: left;
                padding-left: 8px
            }

            .people-list .status {
                color: #999;
                font-size: 13px
            }

            .chat .chat-header {
                padding: 15px 20px;
                border-bottom: 2px solid #f4f7f6
            }

            .chat .chat-header img {
                float: left;
                border-radius: 40px;
                width: 40px
            }

            .chat .chat-header .chat-about {
                float: left;
                padding-left: 10px
            }

            .chat .chat-history {
                padding: 20px;
                border-bottom: 2px solid #fff
            }

            .chat .chat-history ul {
                padding: 0
            }

            .chat .chat-history ul li {
                list-style: none;
                margin-bottom: 30px
            }

            .chat .chat-history ul li:last-child {
                margin-bottom: 0px
            }

            .chat .chat-history .message-data {
                margin-bottom: 15px
            }

            .chat .chat-history .message-data img {
                border-radius: 40px;
                width: 40px
            }

            .chat .chat-history .message-data-time {
                color: #434651;
                padding-left: 6px
            }

            .chat .chat-history .message {
                color: #444;
                padding: 18px 20px;
                line-height: 26px;
                font-size: 16px;
                border-radius: 7px;
                display: inline-block;
                position: relative
            }

            .chat .chat-history .message:after {
                bottom: 100%;
                left: 7%;
                border: solid transparent;
                content: " ";
                height: 0;
                width: 0;
                position: absolute;
                pointer-events: none;
                border-bottom-color: #fff;
                border-width: 10px;
                margin-left: -10px
            }

            .chat .chat-history .my-message {
                background: #efefef
            }

            .chat .chat-history .my-message:after {
                bottom: 100%;
                left: 30px;
                border: solid transparent;
                content: " ";
                height: 0;
                width: 0;
                position: absolute;
                pointer-events: none;
                border-bottom-color: #efefef;
                border-width: 10px;
                margin-left: -10px
            }

            .chat .chat-history .other-message {
                background: #e8f1f3;
                text-align: right
            }

            .chat .chat-history .other-message:after {
                border-bottom-color: #e8f1f3;
                left: 93%
            }

            .chat .chat-message {
                padding: 20px
            }

            .online,
            .offline,
            .me {
                margin-right: 2px;
                font-size: 8px;
                vertical-align: middle
            }

            .online {
                color: #86c541
            }

            .offline {
                color: #e47297
            }

            .me {
                color: #1d8ecd
            }

            .float-right {
                float: right
            }

            .clearfix:after {
                visibility: hidden;
                display: block;
                font-size: 0;
                content: " ";
                clear: both;
                height: 0
            }

            @media only screen and (max-width: 767px) {
                .chat-app .people-list {
                    height: 465px;
                    width: 100%;
                    overflow-x: auto;
                    background: #fff;
                    left: -400px;
                    display: none
                }

                .chat-app .people-list.open {
                    left: 0
                }

                .chat-app .chat {
                    margin: 0
                }

                .chat-app .chat .chat-header {
                    border-radius: 0.55rem 0.55rem 0 0
                }

                .chat-app .chat-history {
                    height: 300px;
                    overflow-x: auto
                }
            }

            @media only screen and (min-width: 768px) and (max-width: 992px) {
                .chat-app .chat-list {
                    height: 650px;
                    overflow-x: auto
                }

                .chat-app .chat-history {
                    height: 600px;
                    overflow-x: auto
                }
            }

            @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: landscape) and (-webkit-min-device-pixel-ratio: 1) {
                .chat-app .chat-list {
                    height: 480px;
                    overflow-x: auto
                }

                .chat-app .chat-history {
                    height: calc(100vh - 350px);
                    overflow-x: auto
                }
            }

            .overflujo {
                overflow-y: scroll !important
            }

            .overflujo::-webkit-scrollbar {
                display: none;
            }
        </style>
    @endif
    <script>
        function getLastActivity(date) {

            var dif = new Date() - Date.parse(date);
            dif_s = dif / 1000;
            dif_m = dif / 1000 * 60;
            dif_h = dif / 1000 * 60 * 60;
            dif_d = dif / 1000 * 60 * 60 * 24;
            dif_meses = dif / 1000 * 60 * 60 * 24 * 30;
            if (dif_meses >= 1) {
                return dif_meses == 1 ? "hace " + dif_meses + " mes" : "hace " + dif_meses + " meses";
            } else {
                if (dif_d >= 1) {
                    return dif_d == 1 ? "hace " + dif_d + " día" : "hace " + dif_d + " días";
                } else {
                    if (dif_h >= 1) {
                        return dif_h == 1 ? "hace " + dif_h + " hora" : "hace " + dif_h + " horas";
                    } else {
                        if (dif_m >= 1) {
                            return dif_m == 1 ? "hace " + dif_m + " minuto" : "hace " + dif_m + " minutos";
                        } else {
                            return dif_s < 17 ? "hace un momento" : "hace " + dif_s + " segundos";
                        }
                    }
                }
            }
        }
    </script>
    <script>
        function playSound() {
            const music = new Audio("{{ URL('assets/data/mp3/messagebox.mp3') }}");
            music.play();
            //music.loop = true;
        }
    </script>
    @if (!$alert_message)
        <script>
            playSound();
        </script>
    @endif

</div>
