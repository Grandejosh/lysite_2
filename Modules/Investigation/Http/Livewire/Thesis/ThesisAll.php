<?php

namespace Modules\Investigation\Http\Livewire\Thesis;

use App\Models\Universities;
use App\Models\UniversitiesSchools;
use Livewire\Component;
use Modules\Investigation\Entities\InveThesisStudent;
use Livewire\WithPagination;

class ThesisAll extends Component
{
    public $search;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('investigation::livewire.thesis.thesis-all', ['thesis' => $this->getSearch()]);
    }

    public function getSearch()
    {
        return InveThesisStudent::join('people', 'person_id', 'people.id')
            ->select(
                'people.full_name',
                'inve_thesis_students.id',
                'inve_thesis_students.external_id',
                'inve_thesis_students.title',
                'inve_thesis_students.university_id',
                'inve_thesis_students.school_id'
            )
            ->where('full_name', 'like', '%' . $this->search . '%')
            ->orWhere('title', 'like', '%' . $this->search . '%')
            ->orderBy('inve_thesis_students.id', 'DESC')
            ->paginate(10);
    }

    public function getNameUniversity($university_id)
    {
        $university =  Universities::where('id', $university_id)->first();

        return $university->siglas . ' - ' . $university->country;
    }

    public function getNameSchool($id_school)
    {
        return UniversitiesSchools::where('id', $id_school)->first()->name;
    }


    public function destroy($id)
    {
        try {
            InveThesisStudent::where('external_id', $id)->delete();
            $res = 'success';
            $tit = 'Exito';
            $msg = 'Se elimino correctamente';
        } catch (\Illuminate\Database\QueryException $e) {
            //DB::rollBack();
            $res = 'error';
            $tit = 'Salió mal';
            $msg = 'No se puede eliminar comunicate con los administradores del Sistema';
        }

        $this->dispatchBrowserEvent('aca-course-delete', ['res' => $res, 'tit' => $tit, 'msg' => $msg]);
    }
}
