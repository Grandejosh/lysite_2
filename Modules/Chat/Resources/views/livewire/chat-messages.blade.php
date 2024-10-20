<div>
    @if (count($chats) > 0)
        @php
            $i = 0;
        @endphp
        @foreach ($chats as $k => $chat)
            <div id="inbox-chat{{ $k }}" class="ui-widget ui-chatbox" outline="0"
                style="width: 350px; right: {{ $i == 0 ? '0' : 350 * $i + 7 * $i }}px; display: block; padding-bottom: 40px; z-index: 9999;">


                <div class="card card-bordered" id="bg-chat{{ $k }}">
                    <div class="card-header">
                        <h4 class="card-title"><strong>
                                <p class="text-muted">{{ $chat['name'] }}</p>
                            </strong></h4>
                        <a class="btn btn-xs btn-secondary" wire:click="closeChat('{{ $k }}')"
                            href="javascript:void(0);" data-abc="true">Cerrar <i class="fa fa-times"></i></a>
                    </div>

                    <div class="ps-container ps-theme-default ps-active-y" id="cha{{ $k }}"
                        style="overflow-y: scroll !important; height:400px !important;">
                        @php
                            try {
                                $x = 0;
                                $i = $chat['messages'][0]['user_id'];
                                $first = true;
                            } catch (\Throwable $th) {
                            }
                        @endphp
                        @while ($x < count($chat['messages']))
                            @if ($i != $chat['messages'][$x]['user_id'] || $first)
                                <div
                                    class="{{ $chat['messages'][$x]['user_id'] == auth()->user()->id ? 'media media-chat media-chat-reverse' : 'media media-chat' }}">
                                    <img class="avatar"
                                        src="{{ $chat['messages'][$x]['avatar'] ? env('APP_URL') . '/storage/' . $chat['messages'][$x]['avatar'] : ui_avatars_url($chat['messages'][$x]['avatar'], 32, 'none') }}"
                                        alt="...">
                                    <div class="media-body">
                                        @php
                                            $first = false;
                                        @endphp
                            @endif
                            <p>{{ $chat['messages'][$x]['message'] }}</p>

                            @if ($x == count($chat['messages']) - 1)
                                <p class="meta"><time
                                        datetime="{{ date('Y') }}">{{ $chat['messages'][$x]['created_at'] }}</time>
                                </p>
                    </div>
                </div>
            @else
                @if ($i != $chat['messages'][$x + 1]['user_id'] || $x == count($chat['messages']))
                    <p class="meta">{{ $chat['messages'][$x]['created_at'] }}</p>
            </div>
</div>
@php
    $first = true;
@endphp
@endif
@endif


@php
    try {
        $i = $chat['messages'][++$x]['user_id'];
    } catch (\Throwable $th) {
        //throw $th;
    }
@endphp
@endwhile
</div>

<div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;">
    <div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div>
</div>
<div class="ps-scrollbar-y-rail" style="top: 0px; height: 0px; right: 2px;">
    <div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 2px;"></div>
</div>
</div>

<div class="publisher bt-1 border-light">
    <img class="avatar avatar-xs"
        src="{{ Auth::user()->avatar ? env('APP_URL') . '/storage/' . Auth::user()->avatar : ui_avatars_url(Auth::user()->name, 32, 'none') }}"
        alt="...">
    <input id="message{{ $k }}" wire:click="focusTextArea('{{ $k }}')"
        onkeyup="textareaWithoutEnter(event.keyCode, this.id,'{{ $k }}');"
        wire:model.defer="chats.{{ $k }}.message" class="publisher-input" type="text"
        placeholder="Escribe algo..." autocomplete="off">
    <a class="publisher-btn text-info" data-abc="true" onclick="send_w_click('{{ $k }}')"><i
            class="fa fa-paper-plane"></i>
    </a>
</div>


</div>
@php
    $i++;
