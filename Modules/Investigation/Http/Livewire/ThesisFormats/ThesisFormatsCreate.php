<?php

namespace Modules\Investigation\Http\Livewire\ThesisFormats;

use Livewire\Component;
use App\Models\UniversitiesSchools as UniversitiesSchoolsModel;
use App\Models\Universities as UniversitiesModel;
use Modules\Investigation\Entities\InveThesisFormat;

class ThesisFormatsCreate extends Component
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
    public $right_margin;
    public $left_margin;
    public $between_lines;

    public function mount($school_id)
    {
        $this->school_id = $school_id;

        $this->enum_types = $this->getTypes();
        $this->enum_normatives = $this->getNormatives();

        $this->school = UniversitiesSchoolsModel::find($school_id);
        $this->university = UniversitiesModel::where('id', $this->school->university_id)->first();
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
        return view('investigation::livewire.thesis-formats.thesis-formats-create', ['school' => $this->getSchool()]);
    }

    public function getSchool()
    {
        return UniversitiesSchoolsModel::find($this->school_id);
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

        InveThesisFormat::create([
            'name' => trim($this->name),
            'description' => trim($this->description),
            'type_thesis' => trim($this->type_thesis),
            'normative_thesis' => trim($this->normative_thesis),
            'school_id' => $this->school_id,
        ]);


        $this->dispatchBrowserEvent('thesis-format-create', ['tit' => 'Enhorabuena', 'msg' => 'Se registró correctamente']);
    }
    public function back()
    {
        redirect()->route('Investigation_thesis_formats_list', $school_id = $this->school_id);
    }
}
