<?php

namespace Modules\Investigation\Http\Livewire\Thesis;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Investigation\Entities\InveThesisStudent;

class HeaderInvestigation extends Component
{
    public $thesis = [];

    protected $listeners = ['updateThesisList' => 'getThesis'];

    public function render()
    {
        $this->getThesis();
        return view('investigation::livewire.thesis.header-investigation');
    }

    public function getThesis()
    {
        $this->thesis = InveThesisStudent::where('user_id', Auth::id())->get();
    }

    public function dashboard_next()
    {

        redirect()->route('dashboard');
    }
}
