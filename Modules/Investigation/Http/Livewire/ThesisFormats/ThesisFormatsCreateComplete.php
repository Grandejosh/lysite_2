<?php

namespace Modules\Investigation\Http\Livewire\ThesisFormats;

use App\Models\Country;
use App\Models\Universities;
use App\Models\UniversitiesSchools;
use Livewire\Component;
use Modules\Investigation\Entities\InveThesisFormat;

class ThesisFormatsCreateComplete extends Component
{
    public $name;
    public $description;
    public $type_thesis;
    public $normative_thesis;
    public $enum_types;
    public $enum_normatives;
    public $universities = [];
    public $schools = [];
    public $school;
    public $countries;
    public $country;
    public $university_id;
    public $country_id;
    public $school_id;
    public $right_margin;
    public $left_margin;
    public $between_lines;
    public $top_margin;
    public $bottom_margin;

    public function mount()
    {
        $this->countries = Country::all();
        $this->enum_types = $this->getTypes();
        $this->enum_normatives = $this->getNormatives();
    }

    public function getTypes()
    {
        //return ['histórica', 'descriptiva', 'experimental', 'meta-descriptiva', 'metodológica', 'teorica', 'otra'];
        return ['Cuantitativo', 'Cualitativo', 'Mixto'];
    }

    public function getNormatives()
    {
        return ['APA', 'Vancouver', 'Otros'];
    }

    public function render()
    {
        return view('investigation::livewire.thesis-formats.thesis-formats-create-complete')->with([
            'countries' => $this->countries
        ]);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    protected $rules = [
        'name' => 'required|max:255|',
        'right_margin' => 'required|numeric|regex:/^[\d]{0,2}(\.[\d]{1,2})?$/',
    ];

    public function save()
    {

        $this->validate();
        //$this->course_image = 'storage/'.substr($this->course_image->store('public/uploads/academic/courses'), 7);    // <----------------------Solo para archivos e imagenes-------------------------------------------
        $newUniversity = InveThesisFormat::create([
            'name' => trim($this->name),
            'description' => trim($this->description),
            'type_thesis' => trim($this->type_thesis),
            'normative_thesis' => trim($this->normative_thesis),
            'school_id' => $this->school_id,
            'right_margin' => $this->right_margin,
            'left_margin' => $this->left_margin,
            'between_lines' => $this->between_lines,
            'top_margin' => $this->top_margin,
            'bottom_margin' => $this->bottom_margin
        ]);


        $this->dispatchBrowserEvent('thesis-format-create', ['tit' => 'Enhorabuena', 'msg' => 'Se registró correctamente']);
    }

    public function back()
    {
        redirect()->route('Investigation_thesis_formats_list_complete');
    }

    public function getUniversities()
    {
        $this->universities = Universities::where('country', $this->country_id)->orderBy('name', 'ASC')->get();
    }

    public function getSchools()
    {
        $this->schools = UniversitiesSchools::where('university_id', $this->university_id)->orderBy('name', 'ASC')->get();
    }
}
