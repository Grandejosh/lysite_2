<?php

namespace Modules\Academic\Http\Livewire\Sections;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Academic\Entities\AcaCourse;
use Modules\Academic\Entities\AcaSection;

class SectionsCreate extends Component
{
    public $course;
    public $course_id;
    public $title;
    public $description;
    public $status = true;

    public function mount($course_id){
        $this->course_id = $course_id;
        $this->course = AcaCourse::find($course_id);
    }

    public function render()
    {
        return view('academic::livewire.sections.sections-create');
    }

    public function save(){
        $this->validate([
            'title' => 'required|max:255',
            'description' => 'required',
        ]);
        $count=AcaSection::where('course_id',$this->course_id)->count();
        AcaSection::create([
            'course_id'     => $this->course_id,
            'title'         => trim($this->title),
            'description'   => trim($this->description),
            'status'        => $this->status ? true : false,
            'count'         => $count + 1,
            'created_by'    => Auth::id()
        ]);

        $this->title = null;
        $this->description = null;
        $this->status = true;

        $this->dispatchBrowserEvent('aca-sections-create', ['tit' => 'Enhorabuena','msg' => 'Se registró correctamente']);
    }

    public function back(){
        redirect()->route('academic_sections',$this->course_id);
    }
}
