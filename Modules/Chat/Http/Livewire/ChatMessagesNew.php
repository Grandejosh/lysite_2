<?php

namespace Modules\Chat\Http\Livewire;

use App\Models\Person;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Chat\Entities\ChatMessage;
use Livewire\WithFileUploads;

class ChatMessagesNew extends Component
{
    public $session_user_id;

    public function __construct()
    {
        $this->session_user_id = Auth::id();
    }

    use WithFileUploads;

    public function render()
    {
        return view('chat::livewire.chat-messages-new');
    }
}
