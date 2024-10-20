<?php

namespace Modules\Academic\Http\Livewire\Sections;

use Livewire\Component;
use Modules\Academic\Entities\AcaCourse;
use Modules\Academic\Entities\AcaSection;

class SectionsList extends Component
{
    public $course;
    public $course_id;
    public $count;

    public function mount($course_id){
        $this->course_id = $course_id;
        $this->course = AcaCourse::find($course_id);
        $this->count = AcaSection::where('course_id',$course_id)->count();
    }


    public function render()
    {
        return view('academic::livewire.sections.sections-list',['sections' => $this->getSections()]);
    }

    public function getSections(){
        return AcaSection::where('course_id', $this->course_id)
        ->orderBy('count', 'asc')->paginate(10);
    }

    public function destroy($id){
        try {
            $conteo=AcaSection::find($id);
            $conteo=$conteo->count;
            AcaSection::find($id)->delete();
            $res = 'success';
            $tit = 'enhorabuena';
            $msg = 'Se eliminó correctamente';
            $sections = AcaSection::where('course_id', $this->course_id)->get();
            foreach ($sections as $section) {
                $value = $section->count;
                   if($value>$conteo){
                       $section->count = $value-1;
                       $section->update();
                   }

            }
        } catch (\Illuminate\Database\QueryException $e) {
            $res = 'error';
            $tit = 'Salió mal';
            $msg = 'No se puede eliminar porque cuenta con registros asociados';
        }


        $this->dispatchBrowserEvent('set-section-delete', ['res' => $res, 'tit' => $tit, 'msg' => $msg]);
    }


    public function changeordernumber($count, $id , $direction){
        $next_count=null;
        $section = null;
        $next_section=null;
        if($direction == 'down'){
            $section = AcaSection::where('id', $id)->where('count', $count)->first();
            $next_section=AcaSection::where('course_id', $section->course_id)->where('count', $count+1)->first();
            $next_count=$count;
            $count++;
        }
        if($direction == 'up'){
            $section = AcaSection::where('id', $id)->where('count', $count)->first();
            $next_section=AcaSection::where('course_id', $section->course_id)->where('count', $count-1)->first();
            $next_count=$count;
            $count--;
        }

        $section->count = $count;
        $section->update();
        $next_section->count = $next_count;
        $next_section->update();
    }
}
