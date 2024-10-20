<?php

namespace App\Http\Livewire\User;

use App\Models\Country;
use App\Models\Department;
use App\Models\District;
use App\Models\IdentityDocumentType;
use App\Models\Person;
use App\Models\Province;
use App\Models\Universities;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EditInformation extends Component
{

    public $identity_document_type_id = null;
    public $number = null;
    public $names = null;
    public $last_name_father = null;
    public $last_name_mother = null;
    public $full_name = null;
    public $address = null;
    public $mobile_phone = null;
    public $sex = null;
    public $birth_date = null;
    public $email = null;
    public $department_id = null;
    public $province_id = null;
    public $district_id = null;
    public $user_id = null;
    public $country_id = 'PE';

    public $identity_document_types;
    public $countries = [];
    public $departments = [];
    public $provinces = [];
    public $districts = [];
    public $universities = [];
    public $person;
    public $ubigeo_active = false;
    public $university_id;

    public function mount(){
        $this->person = Person::where('user_id',Auth::id())->first();

        $this->email = Auth::user()->email;

        if($this->person){
            $this->identity_document_type_id = $this->person->identity_document_type_id;
            $this->number = $this->person->number;
            $this->names = $this->person->names;
            $this->last_name_father = $this->person->last_name_father;
            $this->last_name_mother = $this->person->last_name_mother;
            $this->full_name = $this->person->full_name;
            $this->address = $this->person->address;
            $this->mobile_phone = $this->person->mobile_phone;
            $this->sex = $this->person->sex;
            $this->birth_date = $this->person->birth_date;
            $this->email = $this->person->email;
            $this->department_id = $this->person->department_id;
            $this->province_id = $this->person->province_id;
            $this->district_id = $this->person->district_id;
            $this->user_id = $this->person->user_id;
            $this->university_id = $this->person->university_id;
        }

        $this->identity_document_types = IdentityDocumentType::where('status',true)->get();

    }

    public function render()
    {
        $this->countries = Country::all();
        $this->universities = Universities::where('country',$this->country_id)->get();
        if($this->country_id == 'PE'){
            $this->ubigeo_active = true;
            
            $this->departments = Department::where('country_id',$this->country_id)->get();

            if($this->department_id){
                $this->provinces = Province::where('department_id',$this->department_id)->get();
            }
    
            if($this->province_id){
                $this->districts = District::where('province_id',$this->province_id)->get();
            }
            
        }else{
            $this->ubigeo_active = false;
        }
        
        
        return view('livewire.user.edit-information');
    }

    public function getDeparments(){
        if($this->country_id == 'PE'){
        $this->provinces = Province::where('department_id',$this->department_id)->get();
        }
    }
    public function getProvinces(){
        $this->provinces = Province::where('department_id',$this->department_id)->get();  
        $this->refreshSelect2s();
    }
    public function getUniversities(){
        $this->provinces = Province::where('department_id',$this->department_id)->get();  
        $this->universities = Universities::where('country',$this->country_id)->get();
        $this->refreshSelect2s();
    }

    public function getDistricts(){
        $this->districts = District::where('province_id',$this->province_id)->get();
        $this->refreshSelect2s();
    }

    public function refreshSelect2s(){
        $this->dispatchBrowserEvent('refreshSelect2s', ['success' => true]);
    }


    public function save(){

        $this->validate([
            'identity_document_type_id' => 'required',
            'number' => 'required',
            'names' => 'required|max:150',
            'last_name_father'=> 'required|max:150',
            'last_name_mother' => 'required|max:150',
            'address' => 'required',
            'sex' => 'required',
            'birth_date' =>'required',
            'email' => 'required',
            'country_id' => 'required',
            'university_id' => 'required'
            //'department_id' => 'required',
            //'province_id' => 'required',
            //'district_id' => 'required'
        ]);

        if($this->person){
            $this->person->update([
                'identity_document_type_id' => $this->identity_document_type_id,
                'number' => trim($this->number),
                'names' => trim($this->names),
                'last_name_father' => trim($this->last_name_father),
                'last_name_mother' => trim($this->last_name_mother),
                'full_name' => ($this->names.' '.$this->last_name_father.' '.$this->last_name_mother),
                'address' => trim($this->address),
                'mobile_phone' => trim($this->mobile_phone),
                'sex' => $this->sex,
                'birth_date' => $this->birth_date,
                'email' => trim($this->email),
                'department_id' => $this->department_id,
                'province_id' => $this->province_id,
                'district_id' => $this->district_id,
                'country_id' => $this->country_id,
                'university_id' => $this->university_id
            ]);
        }else{
            Person::create([
                'identity_document_type_id' => $this->identity_document_type_id,
                'number' => trim($this->number),
                'names' => trim($this->names),
                'last_name_father' => trim($this->last_name_father),
                'last_name_mother' => trim($this->last_name_mother),
                'full_name' => ($this->names.' '.$this->last_name_father.' '.$this->last_name_mother),
                'address' => trim($this->address),
                'mobile_phone' => trim($this->mobile_phone),
                'sex' => $this->sex,
                'birth_date' => $this->birth_date,
                'email' => trim($this->email),
                'department_id' => $this->department_id,
                'province_id' => $this->province_id,
                'district_id' => $this->district_id,
                'country_id' => $this->country_id,
                'university_id' => $this->university_id,
                'user_id' => Auth::id()
            ]);
        }

        $this->dispatchBrowserEvent('set-person-update', ['tit' => 'Enhorabuena','msg' => 'Se actualizó correctamente']);

        $this->exit();

    }
    public function exit(){
        redirect()->route('dashboard');
    }
}
