<?php

namespace Modules\Academic\Http\Livewire\Courses;

use Livewire\Component;
use Modules\Academic\Entities\AcaCourse;

class CoursesMainTrailer extends Component
{
    protected $listeners = ['instructorOpenModalMainTrailer' => 'openModalMainTrailer'];
    public $trailer;
    public $course_id;

    public function render()
    {
        return view('academic::livewire.courses.courses-main-trailer');
    }

    public function openModalMainTrailer($course_id){
        $this->course_id = $course_id;
        $this->dispatchBrowserEvent('aca-course-open-modal-trailer', ['success' => true]);
    }

    public function saveChanges(){
        AcaCourse::find($this->course_id)->update([
            'main_video' => $this->trailer
        ]);
        $this->dispatchBrowserEvent('aca-course-close-modal-trailer', ['success' => true]);
        redirect()->route('academic_dash_instructor_courses_edit', $this->course_id);
    }
}
