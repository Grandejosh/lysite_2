<?php

namespace Modules\Academic\Http\Livewire\Students;

use Livewire\Component;
use Modules\Academic\Entities\AcaStudent;
use Modules\Academic\Entities\AcaCourse;
use Illuminate\Support\Facades\DB;

class StudentAssignEdit extends Component
{

    public $course_id;
    public $person_id;
    public $student;
    public $status;
    public $registered_until;
    public $name;
    protected $rules = [
        'registered_until' => 'required'
    ];

    public function mount($course_id, $id)
    {
        $this->course_id = $course_id;
        $this->student = AcaStudent::where('course_id', $course_id)->where('person_id', $id)->first();
        $this->person_id = $id;
        $this->registered_until = $this->student->registered_until;
        $this->status = $this->student->status;
        $this->name = DB::table('people')->where('id', $this->student->person_id)->value('full_name');
        $this->student->course_name = DB::table('aca_courses')->where('id', $this->student->course_id)->value('name');

    }


    public function render()
    {
        return view('academic::livewire.students.student-assign-edit');
    }
    public function update(){
                $this->validate([
                    'registered_until' => 'required'
                ]);
                AcaStudent::where('course_id', $this->course_id)->where('person_id', $this->person_id)->update([
                    'registered_until' => $this->registered_until,
                    'status' => $this->status
                ]);
                $this->dispatchBrowserEvent('aca-student-edit', ['tit' => 'Enhorabuena','msg' => 'Se registró correctamente']);


            }
}
