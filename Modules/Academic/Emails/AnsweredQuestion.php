<?php

namespace Modules\Academic\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;


class AnsweredQuestion extends Mailable
{
    use Queueable, SerializesModels;

    public $question="pregunta bla bla???";
    public $subject="Tu pregunta ha sido respondida";
    public $answer="respuesta";
    public $by="JOSH";
    public $question_id;
    // variables para la ruta
    public $a, $b, $c, $d;
    public $Year;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($question,$answer,$by, $question_id) //pregunta, respuesta, nombre del que responde, id de la pregunta
    {
        $this->question=$question;
        $this->answer=$answer;
        $this->by=$by;
        $this->question_id=$question_id;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->load_route();
        $this->Year = date("Y");
        return $this->view('academic::emails.answered-question',[
            'subject' => $this->subject,
            'question' => $this->question,
            'answer' => $this->answer,
            'by' => $this->by,
            'a' => $this->a,
            'b' => $this->b,
            'c' => $this->c,
            'd' => $this->d,
            'Year' => $this->Year,
        ]);
    }

    public function load_route(){
        $this->d = $this->question_id;               //question id
        $this->c = DB::table('aca_questions')->where('id',$this->question_id)->value('content_id');  //content id
        $this->b = DB::table('aca_contents')->where('id',$this->c)->value('section_id');  //section id
        $this->a = DB::table('aca_sections')->where('id',$this->b)->value('course_id');  //course id
    }
}
