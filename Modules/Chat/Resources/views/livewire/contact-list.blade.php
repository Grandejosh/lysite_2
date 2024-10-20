<div class="nav-item dropdown dropdown-notifications dropdown-menu-sm-full" wire:ignore.self>
    <button id="user-list-chat"
        class="nav-link btn-flush dropdown-toggle {{ !$alert_message ? 'new-message-icon-animation' : '' }}"
        type="button" data-toggle="dropdown" data-dropdown-disable-document-scroll data-caret="false">

        <i id="alert-message" class="material-icons ">{{ !$alert_message ? 'markunreadchat' : 'group' }}</i>

    </button>
    @if (!$is_instructor && 0 > 1)

        <div class="dropdown-menu dropdown-menu-right">
            <div data-perfect-scrollbar class="position-relative">
                <div class="dropdown-header"><strong>Contactos</strong></div>
                <div class="list-group list-group-flush mb-0" style="max-height: 300px; overflow-y: auto;">
                    @if (count($instructors) > 0)
                        @foreach ($instructors as $instructor)
                            <a onclick="showChatMessagesById({{ $instructor->id }},2)" href="javascript:void(0);"
                                class="list-group-item list-group-item-action unread ">
                                <span class="d-flex align-items-center mb-1">
                                    <small
                                        class="text-black-50">{{ $instructor->is_online ? 'En línea' : 'Desconectado' }}</small>
                                    @if ($instructor->is_online)
                                        <span class="ml-auto unread-indicator bg-success"></span>
                                    @endif
                                </span>
                                <span class="d-flex">
                                    <span class="avatar avatar-xs mr-2">
                                        @if ($instructor->avatar)
                                            <img src="{{ url('storage/' . $instructor->avatar) }}" alt="people"
                                                class="avatar-img rounded-circle" width="26px">
                                        @else
                                            <img src="{{ ui_avatars_url($instructor->full_name, 26, 'none') }}"
                                                alt="people" class="avatar-img rounded-circle">
                                        @endif
                                    </span>
                                    <span id="user{{ $instructor->id }}"
                                        class="flex d-flex flex-column {{ $instructor->is_seen == 1 || is_null($instructor->is_seen) ? '' : 'text-primary' }}">
                                        <strong>Instructor: {{ $instructor->full_name }}</strong>
                                        <span class="text-black-70">{{ $instructor->email }}</span>
                                    </span>
                                </span>
                            </a>
                        @endforeach
                    @endif
                    @if (count($students) > 0)
                        @foreach ($students as $student)
                            <a onclick="showChatMessagesById({{ $student['id'] }},1)" href="javascript:void(0);"
                                class="list-group-item list-group-item-action unread ">
                                <span class="d-flex align-items-center mb-1">
                                    <small
                                        class="text-black-50">{{ $student['is_online'] ? 'En línea' : 'Desconectado' }}</small>
                                    @if ($student['is_online'])
                                        <span class="ml-auto unread-indicator bg-success"></span>
                                    @endif
                                </span>
                                <span class="d-flex">
                                    <span class="avatar avatar-xs mr-2">
                                        @if ($student['avatar'])
                                            <img src="{{ url('storage/' . $student['avatar']) }}" alt="people"
                                                class="avatar-img rounded-circle" width="26px">
                                        @else
                                            <img src="{{ ui_avatars_url($student['full_name'], 26, 'none') }}"
                                                alt="people" class="avatar-img rounded-circle">
                                        @endif
                                    </span>
                                    <span id="user{{ $student['id'] }}"
                                        class="flex d-flex flex-column {{ $student['is_seen'] == 1 || is_null($student['is_seen']) ? '' : 'text-primary' }}">
                                        <strong>{{ $student['full_name'] }}</strong>
                                        <span class="text-black-70">{{ $student['email'] }}</span>
                                    </span>
                                </span>
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    @else
        <!-- ----------------------------------------------------------------------------------------------------------------------------------------------
    --------------------------------------------------------------------------- INSTRUCTORES -------------------------------------------------------- !-->

        <div class="dropdown-menu dropdown-menu-right" style="width: 25vw">

            <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

            <div class="container">
                <div class="row clearfix">
                    <div class="col-lg-12">
                        <div class="overflow-auto chat sticky-top">
                            <div id="plist" class="people-list overflow-auto">
                                {{-- @if (count($students) + count($instructors) > 6) --}}
                                <div class="input-group p-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                                    </div>
                                    <input type="text" class="form-control" wire:keydown.enter="getSearch"
                                        wire:model.defer="search" placeholder="Buscar...">
                                </div>
                                {{-- @endif --}}
                                <div class="overflujo" style="max-height:80vh; min-height:auto">
                                    <ul class="list-unstyled chat-list mt-2 mb-0"
                                        style="max-height: 300px; overflow-y: auto;">
                                        {{-- estudiante --}}
                                        @if (count($instructors) > 0)
                                            @foreach ($instructors as $instructor)
                                                <li class="clearfix">
                                                    <a onclick="showChatMessagesById({{ $instructor['id'] }},2)"
                                                        href="javascript:void(0);">
                                                        @if ($instructor['avatar'])
                                                            <img src="{{ url('storage/' . $instructor['avatar']) }}"
                                                                alt="avatar">
                                                        @else
                                                            <img src="{{ ui_avatars_url($instructor['full_name'], 26, 'none') }}"
                                                                alt="avatar">
                                                        @endif
                                                        <div class="about">
                                                            <div id="user{{ $instructor['id'] }}"
                                                                class="name {{ $instructor['is_seen'] == 1 || is_null($instructor['is_seen']) ? '' : 'text-primary' }}">
                                                                {{ $instructor['utype'] }}:
                                                                {{ $instructor['full_name'] }}</div>
                                                            @if ($instructor['is_online'])
                                                                <div class="status"> <i
                                                                        class="fa fa-user-clock online"></i>
                                                                    {{ $this->getLastActivity($instructor['chat_last_activity']) }}
                                                                </div>
                                                            @else
                                                                <div class="status"> <i
                                                                        class="fa fa-user-clock offline"></i>
                                                                    {{ $this->getLastActivity($instructor['chat_last_activity']) }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </a>
                                                </li>
                                            @endforeach
                                        @endif

                                        @if (count($students) > 0)
                                            @foreach ($students as $student)
                                                <li class="clearfix">
                                                    <a onclick="showChatMessagesById({{ $student['id'] }},1)"
                                                        href="javascript:void(0);">
                                                        @if ($student['avatar'])
                                                            <img src="{{ url('storage/' . $student['avatar']) }}"
                                                                alt="avatar">
                                                        @else
                                                            <img src="{{ ui_avatars_url($student['full_name'], 26, 'none') }}"
                                                                alt="avatar">
                                                        @endif
                                                        <div class="about">
                                                            <div id="user{{ $student['id'] }}"
                                                                class="name {{ $student['is_seen'] == 1 || is_null($student['is_seen']) ? '' : 'text-primary' }}">
                                                                {{ $student['full_name'] }}</div>
                                                            @if ($student['is_online'])
                                                                <div id="activity"
                                                                    valor="{{ $student['chat_last_activity'] }}"
                                                                    class="status"> <i class="fa fa-circle online"></i>
                                                                    {{ $this->getLastActivity($student['chat_last_activity']) }}
                                                                </div>
                                                            @else
                                                                <div id="activity"
                                                                    valor="{{ $student['chat_last_activity'] }}"
                                                                    class="status"> <i
                                                                        class="fa fa-circle offline"></i>
                                                                    {{ $this->getLastActivity($student['chat_last_activity']) }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </a>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <style>
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

        </div>
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
