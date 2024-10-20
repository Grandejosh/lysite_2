<?php

namespace Modules\Academic\Http\Livewire\Courses;

use Livewire\Component;

use Modules\Academic\Entities\AcaCourse;
use Illuminate\Support\Facades\DB;
use Modules\Academic\Entities\AcaInstructor;


class CoursesInstructorEdit extends Component
{
    public $course;
    public $course_id;
    public $course_name;
    public $course_description;
    public $course_status;

    public function mount($course_id){
        $this->course_id = $course_id;

        $this->course = AcaCourse::find($course_id);

        $this->course_name = $this->course->name;
        $this->course_description = $this->course->description;
        $this->course_status = $this->course->status;
    }



    public function render()
    {
        return view('academic::livewire.courses.courses-instructor-edit');
    }

    protected $rules = [
        'course_name' => 'required',
        'course_description' => 'required'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function sabeChanges(){
        $this->course->update([
            'name'          => $this->course_name,
            'description'   => $this->course_description,
            'status'        => $this->course_status ? true : false
        ]);

        $this->dispatchBrowserEvent('aca-courses-update', ['tit' => 'Enhorabuena','msg' => 'Se Actualizo correctamente']);
    }

}
