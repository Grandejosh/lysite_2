<?php

namespace Modules\Investigation\Http\Livewire\Universities;

use Livewire\Component;
use App\Models\Universities as UniversitiesModel;
use App\Models\Country;

class UniversitiesCreate extends Component
{

    public $name;
    public $siglas;
    public $status = true;
    public $country;

    public function render()
    {
        return view('investigation::livewire.universities.universities-create',['countries' => $this->getCountrys()]);
    }

    public function getCountrys(){
        return Country::all();
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
        $newUniversity= UniversitiesModel::create([
            'name' => trim($this->name),
            'siglas' => trim($this->siglas),
            'country' => trim($this->country),
            'status' => $this->status ? true : false
        ]);


        $this->name = null;
        $this->siglas = null;
        $this->status = true;

        $this->dispatchBrowserEvent('universities-create', ['tit' => 'Enhorabuena','msg' => 'Se registró correctamente']);
    }
    public function back(){
        redirect()->route('Investigation_universities_list');
    }
}

