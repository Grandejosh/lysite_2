<?php

namespace Modules\Investigation\Http\Livewire\Thesis;

use App\Models\Person;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Exists;
use Livewire\Component;
use Modules\Academic\Entities\AcaContent;
use Modules\Academic\Entities\AcaCourse;
use Modules\Academic\Entities\AcaSection;
use Modules\Investigation\Entities\InveThesisFormat;
use Modules\Investigation\Entities\InveThesisFormatPart;
use Modules\Investigation\Entities\InveThesisStudent;
use Modules\Investigation\Entities\InveThesisStudentPart;

class ThesisPartsTest extends Component
{

    public $thesis_id;
    public $university;
    public $school;
    public $thesis_format;
    public $thesis_student;
    public $ThesisStudentPart;

    public $parts_all; //todas las partes sin filtrar solo ordenados por number order

    public $focus_id;
    public $focused_part;

    public $format;
    public $parts = [];

    public $content;
    public $content_old = "";
    public $auto_save = true;
    public $commentary;
    public $left_margin;
    public $right_margin;
    public $top_margin;
    public $bottom_margin;
    public $format_id;
    public $borrame;

    public function mount($thesis_id, $sub_part)
    {
        $this->content_old = "";
        $this->focus_id = $sub_part; //la parte "subparte que se desea ver ejem. carátula, dedicatoria, conclusiones, etc
        $this->thesis_id = $thesis_id;
        $this->thesis_student = InveThesisStudent::where('id', $thesis_id)->where('user_id', Auth::id())->first();
        if (isset($this->thesis_student)) {
            $this->auto_save = $this->thesis_student->autosave;
            $this->format_id = $this->thesis_student->format_id;
            $this->format = InveThesisFormat::where('id', $this->format_id)->get()->first();

            $this->left_margin = $this->format->left_margin;
            $this->right_margin = $this->format->right_margin;
            $this->bottom_margin = $this->format->bottom_margin ? $this->format->bottom_margin : 2.5;
            $this->top_margin = $this->format->top_margin ? $this->format->top_margin : 2.5;

            $ThesisStudentPart = InveThesisStudentPart::where('inve_thesis_student_id', $this->thesis_student->id)
                ->join('inve_thesis_format_parts', 'inve_thesis_format_parts.id', 'inve_thesis_student_parts.inve_thesis_format_part_id')
                ->orderBy('inve_thesis_format_parts.index_order', 'asc')
                ->get();
            $key = 0;
            if (isset($ThesisStudentPart)) {
                $this->borrame = html_entity_decode($ThesisStudentPart[0]->content, ENT_QUOTES, "UTF-8");
                foreach ($ThesisStudentPart as $k => $part) {
                    $this->content_old .= '<div style="display:none" id="' . ($k + 1) . '"></div>' . html_entity_decode($part->content, ENT_QUOTES, "UTF-8") . '<div style="display:none"><p>-*-</p></div>';
                    if (isset($part->commentary)) {
                        $this->commentary .= ($key++) . ".-" . $part->description . "" . $part->commentary . "-*-";
                    }
                }

                $this->content = $this->content_old;


                //--------------------------------si el alumno no modificó el margen usará el de InveThesisFormat
                // if ($ThesisStudentPart->left_margin == null) {
                //     $this->left_margin = $this->format->left_margin;
                // } else {
                //     $this->left_margin = $ThesisStudentPart->left_margin;
                // }

                // if ($ThesisStudentPart->right_margin == null) {
                //     $this->right_margin = $this->format->right_margin;
                // } else {
                //     $this->right_margin = $ThesisStudentPart->right_margin;
                // }
                // $this->ThesisStudentPart = $ThesisStudentPart;
            }
        } else {
            redirect()->route('home');
        }
    }

    public function render()
    {
        $this->getParts();
        return view('investigation::livewire.thesis.thesis-parts-test');
    }

    public function updatingListParts()
    {
        $this->resetPage();
    }

