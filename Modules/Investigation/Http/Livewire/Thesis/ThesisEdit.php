<?php

namespace Modules\Investigation\Http\Livewire\Thesis;

use App\Models\Country;
use App\Models\Universities;
use App\Models\UniversitiesSchools;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Investigation\Entities\InveThesisStudent;
use Illuminate\Support\Str;
use Modules\Investigation\Entities\InveThesisFormat;

class ThesisEdit extends Component
{
    public $countries = [];
    public $country_id = 'PE';
    public $short_name;
    public $university_id;
    public $school_id;
    public $schools = [];
    public $formats = [];
    public $format_id;
    public $state;
    public $thesis_id;
    public $title;
    public $thesis;

    public function mount($thesis_id)
    {
        $this->thesis_id = $thesis_id;
        $this->thesis = InveThesisStudent::find($thesis_id);
        $this->countries = Country::all();
        $this->short_name = $this->thesis->short_name;
        $this->title = $this->thesis->title;
        $this->university_id = $this->thesis->university_id;
        $this->country_id = Universities::findOrFail($this->university_id)->country;

        $this->school_id = $this->thesis->school_id;
        $this->format_id = $this->thesis->format_id;
        $this->state = $this->thesis->state;

        $this->getUniversities();
        $this->getSchools();
        $this->getFormat();
    }

    public function render()
    {
        return view('investigation::livewire.thesis.thesis-edit');
    }

    public function getUniversities()
    {
        $this->universities = Universities::where('country', $this->country_id)->get();
    }
    public function getSchools()
    {
        $this->schools = UniversitiesSchools::where('university_id', $this->university_id)->get();
    }
    public function getFormat()
    {
        $this->formats = InveThesisFormat::where('school_id', $this->school_id)->get();
    }

    public function save()
    {

        $this->validate([
            'short_name' => 'required',
            'title' => 'required',
            'university_id' => 'required',
            'school_id' => 'required',
            'format_id' => 'required'
        ]);
        $format = InveThesisFormat::find($this->format_id);
        $this->thesis->update([
            'external_id'       => Str::random(10),
            'short_name'        => $this->short_name,
            'title'             => $this->title,
            'university_id'     => $this->university_id,
            'school_id'         => $this->school_id,
            'format_id'         => $this->format_id,
            'state'             => $this->state ? true : false,
            'top_margin'        => $format->top_margin,
            'bottom_margin'     => $format->bottom_margin,
            'left_margin'       => $format->left_margin,
            'right_margin'      => $format->right_margin
        ]);
        $this->emit('updateThesisList');
        $this->dispatchBrowserEvent('inve-thesis-student-edit', ['tit' => 'Enhorabuena', 'msg' => 'Se actualizo correctamente']);
    }

    public function parts()
    {
        //$this->emit('updateThesisList');
        redirect()->route('investigation_thesis_parts', $this->thesis_id);
    }
}
