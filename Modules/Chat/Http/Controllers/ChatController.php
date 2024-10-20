<?php

namespace Modules\Chat\Http\Controllers;

use App\Events\PrivateMessage;
use App\Models\Person;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Modules\Chat\Entities\ChatMessage;

class ChatController extends Controller
{
    public function showChatMessates(Request $request)
    {
        $id = $request->get('id');
        $type = $request->get('type');

        $index = null;
        if ($type == '1') {
            $index = $id . "-" . Auth::id(); // estudiate
        } else {
            $index = Auth::id() . "-" . $id; // instructor
        }

        ChatMessage::where('conversation_ids', $index)->update([
            'is_seen' => true
        ]);

        $chats = [];

        $user = Person::where('user_id', $id)->first();

        $authUser = User::find(Auth::id());
        $gpt = false;
        $cur = false;
        $tes = false;

        if ($authUser->hasRole(['Admin', 'Instructor'])) {
            $modelUser = User::find($id);
            if ($modelUser) {
                $gpt = $modelUser->hasPermissionTo('academico_directo_gpt');
                $cur = $modelUser->hasPermissionTo('academico_directo_cursos');
                $tes = $modelUser->hasPermissionTo('academico_directo_tesis');
            }
        }


        $chats[$index] = [
            'chat_id'       => $index,
            'background'    => 'bg-ui-chatbox-titlebar',
            'user_id'       => $id,
            'right'         => 0,
            'display'       => 'block',
            'name'          => $user ? $user->names : 'User None',
            'message'       => null,
            'messages'      => [],
            'ascended_modules' => array(
                'gpt' => $gpt,
                'cur' => $cur,
                'tes' => $tes
            )
        ];

        $msg = ChatMessage::join('users', 'user_id', 'users.id')
            ->select(
                'chat_messages.conversation_ids',
                'chat_messages.message',
                'chat_messages.user_id',
                'chat_messages.receiver',
                'chat_messages.is_seen',
                'chat_messages.file',
                'chat_messages.file_name',
                'chat_messages.created_at',
                'users.name',
                'users.avatar'
            )
            ->where('conversation_ids', $index)
            ->orderBy('created_at')
            ->get();

        if ($msg) {
            $xmsg = [];
            foreach ($msg as $k => $ms) {
                $xmsg[$k] = [
                    'conversation_ids' => $ms->conversation_ids,
                    'message' => $this->addLink($ms->message),
                    'user_id' => $ms->user_id,
                    'receiver' => $ms->receiver,
                    'is_seen' => $ms->is_seen,
                    'file' => $ms->file,
                    'file_name' => $ms->file_name,
                    'name' => $ms->name,
                    'avatar' => $ms->avatar,
                    'created_at' => $this->gethours($ms->created_at),
                ];
            }

            $chats[$index]['messages'] = $xmsg;

            return response()->json([
                'chats'      => $chats,
                'success'       => true,
                'index'         => $index,
                'user_id'       => $id
            ]);
        }
    }

    public function addLink($cadena)
    {
        $reg_exUrl = "/.[http|https|ftp|ftps]*\:\/\/.[^$|\s]*/";
        $reg_exUrl2 = "/www.[^$|\s]*/";
        $cadena = preg_replace($reg_exUrl, "<a href='$0' target='_blank'>$0</a>", $cadena);
        return preg_replace($reg_exUrl2, "<a href='http://$0' target='_blank'>$0</a>", $cadena);
    }

    public function gethours($date)
    {
        $difference = now()->diff($date);
        if ($difference->d >= 1) {
            return "hace " . $difference->d . " días";
        } else {
            if ($difference->h >= 1) {
                return "hace " . $difference->h . " horas";
            } else {
                if ($difference->i >= 2) {
                    return "hace " . $difference->i . " minuto/s";
                } else {
                    return "hace un momento";
                }
            }
        }
    }

    public function sendMessage(Request $request)
    {
        $user_id            = $request->get('receiver');
        $index              = $request->get('index');
        $new_message_text   = $request->get('message');
        $file               = $request->get('file');

        if ($new_message_text) {

            $file_name = null;
            $path = null;

            if ($file) {
                $file = $file->store('public/chat/files');
                $path = url(Storage::url($file));
                $file_name = $file->getClientOriginalName();
            }

            $chat_message = ChatMessage::create([
                'conversation_ids' => $index,
                'message' => $new_message_text,
                'user_id' => Auth::id(),
                'receiver' => $user_id,
                'file' => $path,
                'file_name' => $file_name,
            ]);

            $new_message = [
                'conversation_ids' => $index,
                'message' => $this->addLink($new_message_text),
                'user_id' => Auth::id(),
                'receiver' => $user_id,
                'is_seen' => false,
                'file' => $path,
                'file_name' => $file_name,
                'name' => Auth::user()->name,
                'avatar' => Auth::user()->avatar,
                'created_at' => $this->gethours($chat_message->created_at)
            ];
        }

        $user = User::find($user_id);

        event(new PrivateMessage($user, $new_message));

        return response()->json([
            'success'       => true,
            'index'         => $index,
            'new_message'   => $new_message
        ]);
    }

    public function isSeenChecked(Request $request)
    {
        //dd($request->all());
        $index = $request->get('index');

        ChatMessage::where('conversation_ids', $index)->where('receiver', Auth::user()->id)->where('is_seen', 0)
            ->update(['is_seen' => 1]);

        return response()->json(['index' => $index]);
    }
}
