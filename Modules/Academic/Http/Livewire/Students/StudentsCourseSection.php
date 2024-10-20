<?php

namespace Modules\Academic\Http\Livewire\Students;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Academic\Entities\AcaStudentsSectionProgress;
use Modules\Academic\Entities\AcaContent;
use Modules\Academic\Entities\AcaCourse;
use Modules\Academic\Entities\AcaSection;
use Illuminate\Support\Facades\DB;

class StudentsCourseSection extends Component
{

    public $course;
    public $student;
    public $course_id;
    public $Nsections;


    public function mount($course_id)
    {
        $this->course_id = $course_id;
        $this->course = AcaCourse::find($course_id);
        $this->student = DB::table('people')->where('user_id', Auth::user()->id)->first()->id;
        $this->Nsections = AcaSection::where('course_id',$this->course_id)->count();
    }
    public function render()
    {
        return view('academic::livewire.students.students-course-section', ['sections' => $this->getSections()]);
    }


    public function getSections(){
        $sections = AcaSection::where('course_id',$this->course_id)->get();
        foreach($sections as $section){
            $section->n_contents = AcaContent::where('section_id',$section->id)->count();
            $section->n_contents_completed = AcaStudentsSectionProgress::where('section_id',$section->id)->where('student_id',$this->student)->count();
            //dd($n_contents_completed);
        }
        return $sections;
       // dd($sections);
              //  ->paginate(10);
    }

}
