<?php

namespace Modules\Homepage\Http\Livewire\Home;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Homepage\Entities\HomeHistories;
use Illuminate\Support\Facades\Storage;
use Modules\Homepage\Entities\HomeHistoriesDetails;

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
        return view('homepage::livewire.home.histories', ['histories' => $this->getData()]);
    }

    public function getData()
    {
        return HomeHistories::all();
/*
        return HomeHistories::where('title', 'like', '%' . $this->search . '%')
            ->orwhere('university', 'like', '%' . $this->search . '%')
            ->orwhere('thesis_title', 'like', '%' . $this->search . '%')
            ->orwhere('year', 'like', '%' . $this->search . '%')
            ->orwhere('author', 'like', '%' . $this->search . '%')
            ->paginate(100);
            */
    }

    public function destroy($id){
        try {
            $image_path=HomeHistories::find($id)->image_path;
            Storage::disk('public')->delete(substr($image_path, 8));
            HomeHistoriesDetails::where('history_id', $id)->delete();
            HomeHistories::find($id)->delete();
            $res = 'success';
            $tit = 'Enhorabuena';
            $msg = 'Se eliminó correctamente';

        } catch (\Illuminate\Database\QueryException $e) {
            $res = 'error';
            $tit = 'Salió mal';
            $msg = 'No se puede eliminar porque cuenta con registros asociados';
        }
        redirect()->route('homepage_histories');
        $this->dispatchBrowserEvent('home-history-delete', ['res' => $res, 'tit' => $tit, 'msg' => $msg]);
    }

    public function back(){
        redirect()->route('homepage_histories');
    }
}
