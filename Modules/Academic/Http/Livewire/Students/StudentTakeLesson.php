<?php

namespace Modules\Academic\Http\Livewire\Students;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Modules\Academic\Entities\AcaSection;
use Modules\Academic\Entities\AcaContent;
use Modules\Academic\Entities\AcaStudentsSectionProgress;
use Modules\Academic\Entities\AcaCourse;
use Modules\Academic\Entities\AcaQuestion;

class StudentTakeLesson extends Component
{
    public $section_id;
    public $content_id;
    public $student;
    public $course_id;
    public $video;
    public $course;
    public $content_url;
    public $questions = [];
    public $token;

    public function mount($section_id,$content_id)
    {
        $this->token = Session::token();
        $this->section_id = $section_id;
        $this->content_id = $content_id;
        $this->student = DB::table('people')->where('user_id', Auth::user()->id)->first()->id;  //obtener ID de persona
        $this->course_id = AcaSection::find($section_id)->course_id;
        $this->course = AcaCourse::find($this->course_id);
        $this->content_url = AcaContent::find($content_id)->content_url;
        $this->getQuestions();
    }
    public function render()
    {

        return view('academic::livewire.students.student-take-lesson', ['content' => $this->getContent()]);
    }

    public function getContent(){
        $content = AcaContent::find($this->content_id);
       if($content->content_type_id==1){
        $content->content_url = $this->video_selector($content->content_url);
       }

       if(AcaStudentsSectionProgress::where('content_id',$this->content_id)->where('student_id',$this->student)->count()==0){
        AcaStudentsSectionProgress::create([
            'student_id' => $this->student,
            'section_id' => $this->section_id,
            'content_id' => $this->content_id,
        ]);
       }
        return $content;
    }

    public function video_selector($url){
        $url2=$url;
        $url = explode("=", $url);  //revisa si es un enlace de Youtube https://www.youtube.com/watch?v=qYQdKJRHrKM
        $index=count($url);
        if($index>1){
            $this->video=1;  //si es un enlace de Youtube se retorna 1
            return  $url[$index-1];
        }else{                      //si no lo es revisa de nuevo para ver si es un enlace de Vimeo o Youtube
            $url2 = explode("/", $url2);                        // https://vimeo.com/123998967  https://youtu.be/bPmNe5S19TA
            $index=count($url2);
            if($url2[2]=="vimeo.com"){
                $this->video=0;  //si es un enlace de Vimeo se retorna 0
                return $url2[$index-1];
            }else{
                $this->video=1;  //si es un enlace de Youtube se retorna 1
                return  $url2[$index-1];
            }
        }
    }

    public function getQuestions(){
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
            ->where('content_id',$this->content_id)
            ->get();
    }
    public function getCurrentlyToken(){
        $this->token = Session::token();
    }

}
