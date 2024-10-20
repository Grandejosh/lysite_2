<?php

namespace App\View\Components;

use Carbon\Carbon;
use Illuminate\View\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Header extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $courses;
    public $person_id;

    protected $listeners = ['CoursesOpenModal' => 'openModalCourses'];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.header', ['courses' => $this->getCourses()]);
    }
    public function getCourses()
    {
        $this->person_id = DB::table('people')->where('user_id', Auth::id())->value('id');
        $this->courses = DB::table('aca_courses')
            ->select(
                'aca_courses.id',
                'aca_courses.name',
                'aca_courses.course_image'
            )
            ->join('aca_students', 'aca_courses.id', '=', 'aca_students.course_id')
            ->where('aca_students.person_id', $this->person_id)
            ->where('aca_courses.status', 1)
            ->where('aca_students.registered_until', '>=', Carbon::createFromFormat('Y-m-d', date('Y-m-d')))
            ->distinct()
            ->get();
        //$this->courses=DB::table('Aca_courses')->get();
        return $this->courses;
    }

}
