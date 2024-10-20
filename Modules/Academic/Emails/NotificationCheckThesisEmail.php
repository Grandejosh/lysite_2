<?php

namespace Modules\Academic\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;

class NotificationCheckThesisEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $instructor; //nombre de instructor
    public $student;    //nombre de estudiante
    public $thesis_id, $thesis_part_id;  //id de tesis y parte
    public $description_part_thesis; // descripcion o titulo de la parte de la tesis
    public $commmentary; //nota
    public $avatar_url; //url de avatar del instructor

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($instructor, $student, $thesis_id, $thesis_part_id, $commmentary, $avatar_url)
    {
        $this->instructor = $instructor;
        $this->student = $student;
        $this->thesis_id = $thesis_id;
        $this->thesis_part_id = $thesis_part_id;
        $this->commmentary = $commmentary;
        $this->avatar_url = $avatar_url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $Year = date("Y");
        $title = $this->get_title();
        return $this->view('academic::emails.notification-check-thesis-email',[
            'subject' => "Tu Tesis: \"".$title." \"ha sido revisada",
            'check_part' => $this->description_part_thesis,
            'commentary' => $this->commmentary,
            'by' => $this->instructor,
            'avatar_url' => $this->avatar_url,
            'a' => $this->thesis_id,
            'b' => $this->thesis_part_id,
            'Year' => $Year,
            'name_student' => $this->student
        ]);
    }

    public function get_title(){
        $thesis = DB::table('inve_thesis_students')->where('external_id',$this->thesis_id)->first();
        $this->thesis_id = $thesis->id;
        $this->description_part_thesis = DB::table('inve_thesis_student_parts')
        ->select('inve_thesis_format_parts.description')
        ->join('inve_thesis_format_parts', 'inve_thesis_student_parts.inve_thesis_format_part_id', "=", 'inve_thesis_format_parts.id')
        ->where('inve_thesis_student_parts.inve_thesis_format_part_id', $this->thesis_part_id)
        ->first()->description;
        return $thesis->title;
    }
}
