<?php

namespace Modules\Investigation\Http\Livewire\Thesis;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Investigation\Entities\InveThesisStudent;

class ModalThesisListStudent extends Component
{
    public $thesis = [];

    public function render()
    {
        $this->thesis = InveThesisStudent::where('user_id', Auth::id())->get();
        return view('investigation::livewire.thesis.modal-thesis-list-student');
    }
}
