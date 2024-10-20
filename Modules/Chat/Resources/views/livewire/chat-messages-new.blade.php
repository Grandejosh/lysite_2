<div>

    <section id="chat-container" style="background-color: #eee;">

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center p-3"
                style="border-top: 4px solid #ffa900;">
                <h5 class="mb-0">Chat messages</h5>
                <div class="d-flex flex-row align-items-center">
                    <i class="fas fa-minus mr-3 text-muted fa-xs"></i>
                    <i class="fas fa-times text-muted fa-xs"></i>
                </div>
            </div>
            <div id="chat-scroll" class="card-body" style="position: relative; height: 400px;overflow-y: auto;">

                <div class="d-flex justify-content-between">
                    <p class="small mb-1 text-muted">23 Jan 6:10 pm</p>
                    <p class="small mb-1">Johny Bullock</p>
                </div>
                <div class="d-flex flex-row justify-content-end mb-4 pt-1">
                    <div>
                        <p class="small p-2 me-3 mb-3 text-white rounded-3 bg-warning">Dolorum quasi voluptates
                            quas
                            amet in
                            repellendus perspiciatis fugiat</p>
                    </div>
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava6-bg.webp"
                        alt="avatar 1" style="width: 45px; height: 100%;">
                </div>

            </div>
            <div class="card-footer text-muted d-flex justify-content-start align-items-center p-3">
                <div class="input-group mb-0">
                    <input type="text" class="form-control" placeholder="Type message"
                        aria-label="Recipient's username" aria-describedby="button-addon2" />
                        <br>
                    <button class="btn btn-warning" type="button" id="button-addon2" style="padding-top: .55rem;">
                        Button
                    </button>
                </div>
            </div>
        </div>
    </section>
    <style>
        #chat-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 300px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            display: none;
            /* El chat estará oculto inicialmente */
        }
    </style>
    <script defer>
        function showChatMessagesById(id, type) {

            const chatContainer = document.getElementById("chat-container");
            const xhr = new XMLHttpRequest();

            xhr.open('POST', "{{ route('get_private_messages') }}", true);

            // Obtén el token CSRF de la página
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Configura el encabezado X-CSRF-TOKEN
            xhr.setRequestHeader('X-CSRF-TOKEN', token);

            xhr.onload = function() {
                if (xhr.status === 200) {
                    let htmlChat = '';

                    let chats = JSON.parse(xhr.responseText).chats;

                    const index = JSON.parse(xhr.responseText)['index'];

                    let htmlMessages = '';
                    if (Object.keys(chats).length > 0) {
                        for (let key in chats) {
                            htmlMessages = showHtmlMessages(chats[key]['messages']);
                            htmlChat +=
                                `<div id="inbox-chat${chats[key]['chat_id']}" class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center p-3"
                                            style="border-top: 4px solid #ffa900;">
                                            <h5 class="mb-0">${chats[key]['name']}</h5>
                                            <div class="d-flex flex-row align-items-center">
                                                <i onclick="closeChat()" class="fas fa-times text-muted fa-xs"></i>
                                            </div>
                                        </div>
                                        <div id="chat-scroll" class="card-body" style="position: relative; height: 400px;overflow-y: auto;">
                                        ${htmlMessages}
                                        </div>
                                        <div class="card-footer p-3">
                                            <div class="text-muted d-flex justify-content-start align-items-center mb-2">`;
                            if (chats[key]['ascended_modules']['gpt']) {
                                htmlChat += `<i class="fa fa-robot mr-2"></i>`;
                            }
                            if (chats[key]['ascended_modules']['cur']) {
                                htmlChat += `<i class="fa fa-book mr-2"></i>`;
                            }
                            if (chats[key]['ascended_modules']['tes']) {
                                htmlChat += `<i class="fa fa-scroll"></i>`;
                            }
                            htmlChat += `</div>
                                            <div class="text-muted d-flex justify-content-start align-items-center">
                                                <form onsubmit="sendMessageChat('${chats[key]['chat_id']}','${chats[key]['user_id']}'); return false;">
                                                    <div class="input-group mb-0">
                                                        <input width="90%" id="txt_message_chat" type="text" class="form-control" autocomplete="off" placeholder="Escribe mensaje" aria-label="Nombre de usuario del destinatario" aria-describedby="button-addon2" />
                                                    
                                                        <button class="btn-warning" type="submit" id="button-addon2" style="padding: 5px 12px; border: none;">
                                                            <div id="chat-btn-spinner" class="spinner-border mr-1" role="status" style="width: 1rem; height: 1rem; display:none">
                                                                <span class="sr-only">Loading...</span>
                                                            </div>
                                                            <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                `;

                        }
                    }

                    chatContainer.innerHTML = htmlChat;

                    const chatScroll = document.getElementById("chat-scroll");

                    chatContainer.style.display = "block";
                    chatScroll.scrollTop = chatScroll.scrollHeight;


                    // Remover la clase 'new-message-icon-animation' de '#user-list-chat'
                    document.getElementById("user-list-chat").classList.remove("new-message-icon-animation");

                    // Establecer el contenido de '#alert-message' a "group"
                    document.getElementById("alert-message").innerHTML = "group";

                    // Remover la clase 'text-primary' de '#user' + id
                    document.getElementById("user" + id).classList.remove("text-primary");

                    // Enfocar el campo de entrada '#txt_message_chat'
                    document.getElementById("txt_message_chat").focus();

                    changeMessageChat(index);

                } else {
                    console.error('Error al cargar los mensajes:', xhr.statusText);
                }
            };

            // Debes enviar los datos en el cuerpo de la solicitud como JSON
            const data = JSON.stringify({
                id: id,
                type: type
            });

            xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8'); // Configura el tipo de contenido
            xhr.send(data);
        }

        function showHtmlMessages(messages) {
            const session_user_id = {{ $session_user_id }}
            htmlMessages = ``;
            if (Object.keys(messages).length > 0) {
                for (let key in messages) {
                    let avatar = getAvatarUser(messages[key]['avatar'], messages[key]['name']);
                    if (messages[key]['user_id'] == session_user_id) {
                        htmlMessages += `
                        <div class="d-flex justify-content-between">
                            <p class="small mb-1 text-muted">${messages[key]['created_at']}</p>
                            <p class="small mb-1">${messages[key]['name']}</p>
                        </div>
                        <div class="d-flex flex-row justify-content-end mb-4 pt-1">
                            <div>
                                <p class=" p-2 me-3 mb-3 text-white rounded-3 bg-warning" style="margin-left: 10px; margin-right: 10px;">${messages[key]['message']}</p>
                            </div>
                            <img src="${avatar}" alt="${messages[key]['name']}" style="width: 45px; height: 100%;border-radius: 50%;">
                        </div>
                `;
                    } else {
                        htmlMessages += `
                        <div class="d-flex justify-content-between">
                            <p class="small mb-1">${messages[key]['name']}</p>
                            <p class="small mb-1 text-muted">${messages[key]['created_at']}</p>
                        </div>
                        <div class="d-flex flex-row justify-content-start">
                            <img src="${avatar}" alt="${messages[key]['name']}" style="width: 45px; height: 100%; border-radius: 50%;">
                            <div>
                                <p class=" p-2 ms-3 mb-3 rounded-3" style="background-color: #f5f6f7;">${messages[key]['message']}</p>
                            </div>
                        </div>
                `;
                    }

                }
            }
            return htmlMessages;
        }

        function getAvatarUser(avatar, name) {
            if (avatar == '' || avatar == null) {
                return 'https://ui-avatars.com/api/?name=' + name + '&size=45&rounded=true';
            } else {
                const base_url = "{{ asset('/storage') }}";
                return base_url + '/' + avatar;
            }
        }

        function closeChat() {
            let chatContainer = document.getElementById("chat-container");
            chatContainer.innerHTML = '';
            chatContainer.style.display = "none";
        }

        function sendMessageChat(index, receiver) {
            let message = document.getElementById("txt_message_chat");
            let spinner = document.getElementById("chat-btn-spinner");
            message.disabled = true;
            spinner.style.display = "block";

            const xhr = new XMLHttpRequest();

            xhr.open('POST', "{{ route('get_private_send_message') }}", true);

            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            xhr.setRequestHeader('X-CSRF-TOKEN', token);

            xhr.onload = function() {
                if (xhr.status === 200) {
                    const chatScroll = document.getElementById("chat-scroll");
                    let response = JSON.parse(xhr.responseText);
                    let avatar = getAvatarUser(response.new_message.avatar, response.new_message.name);
                    let htmlNewMessage = `<div class="d-flex justify-content-between">
                                            <p class="small mb-1 text-muted">${response.new_message.created_at}</p>
                                            <p class="small mb-1">${response.new_message.name}</p>
                                        </div>
                                        <div class="d-flex flex-row justify-content-end mb-4 pt-1">
                                            <div>
                                                <p class="p-2 me-3 mb-3 text-white rounded-3 bg-warning">${response.new_message.message}</p>
                                            </div>
                                            <img src="${avatar}" alt="${response.new_message.name}" style="width: 45px; height: 100%;border-radius: 50%;">
                                        </div>`;
                    chatScroll.innerHTML += htmlNewMessage;
                    chatScroll.scrollTop = chatScroll.scrollHeight;
                    message.disabled = false;
                    message.value = '';
                    message.focus();
                    spinner.style.display = "none";
                } else {
                    console.error('Error al cargar los mensajes:', xhr.statusText);
                }
            };

            // Debes enviar los datos en el cuerpo de la solicitud como JSON
            const data = JSON.stringify({
                index: index,
                receiver: receiver,
                message: message.value,
                file: null
            });

            xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8'); // Configura el tipo de contenido
            xhr.send(data);
        }

        function changeMessageChat(index) {
            console.log(index)
            const xhr = new XMLHttpRequest();

            xhr.open('POST', "{{ route('get_private_change_message') }}", true);
            // Obtén el token CSRF de la página
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Configura el encabezado X-CSRF-TOKEN
            xhr.setRequestHeader('X-CSRF-TOKEN', token);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    let response = JSON.parse(xhr.responseText);
                    console.log(response['index']);
                } else {
                    console.error('Error al cargar los mensajes:', xhr.statusText);
                }
            };

            xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8'); // Configura el tipo de contenido
            const data = JSON.stringify({
                index: index
            });

            xhr.send(data);
        }
    </script>
