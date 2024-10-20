<?php

namespace Modules\Setting\Http\Livewire\Modules;

use Livewire\Component;
use Modules\Setting\Entities\SetModule;
use Livewire\WithPagination;
class ModulesList extends Component
{
    public $search;

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function getSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('setting::livewire.modules.modules-list',['modules' => $this->getData()]);
    }

    public function getData(){
        return SetModule::where('label','like','%'.$this->search.'%')
            ->paginate(10);
    }

    public function destroy($id){
        try {
            SetModule::find($id)->delete();
            $res = 'success';
            $tit = 'Enhorabuena';
            $msg = 'Se eliminó correctamente';
        } catch (\Illuminate\Database\QueryException $e) {
            $res = 'error';
            $tit = 'Salió mal';
            $msg = 'No se puede eliminar porque cuenta con registros asociados';
        }
       
        $this->dispatchBrowserEvent('set-module-delete', ['res' => $res, 'tit' => $tit, 'msg' => $msg]);
    }
}
