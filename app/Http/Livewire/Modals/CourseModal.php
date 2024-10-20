<?php

namespace App\Http\Livewire\Modals;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class CourseModal extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $courses;

    public function render()
    {
        return view('livewire.modals.course-modal', ['courses' => $this->getCourses()]);
    }

    public function getCourses()
    {
        $this->courses=DB::table('Aca_courses')->paginate(2);
        return $this->courses;
    }

}
