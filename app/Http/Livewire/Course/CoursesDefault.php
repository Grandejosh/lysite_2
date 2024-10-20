<?php

namespace App\Http\Livewire\Course;

use Livewire\Component;
use Modules\Academic\Entities\AcaCourse;
use Modules\Academic\Entities\AcaCourseRating;
use Modules\Academic\Entities\AcaCourseRatingVote;

class CoursesDefault extends Component
{
    public $courses = [];
    public $rating;

    public function mount()
    {

        $this->courses = AcaCourse::select(
            'aca_courses.id',
            'aca_courses.name',
            'aca_courses.description',
            'aca_courses.course_image',
            'aca_courses.main_video'
        )
            ->where('aca_courses.status', 1)
            ->get();

        foreach ($this->courses as $key => $course) {
            $this->Load_rating($course->id);
            $this->courses[$key]->rating = $this->rating->rating;
            $this->courses[$key]->half = $this->rating->half;
            $this->courses[$key]->empty = $this->rating->empty;
            $this->courses[$key]->voters = $this->rating->voters;
        }
    }

    public function render()
    {
        return view('livewire.course.courses-default');
    }

    public function Load_rating($course_id)
    {
        $this->rating = AcaCourseRating::where('course_id', $course_id)->first();

        if ($this->rating) {
            if (fmod($this->rating->rating, 1) > 0) {
                $this->rating->half = true;
            }
            $this->rating->rating = $this->rating->rating - fmod($this->rating->rating, 1);
            if ($this->rating->half) {
                $this->rating->empty = 4 - $this->rating->rating;
            } else {
                $this->rating->empty = 5 - $this->rating->rating;
            }

            $this->rating->voters = AcaCourseRatingVote::where('course_id', $course_id)->count();
        }
    }
}
