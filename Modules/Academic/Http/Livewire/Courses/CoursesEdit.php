<?php

namespace Modules\Academic\Http\Livewire\Courses;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Academic\Entities\AcaCourse;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class CoursesEdit extends Component
{
    use WithFileUploads;
    public $course;
    public $name;
    public $description;
    public $status = true;
    public $course_image;
    public $course_image_last;
    public $main_video;
    public $course_id;

    public function mount($course_id){
        $this->course = AcaCourse::find($course_id);
        $this->name = $this->course->name;
        $this->description = $this->course->description;
        $this->status = $this->course->status;
        $this->course_image = $this->course->course_image;
        $this->course_image_last = $this->course_image;
        $this->main_video = $this->course->main_video;
    $this->course_id = $course_id;
    }

    public function render()
    {
        return view('academic::livewire.courses.courses-edit');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    protected $rules = [
        'name' => 'required|max:255',
        'description' => 'required',
        'course_image' => 'required|max:10240|mimes:jpeg,jpg,png,gif',
        'main_video' => 'required'
    ];

    public function update(){

        $this->validate([
            'name' => 'unique:aca_courses,name,'.$this->course->id,
        ]);
        if($this->course_image_last != $this->course_image){
            $course_image=AcaCourse::find($this->course_id)->course_image;
            Storage::disk('public')->delete(substr($course_image, 8));
            $this->course_image = 'storage/'.substr($this->course_image->store('public/uploads/academic/courses'), 7);    // <----------------------Solo para archivos e imagenes-------------------------------------------
        }
        /*
        $course_image=AcaCourse::find($this->course_id)->course_image;
        Storage::disk('public')->delete(substr($course_image, 8));
        $this->course_image = 'storage/'.substr($this->course_image->store('public/uploads/academic/courses'), 7);    // <----------------------Solo para archivos e imagenes-------------------------------------------
        */
        $this->course->update([
            'name' => trim($this->name),
            'description' => trim($this->description),
            'status' => $this->status ? true : false,
            'course_image' => $this->course_image,
            'main_video' => trim($this->main_video),
            'updated_by' => Auth::id()
        ]);
        $this->course_image=null;
        $this->main_video=null;
        $this->name = null;
        $this->description = null;
        $this->dispatchBrowserEvent('aca-courses-update', ['tit' => 'Enhorabuena','msg' => 'Se Actualizo correctamente']);

    }

    public function back(){
        redirect()->route('academic_courses');
    }
}
