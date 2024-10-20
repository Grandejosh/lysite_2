<?php

namespace Modules\Academic\Http\Livewire\Instructors;

use Livewire\Component;
use Modules\Academic\Entities\AcaInstructor;
use Illuminate\Support\Facades\DB;

class InstructorsDropShow extends Component
{
    public $instructors;

    public function mount($course_id){
        $this->instructors = AcaInstructor::where('course_id', $course_id)->get();
        foreach ($this->instructors as $instructor) {
            $instructor->full_name = DB::table('people')->where('id', $instructor->person_id)->value('full_name');
            $user_id=DB::table('people')->where('id', $instructor->person_id)->value('user_id');
            $instructor->avatar = DB::table('users')->where('id', $user_id)->value('avatar');
        }
    }
    public function render()
    {
        return view('academic::livewire.instructors.instructors-drop-show');
    }
}
