<?php

namespace Modules\Academic\Http\Livewire\Contents;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\Academic\Entities\AcaContent;
use Modules\Academic\Entities\AcaCourse;
use Modules\Academic\Entities\AcaSection;
use Modules\Investigation\Entities\InveThesisFormat;
use Modules\Investigation\Entities\InveThesisFormatPart;

class AddLinkParts extends Component
{
    public $search;
    public $section_id;
    public $course_id;
    public $course;
    public $section;
    public $count;
    public $original_name;
    public $name;
    public $format_id;
    public $parts = [];
    public $part_id = 0;

    public $formats = [];
    public $content_parts = [];

    public function mount($section_id, $content_id){
        $this->section = AcaSection::find($section_id);
        $this->content = AcaContent::find($content_id);
        $this->course = AcaCourse::find($this->section->course_id);
        $this->original_name =$this->content->original_name;
        $this->name = $this->content->name;

        $this->formats = InveThesisFormat::join('universities_schools','school_id','universities_schools.id')
            ->join('universities','university_id','universities.id')
            ->select(
                'inve_thesis_formats.id',
                'universities.name AS university_name',
                'universities_schools.name AS school_name',
                DB::raw('CONCAT(inve_thesis_formats.name," - ",inve_thesis_formats.type_thesis," - ",inve_thesis_formats.normative_thesis) AS format_name')
            )
            ->orderBy('universities.name')
            ->orderBy('universities_schools.name')
            ->get();
    }

    public function render()
    {
        $this->getContentParts();
        return view('academic::livewire.contents.add-link-parts');
    }

    public function getParts(){
        
        $this->parts = InveThesisFormatPart::select(
                'id',
                'description',
                'number_order'
            )
            ->where('thesis_format_id',$this->format_id)
            ->orderBy('number_order')
            ->get();

    }

    public function saveContentParts(){
        $this->validate([
            'part_id' => 'required'
        ]);
        InveThesisFormatPart::find($this->part_id)->update([
            'content_id' => $this->content->id
        ]);
        $this->dispatchBrowserEvent('aca-content-part-save', ['tit' => 'Enhorabuena','msg' => 'Se vinculó correctamente']);
    }

    public function getContentParts(){
        $this->content_parts = InveThesisFormatPart::join('inve_thesis_formats','thesis_format_id','inve_thesis_formats.id')
            ->select(
                'inve_thesis_format_parts.id',
                DB::raw('CONCAT(inve_thesis_formats.name," - ",inve_thesis_formats.type_thesis," - ",inve_thesis_formats.normative_thesis) AS format_name'),
                'inve_thesis_format_parts.number_order',
                'inve_thesis_format_parts.description'
            )
            ->where('content_id',$this->content->id)
            ->get();
    }

    public function unlinkContentPart($id){
        InveThesisFormatPart::find($id)->update([
            'content_id' => null
        ]);

        $this->dispatchBrowserEvent('aca-content-part-save', ['tit' => 'Enhorabuena','msg' => 'Se desvinculó correctamente']);
    }
}
