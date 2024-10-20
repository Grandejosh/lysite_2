<?php

namespace Modules\Academic\Http\Livewire\Contents;

use Illuminate\Support\Facades\Lang;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Academic\Entities\AcaContent;
use Modules\Academic\Entities\AcaContentType;
use Modules\Academic\Entities\AcaCourse;
use Modules\Academic\Entities\AcaSection;
use Illuminate\Support\Facades\Storage;
use Modules\Academic\Entities\AcaAnswer;
use Modules\Academic\Entities\AcaQuestion;
use Modules\Academic\Entities\AcaStudentsSectionProgress;
use PhpParser\Node\Stmt\Label;
use SebastianBergmann\Environment\Console;

class ContentsList extends Component
{
    public $search;
    public $section_id;
    public $course_id;
    public $course;
    public $section;
    public $count;
    public $no_preguntar = false;


    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function mount($course_id, $section_id)
    {
        $this->course_id = $course_id;
        $this->section_id = $section_id;
        $this->course = AcaCourse::find($course_id);
        $this->section = AcaSection::find($section_id);
        $this->count = AcaContent::where('section_id', $section_id)->count();
    }

    public function getSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('academic::livewire.contents.contents-list', ['contents' => $this->getData()]);  // ['contents' => es la variable que va a la vista

    }

    public function getData()
    {
        return AcaContent::where(function($query){
            $query->where('section_id', $this->section_id);
        })->where(function ($query){
            $query->orWhere('content_url','like', '%' . $this->search . '%')
            ->orWhere('original_name'   , 'like', '%' . $this->search . '%')
            ->orWhere('name'            , 'like', '%' . $this->search . '%');
        })->orderBy('count', 'asc')->paginate(10);
    }
    /*
    Model::where(function ($query) {
    $query->where('a', '=', 1)
          ->orWhere('b', '=', 1);
})->where(function ($query) {
    $query->where('c', '=', 1)
          ->orWhere('d', '=', 1);
});*/

    public function destroy($id)
    {
        try {
            $content_url = AcaContent::find($id)->content_url;
            try {
                Storage::disk('public')->delete(substr($content_url, 8));
            } catch (\Throwable $th) {
            }
            $conteo = AcaContent::find($id)->count;
            $questions = AcaQuestion::where('content_id', $id)->get();
            foreach ($questions as $ques) {
                AcaAnswer::where('question_id', $ques->id)->delete();
            }
            AcaQuestion::where('content_id', $id)->delete();
            AcaStudentsSectionProgress::where('content_id', $id)->delete();
            AcaContent::find($id)->delete();
            $res = 'success';
            $tit = 'Enhorabuena';
            $msg = 'Se eliminó correctamente';
            $contents = AcaContent::where('section_id', $this->section_id)->get();
            foreach ($contents as $content) {
                $value = $content->count;
                if ($value > $conteo) {
                    $content->count = $value - 1;
                    $content->update();
                }
            }
        } catch (\Illuminate\Database\QueryException $e) {
            $res = 'error';
            $tit = 'Salió mal';
            $msg = 'No se puede eliminar porque cuenta con registros asociados';
        }

        $this->dispatchBrowserEvent('set-module-delete', ['res' => $res, 'tit' => $tit, 'msg' => $msg]);
    }

    public function content_type_name($id_type)
    {
        $content_type = AcaContentType::find($id_type);
        return $content_type->name;
    }
    public function changeordernumber($count, $id, $direction)
    {
        $next_count = null;
        $section = null;
        $next_section = null;
        if ($direction == 'down') {
            $section = AcaContent::where('id',$id)->first();
            $next_section = AcaContent::where('section_id', $section->section_id)->where('count', $count + 1)->first();
            $next_count = $count;
            $count++;
        }
        if ($direction == 'up') {
            $section = AcaContent::where('id',$id)->first();
            $next_section = AcaContent::where('section_id', $section->section_id)->where('count', $count - 1)->first();
            $next_count = $count;
            $count--;
        }
        $section->count = $count;
        $section->update();
        $next_section->count = $next_count;
        $next_section->update();
    }
}
