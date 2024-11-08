<?php

namespace App\Http\Livewire\Complaintbook;

use App\Models\ComplaintBook;
use Livewire\Component;
use Livewire\WithPagination;

class ComList extends Component
{
    public $search;

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
}
