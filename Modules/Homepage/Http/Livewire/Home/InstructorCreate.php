<?php

namespace Modules\Homepage\Http\Livewire\Home;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Homepage\Entities\HomeInstructors;

class InstructorCreate extends Component
{
    use WithFileUploads;

    public $name_instructor;
    public $image_path;
    public $career;
    public $content;

    public function render()
    {
        return view('homepage::livewire.home.instructor-create');
    }

    public function save()
    {
        $this->validate();
        $this->image_path = 'storage/' . substr($this->image_path->store('public/uploads/homepage/instructors'), 7);
        /*
        HomeInstructors::create([
            'name_instructor' => $this->name_instructor,
            'image_path' => $this->image_path,
            'career' => $this->career,
            'content' => $this->content,
        ]);
        */
        $instructor = new HomeInstructors();
        $instructor->name_instructor = $this->name_instructor;
        $instructor->image_path = $this->image_path;
        $instructor->career = $this->career;
        $instructor->content = $this->content;
        $instructor->save();

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
