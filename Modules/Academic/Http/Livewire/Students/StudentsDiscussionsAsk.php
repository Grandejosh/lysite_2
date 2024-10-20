<?php

namespace Modules\Academic\Http\Livewire\Students;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Academic\Entities\AcaCourse;
use Modules\Academic\Entities\AcaInstructor;
use Modules\Academic\Entities\AcaQuestion;
use Illuminate\Support\Facades\Mail;
use Modules\Academic\Emails\AnsweredQuestion;
use Illuminate\Support\Facades\DB;

class StudentsDiscussionsAsk extends Component
{
    public $course_id;
    public $section_id;
    public $content_id;

    public $course;
    public $instruct;

    public $question_title;
    public $question_text;
    public $question_id;
    public $email;

    public $questions = [];

    public function mount($course_id, $section_id, $content_id){

        $this->course_id  = $course_id;
        $this->section_id = $section_id;
        $this->content_id = $content_id;

        $this->course = AcaCourse::find($course_id);

        $this->instruct = AcaInstructor::join('people', 'person_id', 'people.id')
            ->select(
                'people.names',
                'people.email'
            )
            ->where('course_id', $course_id)
            ->first();
    }

    public function render()
    {
        return view('academic::livewire.students.students-discussions-ask');
    }

    public function save(){
        $this->validate([
            'question_title' => 'required|max:300',
            'question_text' => 'required'
        ]);

       $question =  AcaQuestion::create([
            'content_id' => $this->content_id,
            'question_title' => $this->question_title,
            'question_text' => $this->question_text,
            'user_id' => Auth::id(),
            'replyed_status' => false,
            'email' => $this->email ? true : false
        ]);
        $this->question_id = $question->id;

        $this->sendEmailNotification();
        $this->question_title = null;
        $this->question_text = null;
        $this->email = false;

        $this->dispatchBrowserEvent('aca-question-publicate', ['tit' => 'Enhorabuena','msg' => 'Tu pregunta fue publicada correctamente']);
    }

    public function searchQuestion(){

        if($this->question_title){
            $this->questions = AcaQuestion::join('users','aca_questions.user_id','users.id')
            ->join('people','users.id','people.user_id')
            ->select(
                'aca_questions.id',
                'aca_questions.question_title',
                'people.full_name',
                'users.avatar',
                'aca_questions.created_at'
            )
            ->selectSub(function($query) {
                $query->from('aca_answers')
                    ->selectRaw('COUNT(question_id)')
                    ->whereColumn('aca_answers.question_id','aca_questions.id');
            }, 'answers')
            ->where('question_title','like','%'.$this->question_title.'%')
            ->get();
        }else{
            $this->questions = [];
        }
        
    }

    public function sendEmailNotification(){
        $instructors = AcaInstructor::where('course_id', $this->course_id)->get();
        $instructors =  DB::table('people')
        ->join('aca_instructors', 'people.id', '=', 'aca_instructors.person_id')
        ->where('aca_instructors.course_id', $this->course_id)
        ->select('people.*')
        ->get();

        foreach ($instructors as $key => $instructor) {
            $correo = new AnsweredQuestion($this->question_title, "a la espera de respuesta...", "ninguno", $this->question_id);
            $correo->subject = "Un estudiante ha hecho una pregunta";
            $email = $instructor->email;
            Mail::to($email)->send($correo);
        }
    }

}
