<?php

namespace Modules\Academic\Http\Livewire\Courses;

use App\Models\Person;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\Academic\Entities\AcaCourse;

class CoursesInstructorList extends Component
{
    public $courses;

    public function mount(){
        $person_id = Person::where('user_id',Auth::id())->value('id');
        $this->courses = AcaCourse::leftJoin('aca_sections','aca_sections.course_id','aca_courses.id')
            ->join('aca_instructors','aca_instructors.course_id','aca_courses.id')
            ->select(
                'aca_courses.id AS course_id',
                'aca_courses.name AS course_name',
                'aca_courses.description AS course_description',
                'aca_courses.course_image AS course_image',
                'aca_sections.title AS section_title',
                DB::raw('(SELECT COUNT(aca_sections.id) FROM aca_sections WHERE aca_sections.course_id = aca_courses.id) AS sections_quantity'),
                DB::raw('(SELECT COUNT(aca_students.person_id) FROM aca_students WHERE course_id = aca_courses.id) AS students_quantity')
            )
            ->where('aca_instructors.person_id',$person_id)
            ->get();
    }

    public function render()
    {
        return view('academic::livewire.courses.courses-instructor-list');
    }
}
