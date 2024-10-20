<?php

namespace Modules\Investigation\Http\Livewire\Thesis;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Modules\Academic\Emails\NotificationCheckThesisEmail;
use Modules\Investigation\Entities\InveThesisFormat;
use Modules\Investigation\Entities\InveThesisFormatPart;
use Modules\Investigation\Entities\InveThesisStudent;
use Modules\Investigation\Entities\InveThesisStudentPart;
use Modules\Investigation\Entities\InveThesisStudentPartSelectionComment;

class ThesisPartsCheck extends Component
{
    public $thesis_id;
    public $university;
    public $school;
    public $thesis_format;
    public $thesis_student;
    public $student_name;

    public $parts_all; //todas las partes sin filtrar solo ordenados por number order

    public $focus_id;
    public $focused_part;

    public $format;
    public $format_id;
    public $parts = [];

    public $content;
    public $content_old;
    public $auto_save = true;
    public $thesisStudentPart;
    public $commentary = "no ha dejado comentario";
    public $xpart_id = 0;
    public $notes;

    public function mount($external_id, $part_id)
    {
        $this->focus_id = $part_id;
        $this->thesis_id = $external_id;
        $this->thesis_student = InveThesisStudent::where('external_id', $external_id)->first();

        if ($this->thesis_student) {
            $this->auto_save = $this->thesis_student->autosave;
            $this->format_id = $this->thesis_student->format_id;
            $this->format == InveThesisFormat::find($this->format_id);

            $this->thesisStudentPart = InveThesisStudentPart::where('inve_thesis_student_id', $this->thesis_student->id)
                ->where('inve_thesis_format_part_id', $this->focus_id)
                ->orderBy('version', 'desc')
                ->first();

            if ($this->thesisStudentPart) {
                $this->content_old = html_entity_decode($this->thesisStudentPart->content, ENT_QUOTES, "UTF-8");
                $this->content = $this->content_old;
                $this->commentary = $this->thesisStudentPart->commentary;
                $this->xpart_id = $this->thesisStudentPart->id;
            }
            $this->student_name = DB::table('people')
                ->select('people.full_name')
                ->join('users', 'users.id', 'people.user_id')
                ->join('inve_thesis_students', 'inve_thesis_students.user_id', '=', 'users.id')
                ->where('inve_thesis_students.external_id', $this->thesis_id)->first()->full_name;
        } else {
            redirect()->route('home');
        }
    }

    public function render()
    {
        $this->getParts();
        return view('investigation::livewire.thesis.thesis-parts-check');
    }

    public function getParts()
    {
        //debe ordenarse por "index_order" que en el formulario se muestra como "numero de orden"
        $this->parts_all = InveThesisFormatPart::where('thesis_format_id', $this->format_id)->orderBy('index_order')->get();

        if ($this->focus_id == 0 || $this->focus_id == null) {
            if (count($this->parts_all) > 0) {
                $this->focus_id = $this->parts_all[0]->id;
            }
        }
        $this->focused_part = InveThesisFormatPart::find($this->focus_id);
        //esta es la parte que se mostrará a la derecha de la vista

        $parts = InveThesisFormatPart::where('thesis_format_id', $this->format_id)
            ->whereNull('belongs')
            ->orderBy('index_order')
            ->get();

        foreach ($parts as $k => $part) {
            $this->parts[$k] = [
                'id' => $part->id,
                'description' => $part->description,
                'information' => $part->information,
                'number_order' => $part->number_order,
                'items' => $this->getSubParts($part->id),
                'body' => $part->body,
            ];
        }
    }
    public function getSubParts($id)
    {
        $subparts = InveThesisFormatPart::where('belongs', $id)
            ->orderBy('number_order')
            ->get();
        $html = '';

        if (count($subparts) > 0) {
            $html .= '<ul>';
            foreach ($subparts as $k => $subpart) { //$this->thesis_id,$subpart->id
                if ($this->focus_id == $subpart->id) {
                    $html .= '<li class="active">';
                    $html .= '<li class="alert alert-primary">';
                    $html .= '<a class="alert-link" href="' . route('investigation_thesis_check', [$this->thesis_id, $subpart->id]) . '">' . $subpart->number_order . ' ' . $subpart->description . '</a>';
                    $html .= $this->getSubParts($subpart->id);
                    $html .= '</li>';
                } else {
                    $html .= '<li class="active">';
                    $html .= '<li>';
                    $html .= '<a href="' . route('investigation_thesis_check', [$this->thesis_id, $subpart->id]) . '">' . $subpart->number_order . ' ' . $subpart->description . '</a>';
                    $html .= $this->getSubParts($subpart->id);
                    $html .= '</li>';
                }
            }
            $html .= '</ul>';
        }
        return $html;
    }

    public function save()
    {
        if ($this->thesisStudentPart != null) { // si existe actualiza de lo contrario deberá crear con los datos del alumno
            $this->thesisStudentPart->update([
                'content' => htmlentities($this->content, ENT_QUOTES, "UTF-8"),
                'commentary_user_id' => Auth::id(),
                'commentary' => $this->commentary,
            ]);
        } else {
            InveThesisStudentPart::create([
                'student_id' => $this->thesis_student->student_id,
                'inve_thesis_student_id' => $this->thesis_student->id,
                'inve_thesis_format_part_id' => $this->focus_id,
                'content' => htmlentities($this->content, ENT_QUOTES, "UTF-8"),
                'commentary_user_id' => Auth::id(),
                'commentary' => $this->commentary,
                //     'version' => ($max_version ? $max_version + 1 : 1)
            ]);
        }
        $this->sendEmailNotification();

        $this->dispatchBrowserEvent('inve-student-part-create', ['success' => true]);
    }

    public function getComments()
    {
        return "CARAJO";
        $comments = InveThesisStudentPartSelectionComment::where('thesis_student_part_id', $this->thesis_student->id);
        return $comments;
    }

    public function sendEmailNotification()
    {
        // __construct($instructor, $student, $thesis_id, $thesis_part_id, $commmentary, $avatar_url)
        $instructor = DB::table('users')->where('id', Auth::id())->first()->name;
        $name_student = DB::table('inve_thesis_students')->select('people.names')
            ->join('users', 'users.id', '=', 'inve_thesis_students.user_id')
            ->join('people', 'people.user_id', '=', 'users.id')
            ->where('inve_thesis_students.id', $this->thesis_student->id)
            ->first()->names;
        $avatar_url = env('APP_URL') . '/storage/' . Auth::user()->avatar;
        $correo = new NotificationCheckThesisEmail($instructor, $name_student, $this->thesis_id, $this->focus_id, $this->commentary, $avatar_url); //$this->question->question_text, $this->answer_text, DB::table('users')->where('id', Auth::id())->first()->name, $this->question_id);
        $correo->subject = 'Tesis Revisada';
        $email = DB::table('users')
            ->join('inve_thesis_students', 'inve_thesis_students.user_id', '=', 'users.id')
            ->where('inve_thesis_students.external_id', $this->thesis_id)->value('email');

        Mail::to($email)->send($correo);
    }
}
