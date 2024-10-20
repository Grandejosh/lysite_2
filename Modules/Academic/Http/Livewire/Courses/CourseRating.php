<?php

namespace Modules\Academic\Http\Livewire\Courses;

use Livewire\Component;
use Modules\Academic\Entities\AcaCourseRating;
use Modules\Academic\Entities\AcaCourseRatingVote;
use Illuminate\Support\Facades\Auth;

class CourseRating extends Component
{
    public $rating;
    public $i=0;
    public $course_id;

    public function mount($course_id)
    {
        $this->course_id=$course_id;

    }
    public function render()
    {
        $this->Load_rating();
        return view('academic::livewire.courses.course-rating');
    }

    public function votar($voto){
        if($voto>5)$voto=5;
        if($voto<1)$voto=1;

            AcaCourseRatingVote::updateOrCreate(
                ['user_id' => Auth::id(), 'course_id' => $this->rating->course_id],
                ['rating' => $voto]
            );
            $this->update_rating_course();   //actualizar el promedio de votos y la cantidad de votos
    }

    public function update_rating_course(){
        $this->i=0;
        $avg=AcaCourseRatingVote::where('course_id', $this->rating->course_id)->avg('rating');
        $voters=AcaCourseRatingVote::where('course_id', $this->rating->course_id)->count();
        AcaCourseRating::where('course_id', $this->rating->course_id)->update(['rating' => $avg, 'voters' => $voters]);
        //    $this->rating = AcaCourseRating::where('course_id', $this->rating->course_id)->first();
          //  $this->mount($this->rating->course_id);
        $this->dispatchBrowserEvent('aca-vote-success', ['tit' => 'Gracias por tu calificación','msg' => 'Tu elección ha sido registrada correctamente']);
    }

    public function reload(){
            //redirect()->route('academic_students_my_course', $this->rating->course_id);
    }

    public function Load_rating()
    {
        $this->rating = AcaCourseRating::where('course_id', $this->course_id)->first();

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
        }


    }

}
