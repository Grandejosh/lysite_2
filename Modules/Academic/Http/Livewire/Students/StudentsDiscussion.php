<?php

namespace Modules\Academic\Http\Livewire\Students;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Academic\Entities\AcaAnswer;
use Modules\Academic\Entities\AcaQuestion;
use Illuminate\Support\Facades\Mail;
use Modules\Academic\Emails\AnsweredQuestion;
use Illuminate\Support\Facades\DB;


class StudentsDiscussion extends Component
{
    public $course_id, $section_id, $content_id, $question_id;

    public $question;
    public $answers;
    public $answer_text;

    public function mount($course_id, $section_id, $content_id, $question_id){
        $this->course_id = $course_id;
        $this->section_id = $section_id;
        $this->content_id = $content_id;
        $this->question_id = $question_id;

    }

    public function render()
    {
        $this->getQuestion();
        $this->getAnswers();
        return view('academic::livewire.students.students-discussion');
    }

    public function getQuestion(){
        $this->question = AcaQuestion::join('users','aca_questions.user_id','users.id')
            ->join('people','users.id','people.user_id')
            ->select(
                'aca_questions.id',
                'aca_questions.question_title',
                'aca_questions.question_text',
                'people.full_name',
                'users.id AS user_id',
                'users.avatar',
                'users.is_online',
                'aca_questions.created_at'
            )
            ->where('aca_questions.id',$this->question_id)
            ->first();
    }

    public function postReply(){
        $this->validate([
            'answer_text' => 'required'
        ]);

        AcaAnswer::create([
            'question_id' => $this->question_id,
            'answer_text' => $this->answer_text,
            'user_id' => Auth::id()
        ]);

        $this->sendEmailNotification();
        $this->dispatchBrowserEvent('aca-answer-publicate', ['tit' => 'Enhorabuena','msg' => 'Respuesta publicada correctamente']);
        $this->answer_text = null;
    }

    public function getAnswers(){
        $this->answers = AcaAnswer::join('users','aca_answers.user_id','users.id')
            ->join('people','users.id','people.user_id')
            ->select(
                'aca_answers.id',
                'aca_answers.answer_text',
                'people.full_name',
                'users.id AS user_id',
                'users.avatar',
                'users.is_online',
                'aca_answers.created_at'
            )
            ->where('aca_answers.question_id',$this->question_id)
            ->get();
    }

    public function deleteAnswer($id){
        AcaAnswer::find($id)->delete();
    }

    public function deleteQuestion($id){

        try {
            AcaQuestion::find($id)->delete();
            response()->route('academic_students_take_lesson', [$this->course_id, $this->section_id, $this->content_id]);
        } catch (\Illuminate\Database\QueryException $e) {
            $this->dispatchBrowserEvent('aca-answer-not-delete', ['tit' => 'Error','msg' => 'No se puede eliminar la pregunta, tiene registros asociados']);
        }

    }

    public function sendEmailNotification(){
        if($this->question->email==1 && $this->question->user_id != Auth::id()){
            $correo = new AnsweredQuestion($this->question->question_text, $this->answer_text, DB::table('users')->where('id', Auth::id())->first()->name, $this->question_id);
        //$correo->subject = 'Tu pregunta ha sido respondida';
        $email = DB::table('users')->where('id',$this->question->user_id)->value('email');
        Mail::to($email)->send($correo);
        }
    }
}
