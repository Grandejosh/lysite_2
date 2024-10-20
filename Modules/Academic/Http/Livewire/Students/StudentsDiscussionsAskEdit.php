<?php

namespace Modules\Academic\Http\Livewire\Students;

use Livewire\Component;
use Modules\Academic\Entities\AcaCourse;
use Modules\Academic\Entities\AcaInstructor;
use Modules\Academic\Entities\AcaQuestion;

class StudentsDiscussionsAskEdit extends Component
{
    public $course_id, $section_id, $content_id, $question_id;

    public $course;
    public $instruct;
    public $question;
    public $question_title;
    public $question_text;
    public $email;

    public function mount($course_id, $section_id, $content_id,$question_id){

        $this->course_id = $course_id;
        $this->section_id = $section_id;
        $this->content_id = $content_id;
        $this->question_id = $question_id;

        $this->course = AcaCourse::find($course_id);

        $this->instruct = AcaInstructor::join('people', 'person_id', 'people.id')
            ->select(
                'people.names',
                'people.email'
            )
            ->where('course_id', $course_id)
            ->first();
        
        $this->question = AcaQuestion::find($this->question_id);
        
        $this->question_title = $this->question->question_title;
        $this->question_text = $this->question->question_text;
        $this->email = $this->question->email;
    }

    public function render()
    {
        return view('academic::livewire.students.students-discussions-ask-edit');
    }

    public function update(){
        $this->validate([
            'question_title' => 'required|max:300',
            'question_text' => 'required'
        ]);

        $this->question->update([
            'question_title' => $this->question_title,
            'question_text' => $this->question_text,
            'email' => $this->email ? true : false
        ]);


        $this->dispatchBrowserEvent('aca-question-update', ['tit' => 'Enhorabuena','msg' => 'La pregunta se actualizó correctamente']);
    }
}
