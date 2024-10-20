<?php

namespace Modules\Academic\Http\Livewire\Students;

use Livewire\Component;
use App\Models\Department;
use App\Models\District;
use App\Models\Person;
use App\Models\Province;
use Modules\Academic\Entities\AcaCourse;
use Modules\Academic\Entities\AcaStudent;
use App\Models\IdentityDocumentType;
use DateTime;
use Illuminate\Support\Facades\DB;

class StudentsEdit extends Component
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
    public $registered_until = null;
    public $status_student = 1;
    public $full_name;

    public function mount($student_id)
    {
        $this->document_types = IdentityDocumentType::where('status', true)->get();
        $this->departments = Department::where('active', true)->get();
        $this->courses = AcaCourse::where('status', true)->get();

        $this->person = Person::find($student_id);

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
        $this->registered_until =  now()->toDateTimeString();


        if ($this->department_id) {
            $this->provinces = Province::where('department_id', $this->department_id)->get();
        }

        if ($this->province_id) {
            $this->districts = District::where('province_id', $this->province_id)->get();
        }

        $student_courses = AcaStudent::join('aca_courses', 'aca_students.course_id', 'aca_courses.id')
            ->select('aca_courses.id', 'aca_courses.name', 'aca_students.registered_until as registered_until', 'aca_students.status')
            ->where('person_id', $this->person->id)
            ->get();
        if ($student_courses) {
            $this->student_courses = $student_courses->toArray();
        }
    }

    public function render()
    {
        return view('academic::livewire.students.students-edit');
    }

    public function save()
    {

        $this->validate([
            'document_type_id' => 'required',
            'number' => 'required|max:12|unique:people,number,' . $this->person->id . ',id,identity_document_type_id,' . $this->document_type_id,
            'names' => 'required|max:150',
            'last_name_father' => 'required|max:150',
            'last_name_mother' => 'required|max:150',
            'address' => 'required',
            'sex' => 'required',
            'birth_date' => 'required',
            'email' => 'required',
            'department_id' => 'required',
            'province_id' => 'required',
            'district_id' => 'required',
            'registered_until' => 'required',
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
        ]);

        /* AcaStudent::where('person_id', $this->person->id)->delete(); */

        foreach ($this->student_courses as $student_course) {
            $aca_student = AcaStudent::where('person_id', $this->person->id)
                ->where('course_id', $student_course['id'])
                ->exists();
            if (!$aca_student) { //si no existe crea al estudiante
                AcaStudent::create([
                    'person_id' => $this->person->id,
                    'course_id' => $student_course['id'],
                    'registered_until' => date('Y-m-d H:i:s', strtotime('+0 day', strtotime($student_course['registered_until']))), //$student_course['registered_until']
                    'status' => $student_course['status']
                ]);
            }else{
                $aca_student = AcaStudent::where('person_id', $this->person->id)
                ->where('course_id', $student_course['id'])->get()->first()->id;
                $aca_student = AcaStudent::find($aca_student);

                $aca_student->update([
                    'person_id' => $this->person->id,
                    'course_id' => $student_course['id'],
                    'registered_until' => new DateTime($student_course['registered_until']),
                    'status' => $student_course['status']
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

            array_push($this->student_courses, array(
                'id' => $course->id,
                'name' => $course->name,
                'registered_until' => $this->registered_until,
                'status' => $this->status_student
            ));
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
    public function updateDate($index, $date){ //actualiza las fechas cuando se cambia en el elemento de la vista.
        $this->student_courses[$index]['registered_until']=date('Y-m-d', strtotime($date));
    }
}
