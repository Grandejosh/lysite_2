<?php

namespace Modules\Academic\Http\Livewire\Students;

use Livewire\WithPagination;
use Modules\Academic\Entities\AcaStudent;
use Modules\Academic\Entities\AcaCourse;
use App\Models\User;

use Livewire\Component;

class StudentsAssign extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $course_id;
    public $course;
    public $results;
    public $search = '';
    public $hoy_add_185;

    public function mount($course_id)
    {
        $this->course_id = $course_id;
        $this->course = AcaCourse::find($course_id);
        $this->hoy_add_185 = date('Y-m-d', strtotime('+183 days'));
    }
    public function render()
    {
        return view('academic::livewire.students.students-assign', [
            'students' => $this->getSections()
        ]);
    }

    public function getSections()
    {
        $course_id = $this->course_id;
        return User::join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->join('people', 'people.user_id', '=', 'users.id')
            ->select('people.full_name as full_name', 'people.id as person_id')
            ->where('model_has_roles.role_id', '=', '2')
            ->where(function ($query) {
                $query->where('people.number', $this->search)
                    ->orWhere('people.full_name', 'like', '%' . $this->search . '%');
            })
            ->where(function ($query) use ($course_id) {
                $query->selectRaw('COUNT(person_id)')
                    ->from('aca_students')
                    ->whereColumn('aca_students.person_id', 'people.id')
                    ->where('aca_students.course_id', '=', $course_id);
            }, 'pro')
            ->paginate(10);
    }
    public function assign($person_id)
    {
        AcaStudent::create([
            'person_id' => $person_id,
            'course_id' => $this->course_id,
            'registered_until' => now()->addDays(183)
        ]);
        return redirect()->to(route('academic_student_assign', $this->course_id));
    }
}
