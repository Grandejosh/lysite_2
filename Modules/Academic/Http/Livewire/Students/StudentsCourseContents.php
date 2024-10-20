<?php

namespace Modules\Academic\Http\Livewire\Students;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Modules\Academic\Entities\AcaContent;
use Modules\Academic\Entities\AcaSection;
use Modules\Academic\Entities\AcaStudentsSectionProgress;
use Illuminate\Support\Facades\DB;

class StudentsCourseContents extends Component
{
    public $section_id;
    public $student;
    public $course_id;


    public function mount($section_id)
    {
        $this->section_id = $section_id;
        $this->course_id = AcaSection::find($section_id)->course_id;
        $this->student = DB::table('people')->where('user_id', Auth::user()->id)->first()->id;  //obtener ID de persona
    }
    public function render()
    {
        return view('academic::livewire.students.students-course-contents', ['contents' => $this->getContents()]);
    }


    public function getContents(){
        $contents = AcaContent::where('section_id',$this->section_id)->orderBy('count')->get();
        foreach($contents as $content){
            if(AcaStudentsSectionProgress::where('content_id',$content->id)->where('student_id',$this->student)->first()){
                $content->completed = true;
            }else{
                $content->completed = false;
            }
        }

        return $contents;

              //  ->paginate(10);
    }
}
