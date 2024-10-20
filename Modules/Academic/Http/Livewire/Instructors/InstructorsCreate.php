<?php

namespace Modules\Academic\Http\Livewire\Instructors;

use App\Models\User;
use Livewire\Component;
use Modules\Academic\Entities\AcaCourse;
use Illuminate\Support\Facades\DB;
use Modules\Academic\Entities\AcaInstructor;
use Livewire\WithPagination;

class InstructorsCreate extends Component
{
    public $course_id;
    public $course;
    public $search='';
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function mount($course_id){
        $this->course_id = $course_id;
        $this->course = AcaCourse::find($course_id);

    }
    public function render()
    {
        return view('academic::livewire.instructors.instructors-create',['instructors' => $this->getSections()]);
    }

    public function searchPeople()
    {
        $this->resetPage();
    }

    public function getSections(){
        $course_id = $this->course_id;
        return User::join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->join('people', 'people.user_id', '=', 'users.id')
            ->select('people.full_name as full_name', 'people.id as person_id')
            ->where('model_has_roles.role_id', '=', '3')
            ->where(function($query) {
                $query->where('people.number', $this->search)
                      ->orWhere('people.full_name', 'like', '%'.$this->search.'%');
            })
            ->where(function ($query) use ($course_id) {
                $query->selectRaw('COUNT(person_id)')
                    ->from('aca_instructors')
                    ->whereColumn('aca_instructors.person_id', 'people.id')
                    ->where('aca_instructors.course_id','=',$course_id);
            }, 'pro')
            ->paginate(10);

    }
    public function assign($person_id){
        AcaInstructor::create([
            'person_id' => $person_id,
            'course_id' => $this->course_id
        ]);
        return redirect()->to(route('academic_instructor_assign',$this->course_id));
    }
}
