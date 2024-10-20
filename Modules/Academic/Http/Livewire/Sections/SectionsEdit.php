<?php

namespace Modules\Academic\Http\Livewire\Sections;

use Livewire\Component;
use Modules\Academic\Entities\AcaSection;
use Modules\Academic\Entities\AcaCourse;
use Illuminate\Support\Facades\Auth;

class SectionsEdit extends Component
{
    public $course;
    public $course_id;
    public $section_id;
    public $section;
    public $title;
    public $description;
    public $status;

    public function mount($course_id, $section_id){
        $this->course_id = $course_id;
        $this->section_id = $section_id;
        $this->course = AcaCourse::find($course_id);
        $this->section = AcaSection::find($section_id);

        $this->title = $this->section->title;
        $this->description = $this->section->description;
        $this->status = $this->section->status;
    }

    public function render()
    {
        return view('academic::livewire.sections.sections-edit');
    }

    public function save(){

        $this->validate([
            'title' => 'required|max:255',
            'description' => 'required',
        ]);

        $this->section->update([
            'title'         => trim($this->title),
            'description'   => trim($this->description),
            'status'        => $this->status ? true : false,
            'updated_by'    => Auth::id()
        ]);

        $this->dispatchBrowserEvent('aca-sections-create', ['tit' => 'Enhorabuena','msg' => 'Se actualizado correctamente']);
    }

    public function back(){
        redirect()->route('academic_sections',$this->course_id);
    }
}
