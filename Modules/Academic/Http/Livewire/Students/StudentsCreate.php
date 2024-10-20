<?php

namespace Modules\Academic\Http\Livewire\Students;

use App\Models\IdentityDocumentType;
use Livewire\Component;
use App\Models\Department;
use App\Models\District;
use App\Models\Person;
use App\Models\Province;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Modules\Academic\Entities\AcaCourse;
use Modules\Academic\Entities\AcaStudent;

class StudentsCreate extends Component
{
    public $number;
    public $document_types;
    public $document_type_id;
    public $names = null;
    public $last_name_father = null;
    public $last_name_mother = null;
    public $birth_date = null;
    public $email = null;
    public $department_id = null;
    public $province_id = null;
    public $district_id = null;
    public $address = null;
    public $mobile_phone = null;
    public $sex = null;
    public $status = true;
    public $departments = [];
    public $provinces = [];
    public $districts = [];
    public $person;
    public $courses = [];
    public $course_id = null;
    public $student_courses = [];
    public $full_name;

    public function mount()
    {
        $this->document_types = IdentityDocumentType::where('status', true)->get();
        $this->departments = Department::where('active', true)->get();
        $this->courses = AcaCourse::where('status', true)->get();
    }

    public function render()
    {
        return view('academic::livewire.students.students-create');
    }

    public function getProvinces()
    {
        $this->provinces = Province::where('department_id', $this->department_id)->get();
    }

    public function getDistricts()
    {
        $this->districts = District::where('province_id', $this->province_id)->get();
    }

    public function searchDni()
    {
        $this->person = Person::where('identity_document_type_id', $this->document_type_id)
            ->where('number', $this->number)
            ->first();

        if ($this->person) {
            $this->document_type_id = $this->person->identity_document_type_id;
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

            if ($this->department_id) {
                $this->provinces = Province::where('department_id', $this->department_id)->get();
            }

            if ($this->province_id) {
                $this->districts = District::where('province_id', $this->province_id)->get();
            }

            $student_courses = AcaStudent::join('aca_courses', 'aca_students.course_id', 'aca_courses.id')
                ->select('aca_courses.id', 'aca_courses.name')
                ->where('person_id', $this->person->id)
                ->get();
            if ($student_courses) {
                $this->student_courses = $student_courses->toArray();
            }

            $this->dispatchBrowserEvent('aca-person-notnull', ['tit' => 'Enhorabuena', 'msg' => 'Este alumno ya existe']);
        } else {
            $this->dispatchBrowserEvent('aca-person-null', ['tit' => 'Este alumno aún no ha sido registrado', 'msg' => 'Deseas registrarlo']);
        }
    }


    public function save()
    {

        $this->validate([
            'document_type_id' => 'required',
            'names' => 'required|max:150',
            'last_name_father' => 'required|max:150',
            'last_name_mother' => 'required|max:150',
            'address' => 'required',
            'sex' => 'required',
            'birth_date' => 'required',
            'email' => 'required',
            'department_id' => 'required',
            'province_id' => 'required',
            'district_id' => 'required'
        ]);

        if ($this->person) {

            $this->validate([
                'number' => 'required|max:12|unique:people,number,' . $this->person->id . ',id,identity_document_type_id,' . $this->document_type_id
            ]);

            $this->person->update([
                'identity_document_type_id' => $this->document_type_id,
                'number' => $this->number,
                'names' => $this->names,
                'last_name_father' => $this->last_name_father,
                'last_name_mother' => $this->last_name_mother,
                'full_name' => ($this->names . ' ' . $this->last_name_father . ' ' . $this->last_name_mother),
                'address' => $this->address,
                'mobile_phone' => $this->mobile_phone,
                'sex' => $this->sex,
                'birth_date' => $this->birth_date,
                'email' => $this->email,
                'department_id' => $this->department_id,
                'province_id' => $this->province_id,
                'district_id' => $this->district_id,
                'allowed_thesis' => $this->person->allowed_thesis + 1,
            ]);
        } else {

            $this->validate([
                'number' => 'required|max:12|unique:people,number,NULL,id,identity_document_type_id,' . $this->document_type_id
            ]);

            $user = User::create([
                'name' => $this->names,
                'email' => $this->email,
                'password' => Hash::make('12345678')
            ]);

            $user->assignRole('Student');

            $this->person = Person::create([
                'identity_document_type_id' => $this->document_type_id,
                'number' => $this->number,
                'names' => $this->names,
                'last_name_father' => $this->last_name_father,
                'last_name_mother' => $this->last_name_mother,
                'full_name' => ($this->names . ' ' . $this->last_name_father . ' ' . $this->last_name_mother),
                'address' => $this->address,
                'mobile_phone' => $this->mobile_phone,
                'sex' => $this->sex,
                'birth_date' => $this->birth_date,
                'email' => $this->email,
                'department_id' => $this->department_id,
                'province_id' => $this->province_id,
                'district_id' => $this->district_id,
                'user_id' => $user->id,
                'allowed_thesis' => 1
            ]);
        }

        AcaStudent::where('person_id', $this->person->id)->delete();

        foreach ($this->student_courses as $student_course) {
            $aca_student = AcaStudent::where('person_id', $this->person->id)
                ->where('course_id', $student_course['id'])
                ->exists();
            if (!$aca_student) {
                AcaStudent::create([
                    'person_id' => $this->person->id,
                    'course_id' => $student_course['id']
                ]);
            }
        }

        $this->dispatchBrowserEvent('aca-student-update', ['tit' => 'Enhorabuena', 'msg' => 'Se actualizó correctamente']);
    }

    public function addCourse()
    {

        $key = array_search($this->course_id, array_column($this->student_courses, 'id'));
        if ($key === false) {

            $course = AcaCourse::find($this->course_id);

            array_push($this->student_courses, array('id' => $course->id, 'name' => $course->name));
        }
    }

    public function removeCourse($index, $course_id)
    {
        unset($this->student_courses[$index]);
        AcaStudent::where('person_id', $this->person->id)
            ->where('course_id', $course_id)
            ->delete();

        $res = 'success';
        $tit = 'Enhorabuena';
        $msg = 'Se eliminó correctamente';

        $this->dispatchBrowserEvent('set-module-delete', ['res' => $res, 'tit' => $tit, 'msg' => $msg]);
    }
    public function backStudents()
    {
        redirect()->route('academic_students');
    }
}
