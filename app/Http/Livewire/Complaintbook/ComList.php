<?php

namespace App\Http\Livewire\Complaintbook;

use App\Models\ComplaintBook;
use App\Models\ComplaintBooksReply;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use SplSubject;

class ComList extends Component
{
    public $search;

    public $replyId;
    public $replyAsunto;
    public $replyEmail;
    public $replyEstado;
    public $replyMensaje;

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('livewire.complaintbook.com-list', ['complaintbooks' => $this->getData()]);
    }

    public function getData()
    {
        return ComplaintBook::where('full_name', 'like', '%' . $this->search . '%')
            ->paginate(10);
    }

    public function getSearch()
    {
        $this->resetPage();
    }

    public function updateRevisando($id)
    {
        ComplaintBook::find($id)->update([
            'status' => 2
        ]);
        $this->getSearch();
    }
    public function updateTerminado($id)
    {
        ComplaintBook::find($id)->update([
            'status' => 3
        ]);
        $this->getSearch();
    }

    public function opemModalReplyMessaje($data)
    {

        $this->replyId = $data['id'];
        $this->replyAsunto = null;
        $this->replyEmail = $data['email'];
        $this->replyEstado = 3;
        $this->replyMensaje = null;

        $this->dispatchBrowserEvent('open-modal-reply-mensaje', ['email' => $this->replyEmail]);
    }

    public function saveReplyMessageStatus()
    {
        ComplaintBook::find($this->replyId)->update([
            'status' => $this->replyEstado
        ]);

        ComplaintBooksReply::create([
            'complaint_book_id' => $this->replyId,
            'subject' => $this->replyAsunto,
            'email' => $this->replyEmail,
            'complaint_book_status' => $this->replyEstado,
            'message' => $this->replyMensaje,
            'user_id' => Auth::id()
        ]);

        $this->getSearch();
        $this->dispatchBrowserEvent('open-modal-reply-mensaje-hide', ['tit' => 'Enhorabuena', 'msg' => 'Se registró correctamente']);
    }
}
