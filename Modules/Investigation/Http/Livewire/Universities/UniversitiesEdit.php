<?php

namespace Modules\Investigation\Http\Livewire\Universities;

use Livewire\Component;
use App\Models\Universities as UniversitiesModel;
use App\Models\Country;

class UniversitiesEdit extends Component
{
    public $name;
    public $siglas;
    public $status = true;
    public $country;
    public $university;
    public $university_id;

    public function mount($university_id){
        $this->university = UniversitiesModel::find($university_id);
        $this->name = $this->university->name;
        $this->siglas = $this->university->siglas;
        $this->country = $this->university->country;
        $this->status = $this->university->status;
        $this->university_id = $university_id;
    }


    public function render()
    {
        return view('investigation::livewire.universities.universities-edit',['countries' => $this->getCountries()]);
    }

    public function getCountries(){
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

        $this->validate([
            'name' => 'unique:universities,name,'.$this->university->id,
        ]);

        $this->university->update([
            'name' => trim($this->name),
            'siglas' => trim($this->siglas),
            'country' => trim($this->country),
            'status' => $this->status ? true : false
        ]);
        $this->name = null;
        $this->country = null;
        $this->siglas = null;
        $this->dispatchBrowserEvent('university_update', ['tit' => 'Enhorabuena','msg' => 'Se Actualizó correctamente']);

    }

    public function back(){
        redirect()->route('Investigation_universities_list');
    }
}
