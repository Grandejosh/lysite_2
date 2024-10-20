<?php

namespace Modules\Investigation\Http\Livewire\Thesis;

use App\Models\Person;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Exists;
use Livewire\Component;
use Modules\Academic\Entities\AcaContent;
use Modules\Academic\Entities\AcaSection;
use Modules\Investigation\Entities\InveThesisFormat;
use Modules\Investigation\Entities\InveThesisFormatPart;
use Modules\Investigation\Entities\InveThesisStudent;
use Modules\Investigation\Entities\InveThesisStudentPart;
use OpenAI\Laravel\Facades\OpenAI;
use GuzzleHttp\Client;
use Modules\Investigation\Entities\InveThesisStudentPartSelectionComment;

class ThesisParts extends Component
{
    protected $client;
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
    public $content_old;
    public $auto_save = false;
    public $commentary;
    public $format_id;
    public $consulta;
    public $resultado;
    public $paraphrase_left;
    public $top_margin;
    public $bottom_margin;
    public $left_margin;
    public $right_margin;
    public $comments;
    public $prompt;

    public function mount($thesis_id, $sub_part)
    {

        $permisos = Person::where('user_id', Auth::user()->id)->first();
        $this->paraphrase_left = $permisos->paraphrase_allowed - $permisos->paraphrase_used;
        $this->focus_id = $sub_part; //la parte "subparte que se desea ver ejem. carátula, dedicatoria, conclusiones, etc
        $this->thesis_id = $thesis_id;

        $this->thesis_student = InveThesisStudent::where('id', $thesis_id)->where('user_id', Auth::id())->first();
        if (isset($this->thesis_student)) {
            $this->auto_save = $this->thesis_student->autosave;
            $this->format_id = $this->thesis_student->format_id;
            $this->format = InveThesisFormat::where('id', $this->format_id)->get()->first();

            //--------------------------------si el alumno no modificó el margen usará el de InveThesisFormat
            if ($this->thesis_student->left_margin == null) {
                $this->left_margin = $this->format->left_margin;
            } else {
                $this->left_margin = $this->thesis_student->left_margin;
            }

            if ($this->thesis_student->right_margin == null) {
                $this->right_margin = $this->format->right_margin;
            } else {
                $this->right_margin = $this->thesis_student->right_margin;
            }
            if ($this->thesis_student->top_margin == null) {
                $this->top_margin = $this->format->top_margin;
            } else {
                $this->top_margin = $this->thesis_student->top_margin;
            }

            if ($this->thesis_student->bottom_margin == null) {
                $this->bottom_margin = $this->format->bottom_margin;
            } else {
                $this->bottom_margin = $this->thesis_student->bottom_margin;
            }

            $ThesisStudentPart = InveThesisStudentPart::where('inve_thesis_student_id', $this->thesis_student->id)
                ->where('inve_thesis_format_part_id', $this->focus_id)
                ->first();

            if (isset($ThesisStudentPart)) {
                $this->content_old = html_entity_decode($ThesisStudentPart->content, ENT_QUOTES, "UTF-8");

                $this->content = $this->content_old;
                $this->commentary = $ThesisStudentPart->commentary;

                $this->ThesisStudentPart = $ThesisStudentPart;
            }
        } else {
            redirect()->route('home');
        }
    }