    public function getParts()
    {
        $this->parts_all = InveThesisFormatPart::where('thesis_format_id', $this->format_id)->orderBy('index_order')->first();
        if ($this->focus_id == 0) {
            if ($this->parts_all) {
                $this->focus_id = $this->parts_all->id;
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
                    $html .= '<a class="alert-link" href="javascript:changeFocus(' . $this->thesis_id . ', ' . $subpart->id . ')">' . $subpart->number_order . ' ' . $subpart->description . '</a>';
                    $html .= $this->getSubParts($subpart->id);
                    $html .= '</li>';
                } else {
                    $html .= '<li class="active">';
                    $html .= '<li>';
                    $html .= '<a href="javascript:changeFocus(' . $this->thesis_id . ', ' . $subpart->id . ')">' . $subpart->number_order . ' ' . $subpart->description . '</a>';
                    $html .= $this->getSubParts($subpart->id);
                    $html .= '</li>';
                }
            }
            $html .= '</ul>';
        }
        return $html;
    }

    public function openModalTwo($id)
    {
        $this->emit('openModalPartCreate', $this->format_id, $id);
    }

    public function openModalEditTwo($id)
    {
        $this->emit('openModalPartEditForm', $id);
    }

    public function destroy($id)
    {
        try {
            InveThesisFormatPart::find($id)->delete();
            $res = 'success';
            $tit = 'Enhorabuena';
            $msg = 'Se eliminó correctamente';
        } catch (\Illuminate\Database\QueryException $e) {
            $res = 'error';
            $tit = 'Salió mal';
            $msg = 'No se puede eliminar porque cuenta con registros asociados';
        }

        $this->dispatchBrowserEvent('inve-part-delete', ['res' => $res, 'tit' => $tit, 'msg' => $msg]);
    }



    // para cuando cambian de sección y no grabaron ------
    public function withoutSavingThesisPartStudentBeforeChange($thesis_id, $part_id)
    {
        redirect()->route('investigation_thesis_parts', [$thesis_id, $part_id]);
    }
    public function savingThesisPartStudentBeforeChange($thesis_id, $part_id)
    {
        $this->saveThesisPartStudentN(false);
        redirect()->route('investigation_thesis_parts', [$thesis_id, $part_id]);
    }
    /////////////////////////////////////////////


    public function saveThesisPartStudentN($bool)
    { // true para mostrar notificacion y false para no
        /*PRUEBA TEST */
        $porciones = explode('<div style="display:none">' . chr(10) . '<p>-*-</p>' . chr(10) . '</div>' . chr(10), $this->content);
        // foreach($porciones as $porcion){
        //     $porcion = trim($porcion);
        //     $porcion = trim($porcion, chr(10));
        //     $porcion = trim($porcion);
        // }
        //dd($porciones[0] ,$this->borrame);
        dd($porciones);

        if ($this->content != $this->content_old) {
            $this->save(); //guarda en la base de datos
        } else {
            $bool = false;

            //Actualiza los margenes aunque el contenido no halla sido modificado
            $this->ThesisStudentPart->update([
                'right_margin' => $this->right_margin,
                'left_margin' => $this->left_margin
            ]);

            $this->dispatchBrowserEvent('inve-student-part-create', ['res' => 'success', 'tit' => 'Enhorabuena', 'msg' => 'Contenido Registrado Satisfactoriamente']);
        }

        if ($bool) {
            $this->dispatchBrowserEvent('inve-student-part-create', ['res' => 'success', 'tit' => 'Enhorabuena', 'msg' => 'Se guardó correctamente']);
        }
    }

    public function goEdit($thesis_id)
    {
        redirect()->route('investigation_thesis_edit', $thesis_id);
    }
    public function deleteThesis($id)
    {
        try {
            InveThesisStudent::find($id)->delete();
            $res = 'success';
            $tit = 'Enhorabuena';
            $msg = 'Se eliminó correctamente';
        } catch (\Illuminate\Database\QueryException $e) {
            $res = 'error';
            $tit = 'Salió mal';
            $msg = 'No se puede eliminar porque cuenta con registros asociados';
        }

        $this->dispatchBrowserEvent('inve-thesis-delete', ['res' => $res, 'tit' => $tit, 'msg' => $msg]);
    }

    public function showVideo()
    {

        $content_id = $this->focused_part->content_id;
        $success = false;
        $video = null;

        if ($content_id) {
            $success = true;
            $url = AcaContent::where('id', $content_id)->value('content_url');
            $video = str_replace('https://vimeo.com/', '', $url);
        }

        $this->dispatchBrowserEvent('inve-open-modal-video', ['success' => $success, 'video' => $video]);
    }

    public function toggleSaving()
    { //Actualiza en la base de datos el autosave
        $this->thesis_student->autosave = $this->auto_save ? true : false;
        $this->thesis_student->update();
    }

    public function saveThesisPartStudentAutoSave()
    { // true para mostrar notificacion y false para no
        // if ($this->content != $this->content_old && $this->auto_save) {
        //     $this->save(); //guarda en la base de datos
        // }
    }

    public function save()
    {
        // InveThesisStudentPart::where('inve_thesis_student_id', $this->thesis_student->id)
        //     ->where('inve_thesis_format_part_id', $this->focus_id)
        //     ->update(['state' => false]);

        // $max_version = InveThesisStudentPart::where('inve_thesis_student_id', $this->thesis_student->id)
        //     ->where('inve_thesis_format_part_id', $this->focus_id)
        //     ->max('version');




        //primero se debe consultar si existe, sino se crea.


        if (InveThesisStudentPart::where('inve_thesis_student_id', $this->thesis_student->id)->where('inve_thesis_format_part_id', $this->focus_id)->exists()) {
            InveThesisStudentPart::where('inve_thesis_student_id', $this->thesis_student->id)
                ->where('inve_thesis_format_part_id', $this->focus_id)
                ->update([
                    'student_id' => $this->thesis_student->student_id,
                    'inve_thesis_student_id' => $this->thesis_student->id,
                    'inve_thesis_format_part_id' => $this->focus_id,
                    'content' => htmlentities($this->content, ENT_QUOTES, "UTF-8"),
                    'right_margin' => $this->right_margin,
                    'left_margin' => $this->left_margin,
                    'top_margin' => $this->top_margin,
                    'bottom_margin' => $this->bottom_margin
                ]);
        } else {
            InveThesisStudentPart::create([
                'student_id' => $this->thesis_student->student_id,
                'inve_thesis_student_id' => $this->thesis_student->id,
                'inve_thesis_format_part_id' => $this->focus_id,
                'content' => htmlentities($this->content, ENT_QUOTES, "UTF-8"),
                'right_margin' => $this->right_margin,
                'left_margin' => $this->left_margin,
                'top_margin' => $this->top_margin,
                'bottom_margin' => $this->bottom_margin
                //'version' => ($max_version ? $max_version + 1 : 1)
            ]);
        }

        $this->content_old = $this->content;
    }

    public function goToTheCourse()
    {
        $content_id = $this->focused_part->content_id;
        $section_id = AcaContent::where('id', $content_id)->get()->first()->section_id;
        $course_id = AcaSection::where('id', $section_id)->get()->first()->course_id;
        //crea la URL al curso y a la #seccion donde se encuentra el video
        $url = route('academic_students_my_course', ['id' => $course_id]) . "#" . $section_id;
        return $url;
    }

    public function deleteCommentary()
    { //eliminar la nota del instructor
        $this->commentary = null;
        InveThesisStudentPart::where('inve_thesis_student_id', $this->thesis_student->id)
            ->where('inve_thesis_format_part_id', $this->focus_id)
            ->update([
                'commentary' => null,
            ]);
    }
}
