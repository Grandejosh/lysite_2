<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Modules\Investigation\Entities\InveThesisStudent;
use Illuminate\Support\Facades\Auth;

class StudentPackages extends Component
{
    public $pathesis = [];
    public function render()
    {
        $this->getPaThesis();
        return view('livewire.student-packages');
    }
    public function getPaThesis()
    {
        $this->pathesis = InveThesisStudent::where('user_id', Auth::id())->get();
        
    }
}
