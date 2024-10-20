<?php

namespace Modules\Investigation\Http\Livewire\Universities;

use Livewire\Component;
use App\Models\UniversitiesSchools;
use App\Models\Universities as UniversitiesModel;

class UniversitiesSchoolsEdit extends Component
{
    public $university_id;
    public $university;
    public $name;
    public $school;

    public function mount($university_id, $school_id){
        $this->university_id = $university_id;
        $this->university = UniversitiesModel::find($university_id);
        $this->school = UniversitiesSchools::find($school_id);
        $this->name= $this->school->name;
    }
    public function render()
    {
        return view('investigation::livewire.universities.universities-schools-edit');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    protected $rules = [
        'name' => 'required|max:255',
    ];

    public function save(){

        $this->validate();
        //$this->course_image = 'storage/'.substr($this->course_image->store('public/uploads/academic/courses'), 7);    // <----------------------Solo para archivos e imagenes-------------------------------------------
        $this->school->update([
            'name' => trim($this->name),
            'university_id' => $this->university_id,
        ]);


        $this->name = null;

        $this->dispatchBrowserEvent('universities-create', ['tit' => 'Enhorabuena','msg' => 'Se registró fue actualizado correctamente']);
    }
    public function back(){
        redirect()->route('Investigation_universities_schools', $this->university_id);
    }
}