</div>
@section('script-chat')
    <script>
        window.Echo.private('channel-message.' + {{ auth()->id() }}).listen('.MessageEvent', (data) => {
            let $index = data.message.conversation_ids;
            let $user_id = data.message.user_id;

            if (document.getElementById("inbox-chat" + $index)) {
                const chatScroll = document.getElementById("chat-scroll");
                let avatar = getAvatarUser(data.message.avatar, data.message.name);
                let htmlNewMessage = `<div class="d-flex justify-content-between">
                                        <p class="small mb-1">${data.message.name}</p>
                                        <p class="small mb-1 text-muted">${data.message.created_at}</p>
                                    </div>
                                    <div class="d-flex flex-row justify-content-start">
                                        <img src="${avatar}" alt="avatar 1" style="width: 45px; height: 100%;border-radius: 50%;">
                                        <div>
                                            <p class="p-2 ms-3 mb-3 rounded-3" style="background-color: #f5f6f7;">${data.message.message}</p>
                                        </div>
                                    </div>`;
                chatScroll.innerHTML += htmlNewMessage;
                chatScroll.scrollTop = chatScroll.scrollHeight;
                changeMessageChat($index);
            } else {
                document.getElementById("user-list-chat").classList.add("new-message-icon-animation");
                document.getElementById("alert-message").innerHTML = "markunreadchat";
                document.getElementById("user" + $user_id).classList.add("text-primary");
            }
            const music = new Audio('{{ URL('assets/data/mp3/messagebox.mp3') }}');
            music.play();
        });
    </script>
@endsection
