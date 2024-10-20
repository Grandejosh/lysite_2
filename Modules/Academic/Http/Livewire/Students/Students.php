<?php

namespace Modules\Academic\Http\Livewire\Students;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Academic\Entities\AcaStudent;
use Modules\Academic\Entities\AcaCourse;
use Illuminate\Support\Facades\DB;

class Students extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $course_id;
    public $course;
    public $results;

    public function mount($course_id)
    {
        $this->course_id = $course_id;
        $this->course = AcaCourse::find($course_id);
    }

    public function render()
    {
        return view('academic::livewire.students.students', ['students' => $this->getSections()]);
    }

    public function getSections()
    {

        return AcaStudent::join('aca_courses', 'aca_students.course_id', '=', 'aca_courses.id')
            ->join('people', 'aca_students.person_id', '=', 'people.id')
            ->select('aca_courses.id as course_id', 'aca_courses.name as course_name', 'people.full_name as full_name', 'aca_students.person_id as person_id', 'aca_students.status as status', 'aca_students.registered_until as registered_until', 'aca_students.id as id')
            ->where('aca_students.course_id', $this->course_id)

            ->paginate(10);
    }

    public function getData()
    {
        $course_id = $this->course_id;
        return AcaStudent::join('aca_courses', 'aca_students.course_id', '=', 'aca_courses.id')
            ->join('people', 'aca_students.person_id', '=', 'people.id')
            ->select('aca_courses.id as course_id', 'aca_courses.name as course_name', 'people.full_name as full_name', 'aca_students.person_id as person_id', 'aca_students.status as status', 'aca_students.registered_until as registered_until', 'aca_students.id as id')
            ->where('aca_students.course_id', $course_id)
            ->where(function ($query) {
                $query->where('people.number', 'like', '%' . $this->search . '%')
                    ->orWhere('people.full_name', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);
    }

    public function getSearch($search)
    {
        $course_id = $this->course_id;
        return AcaStudent::join('aca_courses', 'aca_students.course_id', '=', 'aca_courses.id')
            ->join('people', 'aca_students.person_id', '=', 'people.id')
            ->select('aca_courses.id as course_id', 'aca_courses.name as course_name', 'people.full_name as full_name', 'aca_students.person_id as person_id', 'aca_students.status as status', 'aca_students.registered_until as registered_until', 'aca_students.id as id')
            ->where('aca_students.course_id', $course_id)
            ->where(function ($query) use ($search) {
                $query->where('people.number', 'like', '%' . $search . '%')
                    ->orWhere('people.full_name', 'like', '%' . $search . '%');
            })
            ->paginate(10);
    }

    public function destroy($id)
    {
        try {
            AcaStudent::find($id)->delete();
            $res = 'success';
            $tit = 'Enhorabuena';
            $msg = 'Se eliminó Estudiante correctamente';
        } catch (\Illuminate\Database\QueryException $e) {
            $res = 'error';
            $tit = 'Salió mal';
            $msg = 'No se puede eliminar porque no cuenta con registros asociados';
        }

        $this->dispatchBrowserEvent('set-assign-delete', ['res' => $res, 'tit' => $tit, 'msg' => $msg]);
        return redirect()->to(route('academic_student_assign', $this->course_id));
    }
}
