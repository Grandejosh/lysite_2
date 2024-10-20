<?php

namespace Modules\Academic\Http\Livewire\ContentTypes;

use Illuminate\Support\Facades\Lang;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Academic\Entities\AcaContentType;
use PhpParser\Node\Stmt\Label;

class ContentTypesList extends Component
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
        return view('academic::livewire.content-types.content-types-list', ['contentTypes' => $this->getData()]);
    }

    public function getData(){
        return AcaContentType::where('name','like','%'.$this->search.'%')
            ->paginate(10);
    }

    public function destroy($id){
        try {
            AcaContentType::find($id)->delete();
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