    public function render()
    {
        $this->getParts();

        return view('investigation::livewire.thesis.thesis-parts');
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

        if ($this->content != $this->content_old) {
            $this->save(); //guarda en la base de datos
        } else {
            $bool = false;

            //Actualiza los margenes aunque el contenido no halla sido modificado
            //dd($this->thesis_student->id,$this->top_margin, $this->left_margin, $this->right_margin);
            InveThesisStudent::where('id', $this->thesis_student->id)->update([
                'right_margin' => $this->right_margin,
                'left_margin' => $this->left_margin,
                'top_margin' => $this->top_margin,
                'bottom_margin' => $this->bottom_margin,
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
        if ($this->content != $this->content_old && $this->auto_save) {
            $this->save(); //guarda en la base de datos
        }
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
        //dd($this->top_margin, $this->left_margin, $this->right_margin);
        // if (InveThesisStudentPart::where('inve_thesis_student_id', $this->thesis_student->id)->where('inve_thesis_format_part_id', $this->focus_id)->exists()) {
        //     InveThesisStudentPart::where('inve_thesis_student_id', $this->thesis_student->id)
        //         ->where('inve_thesis_format_part_id', $this->focus_id)
        //         ->update([
        //             'student_id' => $this->thesis_student->student_id,
        //             'inve_thesis_student_id' => $this->thesis_student->id,
        //             'inve_thesis_format_part_id' => $this->focus_id,
        //             'content' => htmlentities($this->content, ENT_QUOTES, "UTF-8"),
        //             'state' => true
        //         ]);
        // } else {
        //     InveThesisStudentPart::create([
        //         'student_id' => $this->thesis_student->student_id,
        //         'inve_thesis_student_id' => $this->thesis_student->id,
        //         'inve_thesis_format_part_id' => $this->focus_id,
        //         'content' => htmlentities($this->content, ENT_QUOTES, "UTF-8"),
        //         'right_margin' => $this->right_margin,
        //         'left_margin' => $this->left_margin,
        //         'top_margin' => $this->top_margin,
        //         'bottom_margin' => $this->bottom_margin
        //             'version' => ($max_version ? $max_version + 1 : 1)
        //     ]);

        // }

        InveThesisStudentPart::updateOrCreate(
            [
                'inve_thesis_student_id' => $this->thesis_student->id,
                'inve_thesis_format_part_id' => $this->focus_id,
                'state' => true
            ],
            [
                'student_id' => $this->thesis_student->student_id,
                'inve_thesis_student_id' => $this->thesis_student->id,
                'inve_thesis_format_part_id' => $this->focus_id,
                'content' => htmlentities($this->content, ENT_QUOTES, "UTF-8")
            ]
        );

        InveThesisStudent::where('id', $this->thesis_student->id)->update([
            'right_margin' => $this->right_margin,
            'left_margin' => $this->left_margin,
            'top_margin' => $this->top_margin,
            'bottom_margin' => $this->bottom_margin
        ]);

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

    public function updateMargins()
    {
        if ($this->top_margin == null) $this->top_margin = 0;
        if ($this->bottom_margin == null) $this->bottom_margin = 0;
        if ($this->left_margin == null) $this->left_margin = 0;
        if ($this->right_margin == null) $this->right_margin = 0;

        InveThesisStudent::where('id', $this->focus_id)->update([ //se guarda en la tabla de la tesis del estudiante
            'top_margin' => $this->top_margin,
            'bottom_margin' => $this->bottom_margin,
            'left_margin' => $this->left_margin,
            'right_margin' => $this->right_margin
        ]);
    }

    public function paraphrasing()
    {
        if (strlen($this->consulta) > 10) {
            $this->resultado = "espera un momento...";
            $permisos = Person::where('user_id', Auth::user()->id)->first();
            $p_allowed = $permisos->paraphrase_allowed;
            $p_used = $permisos->paraphrase_used;

            if ($p_allowed > $p_used) {
                $max_tokens = 3400;
                $temperature = 0.7;
                $consulta = null;
                $result_text = "hubo un problema, intenta mas tarde";

                switch ($this->prompt) {
                    case  0:
                        case  0:
                            $consulta = "Parafraséame este texto en español como si fueras un experto en investigación: ";
                            break;
                        case  1:
                            $consulta = "Parafraséame este texto en español con el objetivo de reducir el mayor grado de similitud: ";
                            break;
                        case  2:
                            $consulta = "Parafraséame este texto en español logrando humanizarlo por completo, asimismo, reduciendo el mayor grado de similitud posible: ";
                            break;
                }

                $consulta = $consulta . "{" . $this->consulta . "}";

                try {
                    $result = OpenAI::completions()->create([
                        'model' => 'gpt-3.5-turbo-instruct',
                        'prompt' => $consulta,
                        'max_tokens' => $max_tokens,
                        'temperature' => $temperature,
                    ]);
                    $result_text = $result['choices'][0]['text'];
                    $query_tokens = $result['usage']['prompt_tokens'];
                    $result_tokens = $result['usage']['completion_tokens'];
                    $consumed_tokens = $result['usage']['total_tokens'];
                    $permisos->paraphrase_used = $p_used + 1;
                    $permisos->save();
                    $this->paraphrase_left--;
                } catch (Exception $e) {
                    $result_text = $e->getMessage();
                }
                $this->resultado = $result_text;
            } else {
                $this->resultado = "Lo siento, pero parece que has superado tu límite de parafraseo. Para continuar utilizando este servicio, por favor comunícate con los administradores para solicitar un aumento en tu límite. Estamos aquí para ayudarte y queremos asegurarnos de que tengas la mejor experiencia posible. ¡Gracias por usar nuestro servicio!";
            }
        } else {
            $this->resultado = Auth::user()->name . " aprovecha este servicio escribiendo párrafos mas extensos que el que acabas de escribir, esta consulta no será tomada en cuenta";
        }
    }

    public function margenes()
    {

        $this->dispatchBrowserEvent('ckeditor-margenes', ['success' => true]);
    }
}