@endphp
@endforeach
@endif
<script>
    window.addEventListener('scroll-button', event => {
        let index = event.detail.index;
        let user_id = event.detail.user_id
        $('#cha' + index).animate({
            scrollTop: $('#cha' + index)[0].scrollHeight
        }, 10);
        @this.is_seen_checked(index);
        $('#user-list-chat').removeClass('new-message-icon-animation');
        document.getElementById("alert-message").innerHTML = "group";
        $('#user' + user_id).removeClass('text-primary');
        document.getElementById("message" + index).focus();
    });

    window.addEventListener('textarea-null', event => {
        let index = event.detail.index;
        document.getElementById("message" + index).value = '';
    });

    /* Suprimir el uso de la tecla ENTER en Textarea
    Autor: John Sánchez Alvarez
    Este código es libre de usar y modificarse*/

    //Me permite remplazar valores dentro de una cadena
    function str_replace($cambia_esto, $por_esto, $cadena) {
        return $cadena.split($cambia_esto).join($por_esto);
    }

    //Valida que no sean ingresado ENTER dentro del textarea
    function textareaWithoutEnter($char, $id, $index) {

        // $textarea = document.getElementById($id);

        // if (e.which === 13 && !e.shiftKey) {
        //     e.preventDefault();
        //     console.log('prevented');
        //     return false;
        // }
        if ($char == 13) {

            $textarea = document.getElementById($id);
            $texto_escapado = escape($textarea.value);
            if (navigator.appName == "Opera" || navigator.appName == "Microsoft Internet Explorer") $texto_sin_enter =
                str_replace("%0D%0A", "", $texto_escapado);
            else $texto_sin_enter = str_replace("%0A", "", $texto_escapado);

            $textarea.value = unescape($texto_sin_enter);
            @this.sendMessage($index);
            $("#cha" + $index).animate({
                scrollTop: $('#cha' + $index)[0].scrollHeight
            }, 150);
        }
    }

    function send_w_click($index) {
        $id = 'message' + $index;
        $textarea = document.getElementById($id);
        $texto_escapado = escape($textarea.value);
        if (navigator.appName == "Opera" || navigator.appName == "Microsoft Internet Explorer") $texto_sin_enter =
            str_replace("%0D%0A", "", $texto_escapado);
        else $texto_sin_enter = str_replace("%0A", "", $texto_escapado);

        $textarea.value = unescape($texto_sin_enter);
        @this.sendMessage($index);
        $("#cha" + $index).animate({
            scrollTop: $('#cha' + $index)[0].scrollHeight
        }, 150);
        $textarea.focus();
    }
