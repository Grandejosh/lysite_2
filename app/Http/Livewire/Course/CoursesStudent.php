<?php

namespace App\Http\Livewire\Course;

use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Academic\Entities\AcaStudent;
use Modules\Academic\Entities\AcaCourseRating;
use Modules\Academic\Entities\AcaCourseRatingVote;

class CoursesStudent extends Component
{
    public $courses = [];
    public $rating;

    public function mount()
    {
        $person = Person::where('user_id', Auth::id())->first();

        if ($person) {
            $this->courses = AcaStudent::join('aca_courses', 'course_id', 'aca_courses.id')
                ->select(
                    'aca_courses.id',
                    'aca_courses.name',
                    'aca_courses.description',
                    'aca_courses.course_image',
                    'aca_courses.main_video',
                    'aca_students.registered_until'
                )
                ->where('person_id', $person->id)
                ->where('aca_courses.status', 1)
                ->where('aca_students.registered_until', '>=', Carbon::now()->format('Y-m-d'))
                ->get();
                foreach ($this->courses as $key => $course) {
                    $this->Load_rating($course->id);
                    $this->courses[$key]->rating = $this->rating->rating;
                    $this->courses[$key]->half = $this->rating->half;
                    $this->courses[$key]->empty = $this->rating->empty;
                    $this->courses[$key]->voters = $this->rating->voters;
                }
        }
    }

    public function render()
    {
        return view('livewire.course.courses-student');
    }

    public function traducirMeses($fecha) {
        $mesesEn = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
        $mesesEs = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');

        return str_replace($mesesEn, $mesesEs, $fecha);
    }

    public function Load_rating($course_id)
    {
        $this->rating = AcaCourseRating::where('course_id', $course_id)->first();

        if($this->rating){
            if (fmod($this->rating->rating, 1) > 0) {
                $this->rating->half = true;
            }
            $this->rating->rating = $this->rating->rating - fmod($this->rating->rating, 1);
            if($this->rating->half){
                $this->rating->empty = 4 - $this->rating->rating;
            }else{
                $this->rating->empty = 5 - $this->rating->rating;
            }

            $this->rating->voters = AcaCourseRatingVote::where('course_id', $course_id)->count();
        }


    }

}
