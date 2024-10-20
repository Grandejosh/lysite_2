<?php

namespace Modules\Setting\Http\Livewire\Parameter;

use App\Models\Parameter;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ParameterList extends Component
{
    public $search;

    use WithPagination;

    public function getSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('setting::livewire.parameter.parameter-list', ['parameters' => $this->getData()]);
    }

    public function getData()
    {
        return Parameter::where('description', 'like', '%' . $this->search . '%')
            ->paginate(10);
    }

    public function destroy($id)
    {
        try {
            Parameter::find($id)->delete();
            $res = 'success';
            $tit = 'Enhorabuena';
            $msg = 'Se eliminó correctamente';
        } catch (\Illuminate\Database\QueryException $e) {
            $res = 'error';
            $tit = 'Salió mal';
            $msg = 'No se puede eliminar porque cuenta con registros asociados';
        }

        $this->dispatchBrowserEvent('set-parameters-delete', ['res' => $res, 'tit' => $tit, 'msg' => $msg]);
    }
}
