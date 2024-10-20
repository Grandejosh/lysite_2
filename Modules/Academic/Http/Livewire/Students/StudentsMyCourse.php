<?php

namespace Modules\Academic\Http\Livewire\Students;

use Livewire\Component;
use Modules\Academic\Entities\AcaCourse;
use Modules\Academic\Entities\AcaSection;

class StudentsMyCourse extends Component
{
    public $course;
    public $student;
    public $course_id;
    public $sections;


    public function mount($course_id)
    {
        $this->course_id = $course_id;
        $this->course = AcaCourse::find($course_id);
    }
    public function render()
    {
        return view('academic::livewire.students.students-my-course',['sections' => $this->getSections()]);
    }


    public function getSections(){
        return AcaSection::where('course_id',$this->course_id)->get();
              //  ->paginate(10);
    }


}