</script>
@section('script-chat')
    <script>
        window.Echo.private('channel-message.' + {{ auth()->id() }}).listen('.MessageEvent', (data) => {
            let $index = data.message.conversation_ids;
            let $user_id = data.message.user_id;

            if (document.getElementById("inbox-chat" + $index)) {
                let $message = data.message;

                @this.addMessages($index, $message);
                $("#cha" + $index).animate({
                    scrollTop: $('#cha' + $index)[0].scrollHeight
                }, 1000);
                @this.is_seen_checked($index);
            } else {
                $('#user-list-chat').addClass('new-message-icon-animation');
                document.getElementById("alert-message").innerHTML = "markunreadchat";
                $('#user' + $user_id).addClass('text-primary');
            }
            const music = new Audio('{{ URL('assets/data/mp3/messagebox.mp3') }}');
            music.play();
        });
    </script>
    <style>
        .card-bordered {
            border: 1px solid #ebebeb;
        }

        .card {
            border: 0;
            border-radius: 0px;
            margin-bottom: 30px;
            -webkit-box-shadow: 0 2px 3px rgba(0, 0, 0, 0.03);
            box-shadow: 0 2px 3px rgba(0, 0, 0, 0.03);
            -webkit-transition: .5s;
            transition: .5s;
        }

        .padding {
            padding: 2rem !important
        }

        body {
            background-color: #f9f9fa
        }

        .card-header:first-child {
            border-radius: calc(.25rem - 1px) calc(.25rem - 1px) 0 0;
        }


        .card-header {
            display: -webkit-box;
            display: flex;
            -webkit-box-pack: justify;
            justify-content: space-between;
            -webkit-box-align: center;
            align-items: center;
            padding: 11px 15px;
            background-color: transparent;
            border-bottom: 1px solid rgba(77, 82, 89, 0.07);
        }

        .card-header .card-title {
            padding: 0;
            border: none;
        }

        h4.card-title {
            font-size: 17px;
        }

        .card-header>*:last-child {
            margin-right: 0;
        }

        .card-header>* {
            margin-left: 5px;
            margin-right: 5px;
        }

        .btn-secondary {
            color: #4d5259 !important;
            background-color: #e4e7ea;
            border-color: #e4e7ea;
            color: #fff;
        }

        .btn-xs {
            font-size: 11px;
            padding: 2px 8px;
            line-height: 18px;
        }

        .btn-xs:hover {
            color: #fff !important;
        }




        .card-title {
            font-family: Roboto, sans-serif;
            font-weight: 300;
            line-height: 1.1;
            margin-bottom: 0;
            padding: 15px 20px;
            border-bottom: 1px solid rgba(77, 82, 89, 0.07);
        }


        .ps-container {
            position: relative;
        }

        .ps-container {
            -ms-touch-action: auto;
            touch-action: auto;
            overflow: hidden !important;
            -ms-overflow-style: none;
        }

        .media-chat {
            padding-right: 14px;
            margin-bottom: 0;
        }

        .media {
            padding: 8px 6px;
            -webkit-transition: background-color .2s linear;
            transition: background-color .2s linear;
        }

        .media .avatar {
            flex-shrink: 0;
        }

        .avatar {
            position: relative;
            display: inline-block;
            width: 26px;
            height: 26px;
            line-height: 26px;
            text-align: center;
            border-radius: 100%;
            background-color: #f5f6f7;
            color: #8b95a5;
            text-transform: uppercase;
        }

        .media-chat .media-body {
            -webkit-box-flex: initial;
            flex: initial;
            display: table;
        }

        .media-body {
            min-width: 0;
        }

        .media-chat .media-body p {
            position: relative;
            padding: 6px 8px;
            margin: 4px 0;
            background-color: #48b0f7;
            border-radius: 3px;
            font-weight: 80;
            color: #fff;
        }

        .media>* {
            margin: 0 4px;
        }

        .media-chat .media-body p.meta {
            background-color: transparent !important;
            padding: 0;
            opacity: .8;
        }

        .media-meta-day {
            -webkit-box-pack: justify;
            justify-content: space-between;
            -webkit-box-align: center;
            align-items: center;
            margin-bottom: 0;
            color: #8b95a5;
            opacity: .8;
            font-weight: 400;
        }

        .media {
            padding: 16px 12px;
            -webkit-transition: background-color .2s linear;
            transition: background-color .2s linear;
        }

        .media-meta-day::before {
            margin-right: 16px;
        }

        .media-meta-day::before,
        .media-meta-day::after {
            content: '';
            -webkit-box-flex: 1;
            flex: 1 1;
            border-top: 1px solid #ebebeb;
        }

        .media-meta-day::after {
            content: '';
            -webkit-box-flex: 1;
            flex: 1 1;
            border-top: 1px solid #ebebeb;
        }

        .media-meta-day::after {
            margin-left: 16px;
        }

        .media-chat.media-chat-reverse {
            padding-right: 12px;
            padding-left: 95px;
            -webkit-box-orient: horizontal;
            -webkit-box-direction: reverse;
            flex-direction: row-reverse;
        }

        .media-chat {
            padding-right: 64px;
            margin-bottom: 0;
        }

        .media {
            padding: 16px 12px;
            -webkit-transition: background-color .2s linear;
            transition: background-color .2s linear;
        }

        .media-chat.media-chat-reverse .media-body p {
            float: right;
            clear: right;
            background-color: #f5f6f7;
            color: #9b9b9b;
        }

        .media-chat .media-body p {
            position: relative;
            padding: 6px 8px;
            margin: 4px 0;
            background-color: #48b0f7;
            border-radius: 3px;
        }


        .border-light {
            border-color: #f1f2f3 !important;
        }

        .bt-1 {
            border-top: 1px solid #ebebeb !important;
        }

        .publisher {
            position: relative;
            display: -webkit-box;
            display: flex;
            -webkit-box-align: center;
            align-items: center;
            padding: 12px 20px;
            background-color: #f9fafb;
        }

        .publisher>*:first-child {
            margin-left: 0;
        }

        .publisher>* {
            margin: 0 8px;
        }

        .publisher-input {
            -webkit-box-flex: 1;
            flex-grow: 1;
            border: none;
            outline: none !important;
            background-color: transparent;
        }

        button,
        input,
        optgroup,
        select,
        textarea {
            font-family: Roboto, sans-serif;
            font-weight: 300;
        }

        .publisher-btn {
            background-color: transparent;
            border: none;
            color: #8b95a5;
            font-size: 16px;
            cursor: pointer;
            overflow: -moz-hidden-unscrollable;
            -webkit-transition: .2s linear;
            transition: .2s linear;
        }

        .file-group {
            position: relative;
            overflow: hidden;
        }

        .publisher-btn {
            background-color: transparent;
            border: none;
            color: #cac7c7;
            font-size: 16px;
            cursor: pointer;
            overflow: -moz-hidden-unscrollable;
            -webkit-transition: .2s linear;
            transition: .2s linear;
        }

        .file-group input[type="file"] {
            position: absolute;
            opacity: 0;
            z-index: -1;
            width: 20px;
        }

        .text-info {
            color: #48b0f7 !important;
        }
    </style>
@endsection
</div>
