<?php

namespace Modules\Academic\Http\Livewire\Courses;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Academic\Entities\AcaCourse;
use Modules\Academic\Entities\AcaCourseRating;
use Livewire\WithFileUploads;

class CoursesCreate extends Component
{
    use WithFileUploads;
    public $name;
    public $description;
    public $status = true;
    public $course_image;
    public $main_video;

    public function render()
    {
        return view('academic::livewire.courses.courses-create');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    protected $rules = [
        'name' => 'required|max:255|unique:aca_courses,name',
        'course_image' => 'required|max:20240|mimes:jpeg,jpg,png,gif',
        'description' => 'required',
        'main_video' => 'required'
    ];

    public function save()
    {

        $this->validate();
        if ($this->course_image) {
            $this->course_image = 'storage/' . substr($this->course_image->store('public/uploads/academic/courses'), 7);    // <----------------------Solo para archivos e imagenes-------------------------------------------
            $newCourse = AcaCourse::create([
                'name' => trim($this->name),
                'description' => trim($this->description),
                'status' => $this->status ? true : false,
                'course_image' => $this->course_image,
                'main_video' => trim($this->main_video),
                'created_by' => Auth::id()
            ]);

            //Luego de crear el curso se crea un registro en la tabla aca_course_ratings para que se pueda calificar el curso
            AcaCourseRating::create([
                'course_id' => $newCourse->id,
                'rating' => 5,
                'voters' => 0
            ]);


            $this->name = null;
            $this->description = null;
            $this->status = true;
            $this->course_image = null;
            $this->main_video = null;

            $this->dispatchBrowserEvent('aca-courses-create', ['tit' => 'Enhorabuena', 'msg' => 'Se registró correctamente']);
        } else {
            $this->dispatchBrowserEvent('aca-courses-create', ['tit' => 'Error', 'msg' => 'Elejir una imagen']);
        }
    }
    public function back()
    {
        redirect()->route('academic_courses');
    }
}
