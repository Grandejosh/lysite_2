<?php

namespace Modules\Investigation\Http\Livewire\ThesisFormats;

use Livewire\Component;
use App\Models\UniversitiesSchools as UniversitiesSchoolsModel;
use App\Models\Universities as UniversitiesModel;
use Modules\Investigation\Entities\InveThesisFormat;

class ThesisFormatsEdit extends Component
{

    public $school_id;
    public $name;
    public $description;
    public $type_thesis;
    public $normative_thesis;
    public $enum_types;
    public $enum_normatives;
    public $university;
    public $school;
    public $format;
    public $thesis_format_id;

    public function mount($school_id, $thesis_format_id)
    {
        $this->school_id = $school_id;
        $this->thesis_format_id = $thesis_format_id;

        $this->enum_types = $this->getTypes();
        $this->enum_normatives = $this->getNormatives();

        $this->school = UniversitiesSchoolsModel::find($school_id);
        $this->university = UniversitiesModel::where('id', $this->school->university_id)->first();
        $this->format = InveThesisFormat::find($this->thesis_format_id);
        $this->loadData();
    }

    public function loadData()
    {
        $this->name = $this->format->name;
        $this->description = $this->format->description;
        $this->type_thesis = $this->format->type_thesis;
        $this->normative_thesis = $this->format->normative_thesis;
    }

    public function getTypes()
    {
        //return ['histórica', 'descriptiva', 'experimental', 'meta-descriptiva', 'metodológica', 'teorica', 'otra'];
        return ['Cuantitativo', 'Cualitativo', 'Mixto'];
    }

    public function getNormatives()
    {
        return ['APA', 'Vancouver', 'ISO', 'Otro'];
    }

    public function render()
    {
        return view('investigation::livewire.thesis-formats.thesis-formats-edit', ['format' => $this->format, 'school' => $this->school]);
    }


    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    protected $rules = [
        'name' => 'required|max:255|',
    ];

    public function save()
    {

        $this->validate();
        //$this->course_image = 'storage/'.substr($this->course_image->store('public/uploads/academic/courses'), 7);    // <----------------------Solo para archivos e imagenes-------------------------------------------
        $this->format->update([
            'name' => trim($this->name),
            'description' => trim($this->description),
            'type_thesis' => trim($this->type_thesis),
            'normative_thesis' => trim($this->normative_thesis),
            'school_id' => $this->school_id,

        ]);


        $this->dispatchBrowserEvent('thesis-format-edit', ['tit' => 'Enhorabuena', 'msg' => 'Se actualizó correctamente']);
    }
    public function back()
    {
        redirect()->route('Investigation_thesis_formats_list', $school_id = $this->school_id);
    }
}
