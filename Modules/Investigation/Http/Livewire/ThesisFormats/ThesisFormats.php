<?php

namespace Modules\Investigation\Http\Livewire\ThesisFormats;

use Livewire\Component;
use Modules\Investigation\Entities\InveThesisFormat;
use App\Models\Universities as UniversitiesModel;
use App\Models\UniversitiesSchools as UniversitiesSchoolsModel;
use Livewire\WithPagination;

class ThesisFormats extends Component
{
    public $search;
    public $school_id;
    public $university;
    public $school;

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function mount($school_id)
    {
        $this->school_id = $school_id;
        $this->school=UniversitiesSchoolsModel::find($school_id);
        $this->university = UniversitiesModel::where('id', $this->school->university_id)->first();
    }

    public function getSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('investigation::livewire.thesis-formats.thesis-formats',['formats' => $this->getData(), 'school_id' => $this->school_id]);
    }

    public function getData(){
        $formats = InveThesisFormat::where('name','like','%'.$this->search.'%')
            ->where('school_id',$this->school_id);
                    return $formats->paginate(10);
    }

    public function destroy($id){
        try {
            /*
            $course_image=AcaCourse::find($id)->course_image;
            Storage::disk('public')->delete(substr($course_image, 8)); */
            InveThesisFormat::find($id)->delete();
            $res = 'success';
            $tit = 'Enhorabuena';
            $msg = 'Se eliminó correctamente';
        } catch (\Illuminate\Database\QueryException $e) {
            $res = 'error';
            $tit = 'Salió mal';
            $msg = 'No se puede eliminar porque cuenta con registros asociados';
        }

        $this->dispatchBrowserEvent('inve-format-thesis-delete', ['res' => $res, 'tit' => $tit, 'msg' => $msg]);
    }

}
