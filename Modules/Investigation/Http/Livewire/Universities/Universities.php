<?php

namespace Modules\Investigation\Http\Livewire\Universities;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Universities as UniversitiesModel;

class Universities extends Component
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
        return view('investigation::livewire.universities.universities',['universities' => $this->getData()]);
    }

    public function getData(){
        return UniversitiesModel::where('name','like','%'.$this->search.'%')
        ->orderBy('name', 'asc')
            ->paginate(10);
    }

    public function destroy($id){
        try {
            /*
            $course_image=AcaCourse::find($id)->course_image;
            Storage::disk('public')->delete(substr($course_image, 8)); */
            UniversitiesModel::find($id)->delete();
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
