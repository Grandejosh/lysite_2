<?php

namespace Modules\Homepage\Http\Livewire\Home;

use Livewire\Component;
use Modules\Homepage\Entities\HomeHistoriesDetails;

class Details extends Component
{

    public $details=null;
    public $n=0;

    public function render()
    {
        return view('homepage::livewire.home.details');
    }

    public function mount($history_id)
    {
        $this->details = HomeHistoriesDetails::where('history_id', $history_id)->get();
    }


}
