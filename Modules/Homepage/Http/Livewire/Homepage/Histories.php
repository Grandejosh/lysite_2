<?php

namespace Modules\Homepage\Http\Livewire\Homepage;

use Livewire\Component;
use Modules\Homepage\Entities\HomeHistories;

class Histories extends Component
{
    public $search;
    //use WithPagination;
    //protected $paginationTheme = 'bootstrap';
/*
    public function getSearch()
    {
        $this->resetPage();
    }*/

    public function render()
    {
        return view('homepage::livewire.homepage.histories', ['histories' => $this->getData()]);
    }

    public function getData()
    {
        return HomeHistories::inRandomOrder()->get();
/*
        return HomeHistories::where('title', 'like', '%' . $this->search . '%')
            ->orwhere('university', 'like', '%' . $this->search . '%')
            ->orwhere('thesis_title', 'like', '%' . $this->search . '%')
            ->orwhere('year', 'like', '%' . $this->search . '%')
            ->orwhere('author', 'like', '%' . $this->search . '%')
            ->paginate(100);
            */
    }

}
