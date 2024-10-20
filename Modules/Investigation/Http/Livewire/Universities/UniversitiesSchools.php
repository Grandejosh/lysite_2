<?php

namespace Modules\Investigation\Http\Livewire\Universities;

use Livewire\Component;
use App\Models\UniversitiesSchools as UniversitiesSchoolsModel;
use App\Models\Universities as UniversitiesModel;
use Livewire\WithPagination;

class UniversitiesSchools extends Component
{
    public $search;
    public $university_id;
    public $university;

    use WithPagination;

    protected $paginationTheme = 'bootstrap';


    public function mount($university_id){
        $this->university = UniversitiesModel::find($university_id);
        $this->university_id = $university_id;
    }

    public function getSearch()
    {
        $this->resetPage();
    }

    public function getSchools(){
        return UniversitiesSchoolsModel::where('name','like','%'.$this->search.'%')
        ->where('university_id',$this->university_id)
            ->paginate(10);
    }

    public function render()
    {
        return view('investigation::livewire.universities.universities-schools',['schools' => $this->getSchools()]);
    }

    public function destroy($id){
        try { /*
            $course_image=AcaCourse::find($id)->course_image;
            Storage::disk('public')->delete(substr($course_image, 8)); */
            UniversitiesSchoolsModel::find($id)->delete();
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
