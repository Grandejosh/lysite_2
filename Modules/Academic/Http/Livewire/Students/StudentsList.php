<?php

namespace Modules\Academic\Http\Livewire\Students;

use App\Models\Person;
use App\Models\User;
use Livewire\Component;
use Modules\Academic\Entities\AcaStudent;
use Livewire\WithPagination;

class StudentsList extends Component
{
    public $search;

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('academic::livewire.students.students-list', ['students' => $this->getData()]);
    }

    public function getData()
    {
        return AcaStudent::join('people', 'person_id', 'people.id')
            ->join('identity_document_types', 'people.identity_document_type_id', 'identity_document_types.id')
            ->join('aca_courses', 'aca_students.course_id', 'aca_courses.id')
            ->select(
                'aca_students.id AS student_id',
                'people.id',
                'people.full_name',
                'people.number',
                'identity_document_types.description as document_type_name',
                'people.mobile_phone',
                'people.email',
                'aca_courses.name'
            )
            ->where('people.deleted_at', null)
            ->where('people.full_name', 'LIKE', '%' . $this->search . '%')
            ->paginate(10);
    }

    public function getSearch()
    {
        $this->resetPage();
    }
    public function deleteStudent($id)
    {
        //dd($id);
        $student = AcaStudent::find($id);
        //dd($student);
        if ($student) {
            if ($student->person_id <> 1) {
                $person = Person::find($student->person_id);
                AcaStudent::find($id)->delete();
                // if ($person) {
                //     Person::find($student->person_id)->delete();  //NO DEBE ELIMINAR AL USUARIO NI PERSONA SOLO DEL CURSO
                //     User::find($person->user_id)->delete();
                // }
            }
        }
    }
}
