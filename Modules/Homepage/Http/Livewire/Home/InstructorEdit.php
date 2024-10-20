<?php

namespace Modules\Homepage\Http\Livewire\Home;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Modules\Homepage\Entities\HomeInstructors;
use Livewire\WithFileUploads;

class InstructorEdit extends Component
{
    use WithFileUploads;

    public $name_instructor;
    public $image_path_last;
    public $image_path;
    public $career;
    public $content;
    public $instructor;

    public function mount ($id){
        $this->instructor = HomeInstructors::find($id);
        $this->name_instructor = $this->instructor->name_instructor;
        $this->image_path = $this->instructor->image_path;
        $this->image_path_last = $this->instructor->image_path;
        $this->career = $this->instructor->career;
        $this->content = $this->instructor->content;
    }

    public function render()
    {
        return view('homepage::livewire.home.instructor-edit');
    }

    public function save(){
        if ($this->image_path_last != $this->image_path) {
            $image_path = HomeInstructors::find($this->instructor->id)->image_path;
            Storage::disk('public')->delete(substr($image_path, 8));
            $this->image_path = 'storage/'.substr($this->image_path->store('public/uploads/homepage/instructors'), 7);
        }

        $this->instructor->update([
            'name_instructor' => $this->name_instructor,
            'image_path' => $this->image_path,
            'career' => $this->career,
            'content' => $this->content,
        ]);

        session()->flash('success', 'Instructor actualizado correctamente');
        return redirect()->route('homepage_instructors');
    }

    public function updatedPhoto()
    {
        $this->validate([
            'image_path' => 'image|max:10240',
        ]);
    }

    protected $rules = [
        'image_path' => 'required',
        'name_instructor' => 'required',
        'content' => 'required',
        'career' => 'required'
    ];

}
